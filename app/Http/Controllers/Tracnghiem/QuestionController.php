<?php

namespace App\Http\Controllers\Tracnghiem;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Tracnghiem\Question;
use App\Library\AdminFunction\CGlobal;
use App\Services\TracNghiemService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use PhpOffice\PhpWord\IOFactory;

class QuestionController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();//check quyen

    public $commonService;
    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'QL câu hỏi';

        $this->commonService = new TracNghiemService();
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),//--chọn trạng thái
            STATUS_SHOW => viewLanguage('status_show'),//Hiển thị
            STATUS_HIDE => viewLanguage('status_hidden'));//Ẩn

        //out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_QUESTION_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_QUESTION_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_QUESTION_DELETE),
        ];
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'pageAdminTitle' => CGlobal::$pageAdminTitle,
        ];
    }
    public function view()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();

        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();

        $search['name'] = addslashes(Request::get('name', ''));
        $search['status'] = (int)Request::get('status', -1);
        //$search['field_get'] = 'menu_name,menu_id,parent_id';//cac truong can lay
        //vmDebug($search);

        $data = app(Question::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $pageNo, $data['total'], $limit, $search) : '';

        $this->_outDataView($search);
        return view('tracnghiem.Question.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function getItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $data = (($id > 0)) ? app(Question::class)->getItemById($id) : [];
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('tracnghiem.Question.add', array_merge([
            'data' => $data,
            'id' => $id,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
        if(isset($_FILES['image']) && count($_FILES['image'])>0 && $_FILES['image']['name'] != '') {
            $folder = 'banner';
            $_max_file_size = 10 * 1024 * 1024;
            $_file_ext = 'jpg,jpeg,png,gif';
            $pathFileUpload = app(Upload::class)->uploadFile('image', $_file_ext, $folder, $_max_file_size);
            $data['image'] = trim($pathFileUpload) != ''? $pathFileUpload: '';
        }

        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                //cap nhat
                if (app(Question::class)->updateItem($id, $data)) {
                    return Redirect::route('tracnghiem.questionView');
                }
            } else {
                //them moi
                if (app(Question::class)->createItem($data)) {
                    return Redirect::route('tracnghiem.questionView');
                }
            }
        }
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('tracnghiem.Question.add', array_merge([
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function mixAutoQuestion()
    {
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $arrField = ['id','question_name','answer_1','answer_2','answer_3','answer_4','answer_5','answer_6','correct_answer'];
        $data = Question::where('id','>',0)->get($arrField);
        $dataTron = [];
        if($data){
            foreach ($data->toArray() as $v){
                $list_dap_an = [];
                for( $i= 1 ; $i <= 6 ; $i++ ){
                    $key_q = 'answer_'.$i;
                    if(isset($v[$key_q]) && trim($v[$key_q]) != ''){
                        $list_dap_an[$key_q] = trim($v[$key_q]);
                    }
                }
                $v['list_answer'] = $list_dap_an;
                $dataTron[$v['id']] = $v;
            }
        }
        $du_lieu_da_tron = $this->commonService->mixAutoQuestion($dataTron);
        $list_dap_an = [1=>'A',2=>'B',3=>'C',4=>'D',];
        //form_exam_question
        if(!empty($du_lieu_da_tron)){
            $output =  view('tracnghiem.Question.form_exam_question',['questions'=>$du_lieu_da_tron,
                'list_dap_an'=>$list_dap_an,
            ]);
            $filepath = "de_thi_1.doc";
            @header("Cache-Control: ");// leave blank to avoid IE errors
            @header("Pragma: ");// leave blank to avoid IE errors
            @header("Content-type: application/octet-stream");
            @header("Content-Disposition: attachment; filename=\"{$filepath}\"");
            $dir = 'uploads/images/';
            $path_folder_upload = env('IS_LIVE') ? env('APP_PATH_UPLOAD') . env('APP_PATH_UPLOAD_MIDDLE',$dir) : Config::get('config.DIR_ROOT') .env('APP_PATH_UPLOAD_MIDDLE',$dir);
            if (!is_dir($path_folder_upload)) {
                @mkdir($path_folder_upload, 0777, true);
                chmod($path_folder_upload, 0777);
            }
            ob_start();
            echo $output;
            $output_so_far = ob_get_contents();
            ob_clean();
            file_put_contents($path_folder_upload.$filepath, $output_so_far);
            echo $output;  die;
        }
    }

    //ajax
    public function deleteItem()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_DELETE])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(Question::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function _validData($data = array())
    {
        if (!empty($data)) {
            if (isset($data['name']) && trim($data['name']) == '') {
                $this->error[] = 'Tên banner không được bỏ trống';
            }
            if (isset($data['url']) && trim($data['url']) == '') {
                $this->error[] = 'URL không được bỏ trống';
            }
        }
        return true;
    }

}
