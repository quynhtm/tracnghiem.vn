<?php

/**
 * Created by IntelliJ IDEA.
 * User: danghung111
 * Date: 10/29/18
 * Time: 16:43 PM
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\UsersLogsStringeeCall;
use App\Http\Models\Admin\UsersPermissionStringeeCall;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\CGlobal;
use App\Stringee;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use App\Services\LogCall\LogCallHistoryService;

class LogCallController extends BaseAdminController
{
    private $arrStatus = array();
    private $arrCountStatus = array();
    private $arrUpdateLocal = array();
    private $arrUpdateCallLog = array();
    private $arrUpdatePhoneBook = array();
    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct(){
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý danh sách cuộc gọi';
    }
    public function _getDataDefault(){
        //Out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_LOG_CALL_FULL),
            'permission_view' => $this->checkPermiss(PERMISS_LOG_CALL_VIEW),
            'permission_view_record' => $this->checkPermiss(PERMISS_LOG_CALL_VIEW_RECORD),
        ];
    }
    public function _outDataView($data){
        $optionUpdateLocation = getOption($this->arrUpdateLocal, isset($data['update_location']) ? $data['update_location'] : STATUS_SHOW);
        $optionUpdateCallLog = getOption($this->arrUpdateCallLog, isset($data['update_call_log']) ? $data['update_call_log'] : STATUS_SHOW);
        $optionUpdatePhoneBook = getOption($this->arrUpdatePhoneBook, isset($data['update_phone_book']) ? $data['update_phone_book'] : STATUS_SHOW);
        $getGroupList = app(LogCallHistoryService::class)->groupList(1, 50);
        $getGroupList = json_decode($getGroupList);
        $recordGroup = isset($getGroupList->data->groups) ? $getGroupList->data->groups : array();

        $dataGroup = [];
        foreach ($recordGroup as $key => $value) {
            $dataGroup = array_merge($dataGroup, [$value->id => $value->name]) ;
        }

        $optionGroup = getOption($dataGroup, isset($data['groupId']) ? $data['groupId'] : 'all');
        return $this->viewOptionData = [
            'pageAdminTitle' => CGlobal::$pageAdminTitle,
            'arrStatus' => $this->arrStatus,
            'optionUpdateLocation' => $optionUpdateLocation,
            'optionUpdateCallLog' => $optionUpdateCallLog,
            'optionUpdatePhoneBook' => $optionUpdatePhoneBook,
            'optionGroup' => $optionGroup
        ];
    }

    public function view(){
        if (!$this->checkMultiPermiss([PERMISS_LOG_CALL_FULL, PERMISS_LOG_CALL_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $searchFields = array();

        $searchFields['dateFrom'] = addslashes(Request::get('dateFrom') == '' ? Carbon::now()->format('Y-m-d') : Request::get('dateFrom'));
        $searchFields['dateTo'] = addslashes(Request::get('dateTo') == '' ? Carbon::now()->format('Y-m-d') : Request::get('dateTo'));
        $searchFields['from_number'] = addslashes(Request::get('from_number'));
        $searchFields['to_number'] = addslashes(Request::get('to_number'));
        $searchFields['from_user_id'] = addslashes(Request::get('from_user_id'));
        $searchFields['field_get'] = ['callId', 'from_user_id', 'from_user_id_alias', 'from_number', 'to_number', 'to_alias', 'time_created',
            'time_answer', 'time_stop','call_queue','call_group','call_type'];
        $searchFields['groupId'] = addslashes(Request::get('groupId'));
        $searchFields['sort'] = ['id'=>'desc'];

        $result = app(UsersLogsStringeeCall::class)->searchByCondition($searchFields, $limit, $offset, true);

        //Export excel
        $exportExcel = Request::get('exportExcel', 0);
        if($exportExcel == 2){
            return $this->exportExcelVM($result, $searchFields);
        }

        $data = isset($result['data']) ? $result['data'] : array();
        $total = isset($result['total']) ? $result['total'] : 0;
        $totalCallSuccess = isset($result['totalCallSuccess']) ? $result['totalCallSuccess'] : 0;
        $totalCallFail = isset($result['totalCallFail']) ? $result['totalCallFail'] : 0;

        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $searchFields) : '';

        $this->_getDataDefault();
        $this->_outDataView($searchFields);
        $optionStatus = getOption($this->arrStatus, '');

        return view('admin.AdminLogCall.view', array_merge([
            'data' => $data,
            'paging' => $paging,
            'total' => $total,
            'totalCallSuccess' => $totalCallSuccess,
            'totalCallFail' => $totalCallFail,
            'optionStatus' => $optionStatus,
            'arrStatus' => $this->arrStatus,
            'count_status_option' => $this->arrCountStatus,
            'search' => $searchFields,
        ], $this->viewPermission, $this->viewOptionData));
    }
    public function callRecordsFile(){

        if (!$this->checkMultiPermiss([PERMISS_LOG_CALL_FULL, PERMISS_LOG_CALL_VIEW_RECORD])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $pageNo = (int)Request::get('page_no', 1);
        $limit = (int)Request::get('limit', LIMIT_RECORD_500);

        $searchFields['dateFrom'] = addslashes(Request::get('dateFrom') == '' ? Carbon::now()->format('Y-m-d') : Request::get('dateFrom'));
        $searchFields['dateTo'] = addslashes(Request::get('dateTo') == '' ? Carbon::now()->format('Y-m-d') : Request::get('dateTo'));
        $searchFields['from_number'] = addslashes(Request::get('from_number'));
        $searchFields['to_number'] = addslashes(Request::get('to_number'));
        $searchFields['from_user_id'] = addslashes(Request::get('from_user_id'));

        $from_date =  strtotime($searchFields['dateFrom']. ' 00:00:00');
        $to_date =  strtotime($searchFields['dateTo']. ' 23:59:59');

        $user_id = isset($this->user['user_id']) ? $this->user['user_id'] : 0;
        $from_user_id = app(Stringee::class)->convertMailToUserStringee(PREFIX_STRINGEE_USER, $searchFields['from_user_id']);

        if($user_id > 0){
            $checkUser = app(UsersPermissionStringeeCall::class)->getItemByUserId($user_id);
            if(!empty($checkUser)){
                $status_call_stringee_me = $checkUser->status_call_stringee_me;
                if($status_call_stringee_me == 1){
                    $from_user_id = $checkUser->user_mail;
                    if($from_user_id != ''){
                        $from_user_id = app(Stringee::class)->convertMailToUserStringee(PREFIX_STRINGEE_USER, $from_user_id);
                    }
                }
            }
        }

        $result = app(LogCallHistoryService::class)->loadCallHistory($searchFields['from_number'], $searchFields['to_number'], $from_user_id, $from_date, $to_date, $pageNo, $limit);
        $result = json_decode($result);
        $records = isset($result->data->calls) ? $result->data->calls : array();
        $totalCalls = isset($result->data->totalCalls) ? number_format($result->data->totalCalls) : 0;
        $totalPages = isset($result->data->totalPages) ? $result->data->totalPages : 0;

        $arrMail = app(Stringee::class)->getUserMailCallApiStringee($records);
        $arrMailRel = isset($arrMail['mail']) ? $arrMail['mail'] : [];
        $arrMailCall = isset($arrMail['call']) ? $arrMail['call'] : [];

        $totalCallCount = app(Stringee::class)->totalCallCount($searchFields['from_number'], $searchFields['to_number'], $from_user_id, $from_date, $to_date, $pageNo, $limit);
        $paging =  app(Stringee::class)->writePageCallApiStringee2($totalPages, 10, 'manager/log/callRecordsFile');

        $this->_getDataDefault();
        $this->_outDataView($searchFields);

        return view('admin.AdminLogCall.viewRecords', array_merge([
            'data'=>$records,
            'paging'=>$paging,
            'arrMailCall' => $arrMailCall,
            'arrMailRel' => $arrMailRel,
            'search' => $searchFields,
            'totalCalls' => $totalCalls,
            'totalCallCount' => $totalCallCount,

        ], $this->viewPermission, $this->viewOptionData));
    }

    public function callRecordsFileItem($record_id=''){
        if(isset($record_id) && $record_id != ''){
            $result = app(LogCallHistoryService::class)->downloadRecordFile($record_id);
            header('Content-Type: Content-Type: application/octet-stream');
            header('Content-disposition: attachment; filename="'.$record_id.'.mp3"');
            echo $result;die;
        }else{
            return Redirect::route('logCallCallRecordsFile');
        }
    }

    /*Get list log call in service Stringee by Duy*/
    public function exportExcelVM($result, $dataSearch){
        $groupName = $dataSearch['group_name'] = isset($dataSearch['group_name']) ? $dataSearch['group_name'] : 'all';
        $arrRecords = $result['data'];

        //Count Record
        $count = array(
            'success' => 0,
            'miss' => 0
        );
        $totalTime = 0;
        $arrRecordCount = array();

        foreach($arrRecords as $key => $item){
            if($item['to_number'] == '19002094'){
                if(isset($arrRecordCount[$item->to_number]['miss'])){
                    $arrRecordCount[$item->to_number]['miss'] += 1;
                }else{
                    $arrRecordCount[$item->to_number]['miss'] = 1;
                }
                $count['miss'] += 1;
            }else{
                $answer_time = (int)$item->time_answer;
                $stop_time = (int)$item->time_stop;
                if($answer_time == 0){
                    if(isset($arrRecordCount[$item->to_number]['miss'])){
                        $arrRecordCount[$item->to_number]['miss'] += 1;
                    }else{
                        $arrRecordCount[$item->to_number]['miss'] = 1;
                    }
                    $count['miss'] += 1;
                }else{
                    if($stop_time - $answer_time > 0){
                        if(isset($arrRecordCount[$item->to_number]['success'])){
                            $arrRecordCount[$item->to_number]['success'] += 1;
                        }else{
                            $arrRecordCount[$item->to_number]['success'] = 1;
                        }
                        if(isset($arrRecordCount[$item->to_number]['total_time'])){
                            $arrRecordCount[$item->to_number]['total_time'] += $stop_time - $answer_time;
                        }else{
                            $arrRecordCount[$item->to_number]['total_time'] = $stop_time - $answer_time;
                        }
                        $totalTime += ($stop_time - $answer_time);
                        $count['success'] += 1;
                    }else{
                        if(isset($arrRecordCount[$item->to_number]['miss'])){
                            $arrRecordCount[$item->to_number]['miss'] += 1;
                        }else{
                            $arrRecordCount[$item->to_number]['miss'] = 1;
                        }
                        $count['miss'] += 1;
                    }
                }
            }
        }
        $totalTime = FunctionLib::calcTotalCallTime($totalTime);

        require getRootPath().'app/Library/ClassPhpExcel/PHPExcel/IOFactory.php';
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(getRootPath().'app\Http\Controllers\Admin/report/VM.BC_Tong_dai_19002094.xls');

        $dateFrom = isset($dataSearch['dateFrom']) ? Carbon::parse($dataSearch['dateFrom'] . ' 00:00:00')->timestamp : '';
        $dateTo = isset($dataSearch['dateTo']) ? Carbon::parse($dataSearch['dateTo'] .' 23:59:59')->timestamp : '';
        if($dataSearch['dateFrom'] == $dataSearch['dateTo']){
            $textH1 = 'Ngày ' .(string)date('d/m/Y', $dateFrom);
        }else{
            $textH1 = 'Từ ngày ' . (string)date('d/m/Y', $dateFrom) . ' đến ngày ' . (string)date('d/m/Y', $dateTo);
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', $textH1);
        if($groupName != ''){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', 'Nhóm-'.$groupName);
        }else{
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', '');
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6', $count['miss'] + $count['success']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7', $count['miss']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', $count['success']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C9', $totalTime);

        $i=11;
        $stt = 0;
        if($arrRecordCount){
            foreach ($arrRecordCount as $key=>$item){
                $i++;
                $stt++;
                $objPHPExcel->setActiveSheetIndex(0)->getRowDimension($i)->setRowHeight(15);

                $success = isset($arrRecordCount[$key]['success']) ? $arrRecordCount[$key]['success'] : 0;
                $miss = isset($arrRecordCount[$key]['miss']) ? $arrRecordCount[$key]['miss'] : 0;
                $total_time = isset($arrRecordCount[$key]['total_time']) ? FunctionLib::calcTotalCallTime($arrRecordCount[$key]['total_time']) : '00:00';

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $stt)
                    ->setCellValue('B'.$i, $key)
                    ->setCellValue('C'.$i, $miss + $success)
                    ->setCellValue('D'.$i, $miss)
                    ->setCellValue('E'.$i, $success)
                    ->setCellValue('F'.$i, $total_time);
            }
        }
        $filename = 'VM.BC_Tong_dai_19002094';
        header("Content-type: application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        die;
    }

    public function ajaxLogsCall(){
        $callId = Request::get("callId", '');
        $fromNumber = Request::get("fromNumber", '');
        $toNumber = Request::get("toNumber", '');
        $mess=['status'=>0];
        if($callId != ''){
            $user_email = isset($this->user['user_email']) ? $this->user['user_email'] : '';
            $data = [
                'callId'=>$callId,
                'from_user_id'=>$user_email,
                'from_user_id_alias'=>Stringee::convertMailToUserStringee(PREFIX_STRINGEE_USER, $user_email),
                'from_number'=>$fromNumber,
                'to_number'=>$toNumber,
                'time_created'=>time(),
                'call_type'=>0,
            ];
            app(UsersLogsStringeeCall::class)->createItem($data);
            $mess=['status'=>1];
        }
        echo json_encode($mess);die;
    }
    public function ajaxLogsCallAnswer(){
        $callId = Request::get("callId", '');
        $fromNumber = Request::get("fromNumber", '');
        $toNumber = Request::get("toNumber", '');
        $toAlias = Request::get("toAlias", '');
        $queueInfoId = Request::get("queueInfoId", '');
        $mess=['status'=>0];

        //Get Group
        $groupId = $this->getArrGroup($queueInfoId, $toNumber);

        if($callId != ''){
            $getItem = app(UsersLogsStringeeCall::class)->getItemByCallId($callId);
            if(empty($getItem)){
                $data = [
                    'callId'=>$callId,
                    'from_user_id'=>'',
                    'from_user_id_alias'=>$toNumber,
                    'from_number'=>$fromNumber,
                    'to_number'=>$toNumber,
                    'to_alias'=>$toAlias,
                    'call_queue'=>$queueInfoId,
                    'call_group'=>$groupId,
                    'time_created'=>time(),
                    'time_answer'=>time(),
                    'call_type'=>1,
                ];
                app(UsersLogsStringeeCall::class)->createItem($data);
                $mess=['status'=>1];
            }
        }
        echo json_encode($mess);die;
    }
    public function ajaxLogsCallTime(){
        $callId = Request::get("callId", '');
        $type = Request::get("type", '');
        $mess=['status'=>0];
        $data = array();
        if($callId != ''){
            $getItem = app(UsersLogsStringeeCall::class)->getItemByCallId($callId);
            if($getItem->count() > 0){
                if($type == 'answer'){
                    $data = ['time_answer'=>time()];
                }
                if($type == 'stop'){
                    $data = ['time_stop'=>time()];
                }
                if(!empty($data)){
                    app(UsersLogsStringeeCall::class)->updateItem($getItem->id, $data);
                    $mess=['status'=>1];
                }
            }
        }
        echo json_encode($mess);die;
    }
    static function getArrGroup($queueId='', $agentId = ''){
        $groupId = '';
        if($queueId != '' && $agentId != ''){
            $getGroupList = app(LogCallHistoryService::class)->groupInQueue($queueId);
            $getGroupList = json_decode($getGroupList);
            $groupRoutings = isset($getGroupList->data->groupRoutings) ? $getGroupList->data->groupRoutings : array();
            if(!empty($groupRoutings)){
                foreach($groupRoutings as $group){
                    $groupId = isset($group->group_id) ? $group->group_id : '';
                    $listAgent = app(LogCallHistoryService::class)->agentInGroup($groupId);
                    $listAgent = json_decode($listAgent);
                    $arrAgent = isset($listAgent->data->groupAgents) ? $listAgent->data->groupAgents : array();
                    if(!empty($arrAgent)){
                        foreach($arrAgent as $item){
                            if($agentId == $item->stringee_user_id){
                                return $groupId;
                            }
                        }
                    }
                }
            }
        }
        return $groupId;
    }
}