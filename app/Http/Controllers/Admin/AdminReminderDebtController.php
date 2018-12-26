<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\ReminderDept;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use Illuminate\Support\Facades\File;

class AdminReminderDebtController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();  //check quyen
    private $remindType = array();  //check quyen

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý file audio nhắc nhợ tự động';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_INT_AM_MOT => viewLanguage('Mới'),
            STATUS_SHOW => viewLanguage('Áp dụng'),
            STATUS_HIDE => viewLanguage('Dừng'));

        $this->remindType = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_INT_AM_MOT => viewLanguage('Chưa chọn'),
            STATUS_INT_KHONG => viewLanguage('Trước hạn 7 ngày'),
            STATUS_INT_MOT => viewLanguage('Trước hạn 5 ngày'),
            STATUS_INT_HAI => viewLanguage('Trước hạn 3 ngày'),
            STATUS_INT_BA => viewLanguage('Đến hạn'),
            STATUS_INT_BON => viewLanguage('Qúa hạn 1 ngày'),
            STATUS_INT_NAM => viewLanguage('Qúa hạn 3 ngày'),
            STATUS_INT_SAU => viewLanguage('Qúa hạn 7 ngày'));

        //out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_REMINDER_DEBT_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_REMINDER_DEBT_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_REMINDER_DEBT_DELETE),
            'permission_active' => $this->checkPermiss(PERMISS_REMINDER_DEBT_ACTIVE),
            'permission_deactive' => $this->checkPermiss(PERMISS_REMINDER_DEBT_DEACTIVE),
        ];
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_INT_AM_HAI);
        $optionRemindType = getOption($this->remindType, isset($data['remind_type']) ? $data['remind_type'] : STATUS_INT_AM_HAI);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'pageAdminTitle' => CGlobal::$pageAdminTitle,
            'optionRemindType' => $optionRemindType
        ];
    }

    public function view()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_REMINDER_DEBT_FULL, PERMISS_REMINDER_DEBT_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();

        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();

        $search['name_audio'] = addslashes(Request::get('name_audio', ''));
        $search['status'] = (int) Request::get('status',-2);
        $search['remind_type'] = (int) Request::get('remind_type',-2);

//        $search['field_get'] = 'id,menu_id,parent_id';//cac truong can lay

        $data = app(ReminderDept::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(10, $pageNo, $data['total'], $limit, $search) : '';

        $this->_outDataView($search);

        return view('admin.AdminReminderDebt.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function getItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_REMINDER_DEBT_FULL, PERMISS_REMINDER_DEBT_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $data = (($id > 0)) ? app(ReminderDept::class)->getItemById($id) : [];
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminReminderDebt.add', array_merge([
            'data' => $data,
            'id' => $id,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_REMINDER_DEBT_FULL, PERMISS_REMINDER_DEBT_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $id_hiden = (int)Request::get('id_hiden', 0);

        if(isset($_POST['deactive_button'])){
            $data['status'] = STATUS_INT_KHONG;
        }
        elseif(isset($_POST['active_button'])){
            $data['status'] = STATUS_INT_MOT;
        }
        else{
            $data = $_POST;
        }
        if ($this->_validData($data) && empty($this->error)) {
            if(isset($_FILES['audio']) && count($_FILES['audio'])>0 && $_FILES['audio']['name'] != '') {
                $folder = 'audio';
                $_max_file_size = 10 * 1024 * 1024;
                $_file_ext = 'mp3,mp4';
                $pathFileUpload = app(Upload::class)->uploadFile('audio', $_file_ext, $folder, $_max_file_size, true, AUDIO_DIRECTORY);
                $data['link_audio'] = trim($pathFileUpload) != ''? '/'.AUDIO_DIRECTORY.'/'.$pathFileUpload: '';
            }
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                if(isset($data['link_audio_old']) && $data['link_audio_old'] !== ''){
                    try{
                        // Todo: need to remove old image path
                        $delete_file = unlink(env('APP_PATH_UPLOAD').$data['link_audio_old']);
//                            unlink(env('APP_PATH_UPLOAD').'/vaymuon/audio/03-15-24-12-10-2018-1534143136qua7ngay-1.mp3'); // test xoá
//                        /vaymuon/audio/2018.08.13/1534143218_truoc7ngay.mp3

                    }catch(\Exception $e){
                        return Redirect::route('admin.reminderDebtEdit',['id'=>$id])
                            ->with('status_error','Không tồn tại file audio');
                    }
                }
                //cap nhat
                if (app(ReminderDept::class)->updateItem($id, $data)) {
                    return Redirect::route('admin.reminderDebtView')->with('status','Cập nhật cấu hình file audio thành công');
                }
            } else {
                //them moi
                if (app(ReminderDept::class)->createItem($data)) {
                    return Redirect::route('admin.reminderDebtView')->with('status','Thêm mới cấu hình file audio thành công');
                }
            }
        }
        $this->_getDataDefault();
        $this->_outDataView($data);

        $data = (($id > 0)) ? app(ReminderDept::class)->getItemById($id) : [];

        return view('admin.AdminReminderDebt.add', array_merge([
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
        ], $this->viewPermission, $this->viewOptionData));
    }


    //ajax
    public function deleteBanner()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_BANNER_FULL, PERMISS_BANNER_DELETE])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(Banners::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function _validData($data = array())
    {
        if (!empty($data)) {
            if (isset($data['remind_type']) && trim($data['remind_type']) == -1) {
                $this->error[] = 'Vui lòng chọn trạng thái nhắc nợ';
            }
            if (isset($data['name_audio']) && trim($data['name_audio']) == '') {
                $this->error[] = 'Vui lòng nhập tên audio';
            }
        }
        return true;
    }
}
