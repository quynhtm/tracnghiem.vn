<?php
/**
 * Created by IntelliJ IDEA.
 * User: namnv
 * Date: 6/6/18
 * Time: 8:17 PM
 */

namespace App\Http\Controllers\Service;


use DateTime;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Longtt\Vaytien\Events\VMContractEvent;
use Longtt\Vaytien\Events\VMPlusBorrowerPointEvent;
use Longtt\Vaytien\Helper;
use Longtt\Vaytien\Model\Contract;
use Longtt\Vaytien\Model\Contract_document_entity;
use Longtt\Vaytien\Model\Contract_document_entity_attribute_value;
use Longtt\Vaytien\Model\Device_app;
use Longtt\Vaytien\Model\Loan;
use Longtt\Vaytien\Model\Loaner;
use Longtt\Vaytien\Model\Notification;
use Monolog\Logger;
use VM\LoanSplit\Service\VMAutoLoanSplit;
use VM\Notification\Api\VMNotification;

class VMLoanService
{
    private $logger;

    private $_contract;

    private $_loan;

    private $_notification;

    private $notificationService;

    private $smsService;

    private $deviceApp;

    private $optionPoints;

    private $requirePoints;

    /**
     * VMLoanService constructor.
     */
    public function __construct()
    {
        $this->logger = new Logger('VMLoanService');

        $this->_contract = new Contract();

        $this->_loan = new Loan();

        $this->_notification = new Notification();

        $this->notificationService = new VMNotification();

        #$this->smsService = new VMSmsService();

        $this->deviceApp = new Device_app();

        $this->optionPoints = env('OPTION_POINT', 5);

        $this->requirePoints = env('REQUIRE_POINT', 10);
    }

    private function createContract($model, $status) {

        try {
            DB::beginTransaction();
            $this->isCheckingContract($model->id, $model->loaner_id);
            $model->status = $status;
            $model->save();

            // Tạo hợp đồng
            $contract = new Contract();
            $contract->loaner_id = $model->loaner_id;
            $contract->loaner_name = $model->loaner->full_name;
            $contract->loaner_code = $model->loaner->code;
            $contract->loaner_career = isset($model->loaner->career[0]) ? $model->loaner->career[0]->name : "";
            $contract->loaner_address = $model->loaner->full_address;
            $contract->loaner_facebook_id = $model->loaner->facebook_id;
            $contract->product_id = $model->product_id;
            $contract->loan_id = $model->id;
            $contract->loan_code = $model->code;
            $contract->payment_method_id = $model->payment_method_id;
            $contract->contract_document_entity_id = $model->document_entity_id;
            $contract->amount = $model->amount;
            $contract->duration = $model->duration;
            $contract->approve_amount = $model->approve_amount;
            $contract->approve_duration = $model->approve_duration;
            $contract->type_duration = $model->type_duration;
            $contract->fee_rate = $model->fee_rate;
            $contract->interest_rate = $model->interest_rate;
            $contract->sale_interest_rate = $model->sale_interest_rate;
            $contract->ensure_rate = $model->ensure_rate;
            $contract->total_interest = $model->total_interest;
            $contract->status = "cho_giai_ngan";
            $contract->history = $model->history;
            $contract->comment = $model->comment;
            $contract->user_id = $model->user_id;
            $contract->user_name = $model->user_name;
            $contract->accepted_date = $model->accepted_date;
            $contract->disbursed_date = $model->disbursed_date;
            $contract->promotion = !empty($model->promotion_value) ? $model->promotion_value : ($model->reference_value ? $model->reference_value : $model->charge_value);
            $contract->save();

            DB::commit();
            return $contract;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function acceptLoan($request)
    {
        $id = $request->input('id');
        $model = $this->_loan->find($id);

        if (count($model->loaner) > 0 && $request->input("status") == 'hoan_thanh' && !$model->contract && $model->status == 'cho_khe_uoc') {
            try {
                $this->_contract = $this->createContract($model, $request->input("status"));

                DB::beginTransaction();
                $this->_contract->code = 'HDV-' . $this->_contract->id . "-" . Helper::getCurrentDate();
                $this->_contract->save();
                Cache::put("duyetkheuoc.'$id'", $id, 1);
                $point = 0;
                $document_entities = $model->document_entity;
                foreach ($document_entities as $key => $document_entity) {

                    $contract_document_entity = new Contract_document_entity();
                    $contract_document_entity->loaner_id = $document_entity->loaner_id;
                    $contract_document_entity->contract_id = $this->_contract->id;
                    $contract_document_entity->document_type_id = $document_entity->document_type_id;
                    $contract_document_entity->document_type_code = $document_entity->document_type_code;
                    $contract_document_entity->document_type_name = $document_entity->document_type_name;
                    $contract_document_entity->document_type_purpose = $document_entity->document_type_purpose;
                    $contract_document_entity->document_type_description = $document_entity->document_type_description;
                    $contract_document_entity->require = $document_entity->require;
                    $contract_document_entity->display = $document_entity->display;
                    $contract_document_entity->status = $document_entity->status;
                    $contract_document_entity->created_at = $document_entity->created_at;
                    $contract_document_entity->updated_at = $document_entity->updated_at;
                    $contract_document_entity->save();

                    if ($document_entity->require == 'require') {
                        $point += $this->requirePoints;
                    } else {
                        if ($document_entity->status == 'duyet') {
                            $point += $this->optionPoints;
                        }
                    }
                    foreach ($document_entity->document_entity_attribute_value as $key2 => $document_entity_attribute_value) {

                        $contract_document_entity_value = new Contract_document_entity_attribute_value();
                        $contract_document_entity_value->contract_document_entity_id = $contract_document_entity->id;
                        $contract_document_entity_value->document_entity_id = $document_entity_attribute_value->document_entity_id;
                        $contract_document_entity_value->loaner_id = $document_entity_attribute_value->loaner_id;
                        $contract_document_entity_value->document_entity_attribute_id = $document_entity_attribute_value->document_entity_attribute_id;
                        $contract_document_entity_value->document_entity_attribute_code = $document_entity_attribute_value->document_entity_attribute_code;
                        $contract_document_entity_value->document_entity_attribute_name = $document_entity_attribute_value->document_entity_attribute_name;
                        $contract_document_entity_value->document_type_id = $document_entity_attribute_value->document_type_id;
                        $contract_document_entity_value->document_type_code = $document_entity_attribute_value->document_type_code;
                        $contract_document_entity_value->document_type_name = $document_entity_attribute_value->document_type_name;
                        $contract_document_entity_value->document_entity_attribute_input_type = $document_entity_attribute_value->document_entity_attribute_input_type;
                        $contract_document_entity_value->document_entity_attribute_input_data = $document_entity_attribute_value->document_entity_attribute_input_data;
                        $contract_document_entity_value->value = $document_entity_attribute_value->value;
                        $contract_document_entity_value->status = $document_entity_attribute_value->status;
                        $contract_document_entity_value->save();
                    }
                }

                //Bắn Notification
                $this->sendNotificationForLoan($model);//tạo yêu cầu vay nhà đầu tư

                DB::commit();

                //event to create contract/loan_contract...
                $this->logger->info('acceptLoan |=====================>>> ', [$this->_contract->id]);
                event(new VMContractEvent($this->_contract->id));

                //event to plus point
//                if (!$this->checkBorrowerPlusPoints($model->loaner_id)) {
//                    event(new VMPlusBorrowerPointEvent($model->loaner_id, 1, $point));
//                }
                event(new VMPlusBorrowerPointEvent($model->loaner_id, 8, $point));
                // cộng point cho người đi giới thiệu
                if($model->reference_code != null){
                    event(new VMPlusBorrowerPointEvent($model->reference_code, 7, 5));
                }

                return 1;

            } catch (Exception $e) {
                $this->logger->info('message |====>>', [$e->getMessage()]);
                DB::rollBack();
                throw $e;
            }
        } else {
            return 0;
        }
    }

    private function checkBorrowerPlusPoints($borrower_id)
    {
        $count = Loaner::where('is_first_use', 1)->where('id', $borrower_id)->count();
        return ($count > 0);
    }

    private function isCheckingContract($loan_id, $loaner_id)
    {
        $count = Contract::where('loan_id', $loan_id)
            ->where('loaner_id', $loaner_id)
            ->count('id');
        if ($count > 0) {
            throw new Exception('Contract is existed in the system');
        }
    }

    private function sendNotificationForLoan($loan)
    {
        try {
            $message = __('Khoản vay đã được xác nhận thành công. Xin vui lòng chờ nhận tiền vay!');

            $data = $this->buildNotificationData($loan->loaner, $loan->id, $message, 1);

            $this->_notification->insert($data);

            $device = $this->deviceApp->where('loaner_id', $loan->loaner->app_id)->where('operating_system', 'android')->first();
            //TODO: send notification
            $registrationIds[] = $loan->loaner->app_id;
            $app_id = $loan->loaner->app_id;
            if ($app_id) {
                $this->notificationService->pushNotificationToDevices($registrationIds, 1, $message, $device == null ? 1 : 0);
            }

            return 1;
        } catch (Exception $e) {
            $this->logger->info('sendNotificationForLoan |===========>> ', [$e->getMessage()]);
        }
        return 0;
    }

    public function refuseLoan($loan)
    {
        try {
            DB::beginTransaction();
            $loan->save();
            #===================================================================
            # Cap nhat trang thai huy yeu cau vay se khong chia nua ============
            #===================================================================
            if (VMAutoLoanSplit::$usesplit):
                VMAutoLoanSplit::setCancelAutoLoanByStatus($loan->id, $loan->status);
            endif;
            #===================================================================

            if (count($loan->loaner) > 0) {
                $message = __("YCV của Qúy khách đã bị Từ chối bởi Vaymuon");
                $app_ids = [];
                $room = 0;
                array_push($app_ids, $loan->loaner->app_id);
                $device = $this->deviceApp->where('loaner_id', $loan->loaner->app_id)->where('operating_system', 'android')->first();
                $app_id = $loan->loaner->app_id;
                if ($app_id) {
                    $this->notificationService->pushNotificationToDevices($app_ids, 0, $message, $device == null ? 1 : 0);
                    $data = $this->buildNotificationData($loan->loaner, $loan->id, $message, $room);;
                    $notification = new Notification();
                    $notification->insert($data);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function approvalLoan($loan)
    {
        try {
            DB::beginTransaction();
            $loan->save();
            #$this->smsService->sendMsgForLoanerWhenDuyetThamDinh2($loan);
            try {
                if (count($loan->loaner) > 0) {
                    $message = $this->buildMessage($loan);
                    $app_ids = [];
                    $room = 0;
                    array_push($app_ids, $loan->loaner->app_id);
                    $device = $this->deviceApp->where('loaner_id', $loan->loaner->app_id)->where('operating_system', 'android')->first();
                    $app_id = $loan->loaner->app_id;
                    if ($app_id) {
                        $this->notificationService->pushNotificationToDevices($app_ids, 0, $message, $device == null ? 1 : 0);
                        $data = $this->buildNotificationData($loan->loaner, $loan->id, $message, $room);
                        $notification = new Notification();
                        $notification->insert($data);
                    }
                }
            } catch (Exception $ex) {

            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function buildMessage($loan)
    {
        $loaner = $loan->loaner;

        $document_entity_attribute_value = $loaner->document_entity_attribute_value;

        $SoHoChieu = '';

        $ngan_hang = '';

        $so_tai_khoan = '';

        foreach ($document_entity_attribute_value as $value) {
            if ($value['document_entity_attribute_code'] == 'nhap_so_can_cuoc') {
                $SoHoChieu = $value['value'];
            }
            if ($value['document_entity_attribute_code'] == 'chon_ngan_hang') {
                $ngan_hang = $value['value'];
            }
            if ($value['document_entity_attribute_code'] == 'so_tai_khoan_ngan_hang') {
                $so_tai_khoan = $value['value'];
            }
        }

        $NgayTraNo = Helper::getAddDate3($loan->disbursed_date, $loan->approve_duration - 1);
        $ten_ngan_hang = Helper::$listBank[$ngan_hang];
        $SoTienDuyet = number_format($loan->approve_amount);
        $SoNgayDuyet = $loan->approve_duration;
        $SoTienPhaiTra = number_format($loan->totalNeedToPay());
        $TenNguoiVay = $loan->loaner->full_name;

        $noi_dung_khe_uoc = "[VAYMUON TB] HS của anh/chị đã được duyệt khoản vay $SoTienDuyet VNĐ, thời hạn $SoNgayDuyet Ngày,qua số tài khoản $so_tai_khoan tại ngân hàng $ten_ngan_hang, tổng số tiền cần thanh toán khi đến hạn là $SoTienPhaiTra VNĐ.\n Anh/chị vui lòng tự quay video theo mẫu và tải lên file đính kèm tại mục Hồ sơ/video xác nhận nợ trên app Vay Mượn trước 11h (sáng) hoặc trước 15h (chiều) để được nhận khoản vay nhanh nhất.\n Lưu ý: Anh/chị quay video rõ mặt, rõ tiếng, đầy đủ nội dung, cuối video có quay rõ 2 mặt CMT. Vui lòng inbox facebook vaymuon.vn hoặc liên hệ hotline 1900-2094 để được hỗ trợ.\n MẪU NỘI DUNG VIDEO XÁC NHẬN NHƯ SAU:\n Tôi tên là: $TenNguoiVay, CMT số: $SoHoChieu\n Thông qua Ứng dụng  giới thiệu vay online, tôi đã nhận đủ số tiền vay vốn là $SoTienDuyet đồng, thời gian vay $SoNgayDuyet ngày, tôi cam kết đến ngày $NgayTraNo sẽ trả đầy đủ số tiền gồm gốc, lãi và phí dịch vụ, tổng cộng $SoTienPhaiTra đồng.\n Tôi đã đọc, đồng ý mọi điều khoản của bên cho vay và cam kết trả nợ đúng hạn. Nếu sai tôi xin chịu hoàn toàn trách nhiệm trước pháp luật, chịu mọi hình thức phạt và thu hồi nợ.\n Đây là chứng minh thư của tôi (quay rõ 2 mặt)";

        return $noi_dung_khe_uoc;
    }

    public function sendNotificationHandMade($loan, $message)
    {
        if (count($loan->loaner) > 0) {
            try {
                $data = $this->buildNotificationData($loan->loaner, $loan->id, $message);
                $app_ids = [];

                $this->logger->info('data', [$data]);

                array_push($app_ids, $loan->loaner->app_id);

                $device = $this->deviceApp->where('loaner_id', $loan->loaner->app_id)->where('operating_system', 'android')->first();

                $this->logger->info('$device', [$device]);
                $app_id = $loan->loaner->app_id;
                if ($app_id) {
                    $this->notificationService->pushNotificationToDevices($app_ids, 0, $message, $device == null ? 1 : 0);
                    $this->_notification->insert($data);
                }


                return 1;
            } catch (Exception $e) {
                $this->logger->info('cancelLoan', [$e->getMessage()]);
            }
        }
        return 0;
    }

    public function reviewLoanDocuments($loan)
    {
        try {
            $document_entity_cancel = $loan->document_entity()->where('status', '=', 'loai')->get();

            $application = '';
            if (count($document_entity_cancel) > 0) {
                if (!in_array($loan->status, ['cho_khe_uoc'])) {
                    $loan->status = 'moi';
                    $loan->save();

                    # Xoa ycv khoi bang da chia nhung chua co van han
                    if (VMAutoLoanSplit::$usesplit):
                        VMAutoLoanSplit::setStatusAutoLoan($loan->id, 'moi');
                        VMAutoLoanSplit::delLoanInFree($loan->id);
                    endif;
                }
                foreach ($document_entity_cancel as $value) {
                    $application = $application . $value->document_type_name . ",";
                }
            }
            if (count($loan->loaner) > 0 && !in_array($loan->status, ['huy', 'tu_choi'])) {
                $loan->status_profile = '0';
                $loan->save();
            }

            $message = __("Yêu cầu vay có hồ sơ bị từ chối do chưa đạt yêu cầu !", [
                'MaYCV' => $loan->code,
                'TenHoSo' => $application
            ]);

            $data = $this->buildNotificationData($loan->loaner, $loan->id, $message);

            $device = $this->deviceApp->where('loaner_id', $loan->loaner->app_id)->where('operating_system', 'android')->first();

            $app_ids = [];
            array_push($app_ids, $loan->loaner->app_id);
            $app_id = $loan->loaner->app_id;
            if ($app_id) {
                $this->notificationService->pushNotificationToDevices($app_ids, 0, $message, $device == null ? 1 : 0);
                $this->_notification->insert($data);
            }

            return 1;
        } catch (Exception $e) {
            $this->logger->info('reviewLoanDocuments |=========>>>', [$e->getMessage()]);
        }
        return 0;
    }


    public function thongBaoLoaiHoSo($model, $count_document_entity_cancel)
    {
        if ($count_document_entity_cancel > 0) {
            $sendNotifi = Notification::sendForLoanTB6($model);
        }

    }


    public function cancelLoan($request)
    {
        try {
            $id = $request->input('id');
            $this->logger->info('cancelLoan |===============>> ', [$id]);
            $loan = $this->_loan->find($id);
            if (count($loan->loaner) > 0 && $request->input("status") == 'huy'
                && in_array($loan->status, array("moi", "dang_cap_nhat", "cho_duyet_cap_1", "tham_dinh_1", "tham_dinh_2", "cho_khe_uoc"))) {
                $loan->status = $request->input("status");
                $loan->rejection_reason = $request->input("rejection_reason");

                DB::beginTransaction();

                $loan->save();
                #===================================================================
                # Cap nhat trang thai huy yeu cau vay se khong chia nua ============
                #===================================================================
                if (VMAutoLoanSplit::$usesplit):
                    VMAutoLoanSplit::setCancelAutoLoanByStatus($loan->id, $loan->status);
                endif;
                #===================================================================

                $loaner_name = $loan->loaner->full_name;
                $message = "Chào $loaner_name, hồ sơ của $loaner_name bị hủy trên hệ thống do hồ sơ chưa đạt yêu cầu.$loaner_name vui lòng thoát khỏi ứng dụng, đăng nhập lại bằng facebook chính chủ đang hoạt động, cập nhật hồ sơ đầy đủ, chấp nhận mọi điều khoản trên ứng dụng để tránh phát sinh lỗi và được duyệt hồ sơ.Mọi thắc mắc xin vui lòng liên hệ 1900 2094 hoặc email: admin@vaymuon.vn";
                $app_ids = [];
                $room = 0;
                array_push($app_ids, $loan->loaner->app_id);
                $this->logger->info('cancelLoan |=0==============>> ', [$app_ids]);
                $device = $this->deviceApp->where('loaner_id', $loan->loaner->app_id)->where('operating_system', 'android')->first();

                try {

                    $app_id = $loan->loaner->app_id;
                    if ($app_id) {
                        $this->notificationService->pushNotificationToDevices($app_ids, $room, $message, $device == null ? 1 : 0);
                        $data = $this->buildNotificationData($loan->loaner, $loan->id, $message, $room);
                        $notification = new Notification();
                        $notification->insert($data);
                    }
                } catch (Exception $e) {
                    $this->logger->info('cancelLoan', [$e->getMessage()]);
                }

                DB::commit();

                return 0;
            } else {
                return -1;
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug('cancelLoan |=================>> ' . $e->getMessage());
        }
        return -1;
    }

    private function buildNotificationData($borrower, $loan_id, $message, $room = 0)
    {
        return [
            "registration_ids" => $borrower->app_id,
            "loaner_id" => $borrower->id,
            "loan_id" => $loan_id,
            "contract_id" => '',
            "repayment_id" => '',
            "type" => 1,
            "time" => new DateTime(),
            "Room" => $room,
            "title" => "vaymuon.vn",
            "body" => $message,
            'data' => '',
            "status" => 'thanh_cong',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ];
    }
}