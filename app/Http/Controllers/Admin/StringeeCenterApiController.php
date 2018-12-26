<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\User;
use App\Stringee;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Services\LogCall\LogCallHistoryService;
use App\Http\Models\Admin\UsersPhoneStringeeAgent;
use App\Library\AdminFunction\CGlobal;
use App\Services\LogCall\VMAccessToken;

class StringeeCenterApiController extends BaseAdminController
{
    private $viewPermission = array();

    public function __construct(){
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Danh sách Stringee Group';
    }

    public function _getDataDefault(){
        //Out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_STRINGEE_GET_GROUP_LIST_FULL),
            'permission_view' => $this->checkPermiss(PERMISS_STRINGEE_GET_GROUP_LIST_VIEW),
            'permission_create' => $this->checkPermiss(PERMISS_STRINGEE_GET_GROUP_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_STRINGEE_GET_GROUP_DELETE),
        ];
    }

    public function getGroupList($groupId=''){

        $page = (int)Request::get('page', 1);
        $limit = (int)Request::get('limit', 50);

        $getGroupList = app(LogCallHistoryService::class)->groupList($page, $limit);
        $getGroupList = json_decode($getGroupList);
        $recordGroup = isset($getGroupList->data->groups) ? $getGroupList->data->groups : array();

        $arrAgent = array();
        if($groupId != ''){
            $listAgent = app(LogCallHistoryService::class)->agentInGroup($groupId);
            $listAgent = json_decode($listAgent);
            $arrAgent = isset($listAgent->data->groupAgents) ? $listAgent->data->groupAgents : array();
        }else{
            if($recordGroup || !empty($recordGroup)){
                $groupId = isset($recordGroup[0]->id) ? $recordGroup[0]->id : '';
                if($groupId != ''){
                    $listAgent = app(LogCallHistoryService::class)->agentInGroup($groupId);
                    $listAgent = json_decode($listAgent);
                    $arrAgent = isset($listAgent->data->groupAgents) ? $listAgent->data->groupAgents : array();
                }
            }
        }

        $this->checkAgentExist($arrAgent);
        $arrAgentStringee = $this->getAllStringeeAgent();
        $arrNotInGroup = $this->getArrayUserNotInGroup($arrAgent, $arrAgentStringee);

        return view('admin.AdminLogCall.index_stringee_group', array_merge([
            'groupId'=>$groupId,
            'recordGroup'=>$recordGroup,
            'arrAgent'=>$arrAgent,
            'arrNotInGroup'=>$arrNotInGroup
        ], $this->viewPermission));
    }
    public function updateNameGroup(){
        $groupId = Request::get('groupId', '');
        $groupName = Request::get('groupName', '');

        if($groupId != '' && $groupName != ''){
            $data = array(
                'name'=>$groupName
            );

            $r = app(LogCallHistoryService::class)->groupUpdate($groupId, $data);
            echo $r;die;
        }
        echo 'Cập nhật tên group không thành công!';die;
    }
    public function createNameGroup(){
        $groupName = Request::get('groupName', '');
        if($groupName != ''){
            $data = array(
                'name'=>$groupName
            );

            $r = app(LogCallHistoryService::class)->groupCreate($data);
            echo $r;die;
        }
        echo 'Thêm mới group không thành công!';die;
    }
    public function deleteGroup(){
        $groupId = Request::get('groupId', '');
        if($groupId != ''){

            $r = app(LogCallHistoryService::class)->groupDelete($groupId);
            echo $r;die;
        }
        echo 'Xóa group không thành công!';die;
    }
    public function ajaxChangeStatusAgent(){
        $statusAgent = (int)Request::get('statusAgent', 0);
        $agentId = Request::get('agentId', '');
        $userId = Request::get('userId', '');

        if($agentId != '' && $userId != '') {
            if ($statusAgent == 1) {
                $statusAgent = 'AVAILABLE';
            } else {
                $statusAgent = 'NOT AVAILABLE';
            }
            $data = array(
                'manual_status' => $statusAgent,
                'stringee_user_id' => $userId,
            );

            $check = app(UsersPhoneStringeeAgent::class)->checkAgentIdExist($agentId);
            if(!empty($check)){
                $dataUp = array('agent_status'=>$statusAgent);
                app(UsersPhoneStringeeAgent::class)->updateData($check->id, $dataUp);
            }

            $r = app(LogCallHistoryService::class)->agentUpdate($agentId, $data);
            //Create token
            $this->createAcessTokenTringGee($statusAgent);
            echo $r; die;
        }
        echo 'Cập nhật trạng thái agent thành công!';die;
    }
    public function ajaxCreateAgent(){
        $agent_name = Request::get('agent_name', '');
        $stringee_user_id = Request::get('stringee_user_id', '');
        $sip_phone_extension = Request::get('sip_phone_extension', 'agent_'.rand(111111, 999999));
        $groupId = Request::get('groupId', '');

        if($agent_name != '' && $stringee_user_id != '' && $sip_phone_extension != '' && $groupId != ''){
            $check_mail = checkRegexEmail($stringee_user_id);
            if($check_mail){
                $stringee_user_id = PREFIX_STRINGEE_USER . str_replace("@","_", $stringee_user_id);
                $data = array(
                    'name'=>$agent_name,
                    'stringee_user_id'=>$stringee_user_id,
                    'sip_phone_extension'=>$sip_phone_extension,
                );

                $result = app(LogCallHistoryService::class)->agentCreate($data);
                $result = json_decode($result);
                if(!empty($result)){
                    if(isset($result->r) && $result->r == 0){
                        if(isset($result->agentID) && $result->agentID != ''){
                            $agentID = $result->agentID;
                            $data = array(
                                'agent_id'=>$agentID,
                                'group_id'=>$groupId,
                            );
                            app(LogCallHistoryService::class)->addAgentToGroup($data);

                            $dataCreate = array(
                                'agent_id'=>$agentID,
                                'agent_user'=>$stringee_user_id
                            );
                            $check = app(UsersPhoneStringeeAgent::class)->checkAgentIdExist($agentID);
                            if(empty($check)){
                                app(UsersPhoneStringeeAgent::class)->addData($dataCreate);
                            }
                        }
                    }
                }
                echo 'Thêm Agent thành công!';die;
            }else{
                echo 'Email không đúng định dạng!';die;
            }
        }
    }
    public function deleteAgent(){
        $agentId = Request::get('agentId', '');
        if($agentId != ''){
            app(LogCallHistoryService::class)->agentDelete($agentId);
            $check = app(UsersPhoneStringeeAgent::class)->checkAgentIdExist($agentId);
            if(!empty($check)){
                app(UsersPhoneStringeeAgent::class)->deleteId($check->id);
            }

        }
        echo 'Xóa agent thành công!';die;
    }
    public function agentDeleteInGroup(){
        $agentId = Request::get('agentId', '');
        $groupId = Request::get('groupId', '');
        if($groupId != '' && $agentId != ''){
            $data = array(
                'agent_id'=>$agentId,
                'group_id'=>$groupId,
            );
            app(LogCallHistoryService::class)->agentDeleteInGroup($data);
        }
        echo 'Xóa agent trong group thành công!';die;
    }
    public function ajaxAddAgentToGroup(){
        $groupId = Request::get('groupId', '');
        $agentId = Request::get('agentId', '');
        if($groupId != '' && $agentId != ''){
            $data = array(
                'agent_id'=>$agentId,
                'group_id'=>$groupId,
            );

            $r = app(LogCallHistoryService::class)->addAgentToGroup($data);
            echo $r;die;
        }
        echo 'Thêm Agent vào group thành công!';die;
    }
    public function checkAgentExist($arrAgent = array()){
        if(count($arrAgent) > 0){
            $Users_phone_stringee_agent = new UsersPhoneStringeeAgent();
            $data = array();
            foreach($arrAgent as $item){
                $check = $Users_phone_stringee_agent->checkAgentIdExist($item->agent_id);
                if(empty($check)){
                    $data[] = array(
                        'agent_id'=>$item->agent_id,
                        'agent_user'=>$item->stringee_user_id,
                        'agent_status'=>(trim($item->manual_status) != '') ? $item->manual_status : 'NOT AVAILABLE'
                    );
                }
            }
            if(!empty($data)){
                app(UsersPhoneStringeeAgent::class)->insertMultiple($data);
            }
        }
    }
    public function getAllStringeeAgent(){
        $page = (int)Request::get('page', 1);
        $limit = (int)Request::get('limit', 50);

        $data = app(LogCallHistoryService::class)->agentList($page, $limit);
        $data = json_decode($data);
        $totalPages = isset($data->data->totalPages) ? $data->data->totalPages : 0;
        $listAgent = isset($data->data->agents) ? $data->data->agents : 0;

        if($totalPages > 1){
            for($i=2; $i<=$totalPages; $i++){
                $_data = app(LogCallHistoryService::class)->agentList($i, $limit);
                $_data = json_decode($_data);
                $listAgent = isset($_data->data->agents) ? $_data->data->agents : 0;
                if($listAgent->count()  > 0){
                    $listAgent += $listAgent;
                }
            }
        }

        return $listAgent;
    }
    public function getArrayUserNotInGroup($agentGroup=array(), $agentALl=array()){
        $tmpAgentGroup = array();
        $tmpAgentALl = array();

        foreach($agentGroup as $item){
            $tmpAgentGroup[$item->agent_id] = $item->stringee_user_id;
        }
        foreach($agentALl as $item){
            $tmpAgentALl[$item->id] = $item->stringee_user_id;
        }

        foreach($tmpAgentGroup as $k=>$item){
            if(isset($tmpAgentALl[$k])){
                unset($tmpAgentALl[$k]);
            }
        }

        return $tmpAgentALl;
    }
    public function popupAnswerAgent(){
        return view('admin.AdminLogCall.index_popup_agent_answer', []);
    }
    public function createAcessTokenTringGee($statusAgent = ''){
        //Create token stringee
        $user = app(User::class)->user_login();
        $userEmail = ($user) ? $user['user_email'] : "";
        $checkName = Stringee::checkNameAgentStringee(PREFIX_STRINGEE_USER, $userEmail);
        if($statusAgent == 'AVAILABLE'){
            $token_stringee = app(VMAccessToken::class)->generateIccToken($checkName);
        }else{
            $token_stringee = app(VMAccessToken::class)->generateIccToken($userEmail);
        }

        $user['token_stringee'] = $token_stringee;
        Session::put('user', $user, 60 * 24);Session::save();
    }
}
