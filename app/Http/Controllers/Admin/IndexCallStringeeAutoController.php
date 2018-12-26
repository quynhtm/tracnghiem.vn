<?php
namespace App\Http\Controllers\LogCall;

use App\Http\Controllers\BaseAdminController;
use Illuminate\Support\Facades\Request;
use App\Http\Models\Admin\ReminderBorrower;
use App\Services\LogCall\LogCallHistoryService;

class IndexCallStringeeAutoController extends BaseAdminController {
    public $schedule_option = array(
        '08' => 'VM2018_B_7_', //Trước hạn 7 ngày
        '09' => 'VM2018_B_5_', //Trước hạn 5 ngày
        '10' => 'VM2018_B_3_', //Trước hạn 3 ngày
        '11' => 'VM2018_0_',    //Đến hạn
        '14' => 'VM2018_0_',    //Đến hạn
        '16' => 'VM2018_0_',    //Đến hạn
        '13' => 'VM2018_DL_1_', //Quá hạn 1 ngày
        '18' => 'VM2018_DL_1_', //Quá hạn 1 ngày
        '12' => 'VM2018_DL_3_', //Quá hạn 3 ngày
        '19' => 'VM2018_DL_3_', //Quá hạn 3 ngày
        '15' => 'VM2018_DL_7_', //Quá hạn 7 ngày
        '20' => 'VM2018_DL_7_', //Quá hạn 7 ngày
    );
    public function index(){
        $to_number = Request::get('toPhone', '');

        $_from_date = Request::get('dateFrom', '');
        if($_from_date == ''){$_from_date = date('m/d/Y', time());}
        $from_date =  strtotime($_from_date. ' 00:00:00');

        $_to_date = Request::get('dateTo', '');
        if($_to_date == ''){$_to_date = date('m/d/Y', time());}
        $to_date = strtotime($_to_date.' 23:59:59');

        $dataSearch['to_number'] = $to_number;
        $dataSearch['from_date'] = $from_date;
        $dataSearch['to_date'] = $to_date;
        $limit = Request::get('limit', 200);
        $records = app(ReminderBorrower::class)->searchByConditionPG($dataSearch, $limit);

        if(sizeof($records) > 0){
            foreach($records as $item){
                $callId = $item->call_id;
                $dataGetStringee = $this->getInfoCall($callId);
                $this->updateInfoCallId($item->id, $dataGetStringee);
            }
        }

        //Export excel
        $exportExcel = Request::get('exportExcel', 0);
        if($exportExcel == 2){
            return $this->exportExcel($records, $from_date, $to_date);
        }

        $countGroupCall = $this->countGroupCall($records);
        return view('vaytien::LogCall.index_report_auto_call_reminder', [
            'records'=>$records,
            'schedule_option'=>$this->schedule_option,
            'countGroupCall'=>$countGroupCall,
        ]);
    }
    public function countGroupCall($data = array()){
        $result = array(
            'total' => array(
                'total' => count($data),
                'success' => 0,
                'miss' => 0
            ),
            'truoc_han_7' => array(
                'total' => 0,
                'success' => 0,
                'miss' => 0
            ),
            'truoc_han_5' => array(
                'total' => 0,
                'success' => 0,
                'miss' => 0
            ),
            'truoc_han_3' => array(
                'total' => 0,
                'success' => 0,
                'miss' => 0
            ),
            'den_han' => array(
                'total' => 0,
                'success' => 0,
                'miss' => 0
            ),
            'qua_han_1' => array(
                'total' => 0,
                'success' => 0,
                'miss' => 0
            ),
            'qua_han_3' => array(
                'total' => 0,
                'success' => 0,
                'miss' => 0
            ),
            'qua_han_7' => array(
                'total' => 0,
                'success' => 0,
                'miss' => 0
            )
        );
        if(sizeof($data) > 0) {
            foreach ($data as $item) {
                $check_truoc_han_7 = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_B_7_', $this->schedule_option);
                $check_truoc_han_5 = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_B_5_', $this->schedule_option);
                $check_truoc_han_3 = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_B_3_', $this->schedule_option);

                $check_toi_han = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_0_', $this->schedule_option);

                $check_qua_han_1 = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_DL_1_', $this->schedule_option);

                $check_qua_han_3 = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_DL_3_', $this->schedule_option);

                $check_qua_han_7 = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_DL_7_', $this->schedule_option);

                if ($check_truoc_han_7 == 'Có') {
                    $result['truoc_han_7']['success'] += 1;
                    $result['total']['success'] += 1;
                } else {
                    if ($check_truoc_han_7 == 'Không') {
                        $result['truoc_han_7']['miss'] += 1;
                        $result['total']['miss'] += 1;
                    }
                }

                if ($check_truoc_han_5 == 'Có') {
                    $result['truoc_han_5']['success'] += 1;
                    $result['total']['success'] += 1;
                } else {
                    if ($check_truoc_han_5 == 'Không') {
                        $result['truoc_han_5']['miss'] += 1;
                        $result['total']['miss'] += 1;
                    }
                }

                if ($check_truoc_han_3 == 'Có') {
                    $result['truoc_han_3']['success'] += 1;
                    $result['total']['success'] += 1;
                } else {
                    if ($check_truoc_han_3 == 'Không') {
                        $result['truoc_han_3']['miss'] += 1;
                        $result['total']['miss'] += 1;
                    }
                }

                if ($check_toi_han == 'Có') {
                    $result['den_han']['success'] += 1;
                    $result['total']['success'] += 1;
                } else {
                    if ($check_toi_han == 'Không') {
                        $result['den_han']['miss'] += 1;
                        $result['total']['miss'] += 1;
                    }
                }

                if ($check_qua_han_1 == 'Có') {
                    $result['qua_han_1']['success'] += 1;
                    $result['total']['success'] += 1;
                } else {
                    if ($check_qua_han_1 == 'Không') {
                        $result['qua_han_1']['miss'] += 1;
                        $result['total']['miss'] += 1;
                    }
                }

                if ($check_qua_han_3 == 'Có') {
                    $result['qua_han_3']['success'] += 1;
                    $result['total']['success'] += 1;
                } else {
                    if ($check_qua_han_3 == 'Không') {
                        $result['qua_han_3']['miss'] += 1;
                        $result['total']['miss'] += 1;
                    }
                }

                if ($check_qua_han_7 == 'Có') {
                    $result['qua_han_7']['success'] += 1;
                    $result['total']['success'] += 1;
                } else {
                    if ($check_qua_han_7 == 'Không') {
                        $result['qua_han_7']['miss'] += 1;
                        $result['total']['miss'] += 1;
                    }
                }
            }
        }
        return $result;
    }
    public function exportExcel($data = array(), $from_date, $to_date){
        $countGroupCall = $this->countGroupCall($data);
        $schedule_option = $this->schedule_option;

        require(dirname(__FILE__) . '/../../../../Vaytien/src/lib/PHPExcel/IOFactory.php');
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(dirname(__FILE__) ."/report/VM.1006_BC_Nhac_no_tu_dong_v01.xls");

        if(date('d/m/Y', $from_date) == date('d/m/Y', $to_date)){
            $textH1 = 'Ngày ' .(string)date('d/m/Y', $from_date);
        }else{
            $textH1 = 'Từ ngày ' . (string)date('d/m/Y', $from_date) . ' đến ngày ' . (string)date('d/m/Y', $to_date);
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $textH1);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5', $countGroupCall['total']['total']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F5', $countGroupCall['total']['success']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', $countGroupCall['total']['miss']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D6', $countGroupCall['truoc_han_7']['total']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F6', $countGroupCall['truoc_han_7']['success']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H6', $countGroupCall['truoc_han_7']['miss']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D7', $countGroupCall['truoc_han_3']['total']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7', $countGroupCall['truoc_han_3']['success']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H7', $countGroupCall['truoc_han_3']['miss']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8', $countGroupCall['den_han']['total']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', $countGroupCall['den_han']['success']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', $countGroupCall['den_han']['miss']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9', $countGroupCall['qua_han_1']['total']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F9', $countGroupCall['qua_han_1']['success']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', $countGroupCall['qua_han_1']['miss']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10', $countGroupCall['qua_han_3']['total']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F10', $countGroupCall['qua_han_3']['success']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H10', $countGroupCall['qua_han_3']['miss']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D11', $countGroupCall['qua_han_7']['total']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F11', $countGroupCall['qua_han_7']['success']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H11', $countGroupCall['qua_han_7']['miss']);


        $i=13;
        $stt = 0;

        if($data){
            foreach ($data as $key=>$item){
                $objPHPExcel->setActiveSheetIndex(0)->getRowDimension($i)->setRowHeight(15);
                $i++;
                $stt++;

                $check = 0;
                $_st = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_B_7_', $schedule_option);
                $check = ($_st == 'Có') ? 1 : 0;
                $_st = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_B_3_', $schedule_option);
                if($check == 0){ $check = ($_st == 'Có') ? 1 : 0; }
                $_st = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_0_', $schedule_option);
                if($check == 0){ $check = ($_st == 'Có') ? 1 : 0; }
                $_st = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_DL_1_', $schedule_option);
                if($check == 0){ $check = ($_st == 'Có') ? 1 : 0; }
                $_st = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_DL_3_', $schedule_option);
                if($check == 0){ $check = ($_st == 'Có') ? 1 : 0; }
                $_st = Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_DL_7_', $schedule_option);
                if($check == 0){ $check = ($_st == 'Có') ? 1 : 0; }

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $stt)
                    ->setCellValue('B'.$i, $item->full_name)
                    ->setCellValue('C'.$i, $item->phone)
                    ->setCellValue('D'.$i, date('d/m/Y', $item->date_repayment))
                    ->setCellValue('E'.$i, Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_B_7_', $schedule_option))
                    ->setCellValue('F'.$i, Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_B_3_', $schedule_option))
                    ->setCellValue('G'.$i, Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_0_', $schedule_option))
                    ->setCellValue('H'.$i, Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_DL_1_', $schedule_option))
                    ->setCellValue('I'.$i, Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_DL_3_', $schedule_option))
                    ->setCellValue('J'.$i, Helper::convertScheduleOption($item->call_type, $item->call_status, 'VM2018_DL_7_', $schedule_option))
                    ->setCellValue('J'.$i, ($check == 1) ? 'Có' : 'Không');
            }
        }

        $filename = 'VM.1006_BC_Nhac_no_tu_dong_v01.xls';
        header("Content-type: application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        die;
    }

    public function getInfoCall($callId){
        $result = array();
        if($callId != ''){
            $result = app(LogCallHistoryService::class)->getInfoCall($callId);
            $result = json_decode($result);
            $result = isset($result->data->calls[0]) ? $result->data->calls[0] : array();
        }
        return $result;
    }
    public function updateInfoCallId($id, $dataGetStringee){
        if($id > 0 && sizeof($dataGetStringee) > 0){
            $dataUpdate = array(
                'created_at'=>date('Y-m-d H:i:s', substr($dataGetStringee->start_time, 0, -3)),
                'updated_at'=>($dataGetStringee->answer_time > 0) ? date('Y-m-d H:i:s', substr($dataGetStringee->answer_time, 0, -3)) : '',
                'stop_at'=>date('Y-m-d H:i:s', substr($dataGetStringee->stop_time, 0, -3)),
            );
            app(ReminderBorrower::class)::updateData($id, $dataUpdate);
        }
    }
}
