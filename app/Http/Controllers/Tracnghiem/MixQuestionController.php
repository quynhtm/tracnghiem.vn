<?php

namespace App\Http\Controllers\Tracnghiem;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\User;
use App\Http\Models\Admin\VmDefine;
use App\Http\Models\Tracnghiem\Exam;
use App\Http\Models\Tracnghiem\Question;
use App\Library\AdminFunction\CExtracts;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Memcache;
use App\Services\TracNghiemService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use PhpOffice\PhpWord\IOFactory;

class MixQuestionController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();//check quyen
    private $arrApprove = array();

    private $khoi_lop = array();
    private $mon_hoc = array();
    private $chuyen_de = array();

    public $commonService;
    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Trộn câu hỏi';

        $this->commonService = new TracNghiemService();
    }

    public function _getDataDefault()
    {
        $this->arrApprove = Question::$arrApprove;
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

    public function _outDataView($data=[])
    {
        $optionApprove = getOption($this->arrApprove, isset($data['question_approved']) ? $data['question_approved'] : STATUS_SHOW);
        $optionStatus = getOption($this->arrStatus, isset($data['question_status']) ? $data['question_status'] : STATUS_SHOW);

        $this->khoi_lop = app(VmDefine::class)->getArrByType(TRAC_NGHIEM_KHOI_LOP);
        $optionKhoiHoc = getOption($this->khoi_lop, isset($data['question_school_block']) ? $data['question_school_block'] : STATUS_DEFAULT);

        $this->mon_hoc = app(VmDefine::class)->getArrByType(TRAC_NGHIEM_MON_HOC);
        $optionMonHoc = getOption($this->mon_hoc, isset($data['question_subject']) ? $data['question_subject'] : STATUS_DEFAULT);

        $this->chuyen_de= app(VmDefine::class)->getArrByType(TRAC_NGHIEM_CHUYEN_DE);
        $optionChuyenDe = getOption($this->chuyen_de, isset($data['question_thematic']) ? $data['question_thematic'] : STATUS_DEFAULT);

        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'optionApprove' => $optionApprove,
            'pageAdminTitle' => CGlobal::$pageAdminTitle,

            'optionKhoiHoc' => $optionKhoiHoc,
            'optionMonHoc' => $optionMonHoc,
            'optionChuyenDe' => $optionChuyenDe,

            'arrBlock' => $this->khoi_lop,
            'arrSubs' => $this->mon_hoc,
            'arrThematic' => $this->chuyen_de,
        ];
    }
    public function view()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $arrChose = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_QUESTION_CHOSE_MIX_EXAM) : [];
        $this->_getDataDefault();

        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();

        $search['exam_name'] = addslashes(Request::get('exam_name', 'Đề thi test'));
        $search['number_exam'] = (int)(Request::get('number_exam', 1));
        $search['time_to_do'] = (int)(Request::get('time_to_do', 30));
        $year_now = date('Y');
        $search['school_year'] = Request::get('school_year', (($year_now-1).'-'.$year_now));
        $search['school_block_id'] = (int)Request::get('school_block_id', -1);
        $search['subjects_id'] = (int)Request::get('subjects_id', -1);
        $search['thematic_id'] = (int)Request::get('thematic_id', -1);
        $search['question_id'] = $arrChose;

        $data = ($arrChose)?app(Question::class)->searchByCondition($search, $limit, $offset, true):[];
        $total = isset($data['total'])?$data['total']: 0;
        $result = isset($data['data'])?$data['data']: [];
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        $this->_outDataView($search);
        return view('tracnghiem.MixQuestion.view', array_merge([
            'data' => $result,
            'search' => $search,
            'total' => $total,
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'arrApprove' => $this->arrApprove,
            'arrTypeQuestionText' => CExtracts::$arrTypeQuestionText
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function mixAutoQuestion()
    {
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_outDataView();
        $dataId = Request::get('checkItems', array());
        $dataExam['exam_name'] = $ten_de_thi = Request::get('exam_name', '');
        $dataExam['school_year'] = $nam_hoc = Request::get('school_year', '');
        $dataExam['time_to_do'] = $time_to_do = Request::get('time_to_do', 30);
        $number_exam = Request::get('number_exam', 1);

        $school_block_id = Request::get('school_block_id', 0);
        $dataExam['school_block_id'] = $school_block_id;
        $dataExam['school_block_name'] = $ten_khoi_lop = isset($this->khoi_lop[$school_block_id])?$this->khoi_lop[$school_block_id]:'';

        $subjects_id = Request::get('subjects_id', 0);
        $dataExam['subjects_id'] = $subjects_id;
        $dataExam['subjects_name'] = $ten_mon_hoc = isset($this->mon_hoc[$subjects_id])?$this->mon_hoc[$subjects_id]:'';

        $thematic_id = Request::get('thematic_id', 0);
        $dataExam['thematic_id'] = $thematic_id;
        $dataExam['thematic_name'] = $ten_chuyen_de = isset($this->chuyen_de[$thematic_id])?$this->chuyen_de[$thematic_id]:'';

        if(!empty($dataId)){
            $arrField = ['id','question_name','answer_1','answer_2','answer_3','answer_4','answer_5','answer_6','correct_answer'];
            $data = Question::where('id','>',0)->whereIn('id',$dataId)->get($arrField);
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
        }

        if(empty($dataTron))
            return;

        $du_lieu_da_tron = $this->commonService->mixAutoQuestion($dataTron);
        $list_dap_an = [1=>'A',2=>'B',3=>'C',4=>'D',];
        $total_question = count($du_lieu_da_tron);
        $dataExam['total_question'] = $total_question;
        $dataExam['data_question'] = json_encode($du_lieu_da_tron);

        $dataExam['user_id_creater'] = app(User::class)->user_id();
        $dataExam['user_name_creater'] = app(User::class)->user_name();
        $dataExam['created_at'] = getCurrentDateTime();
        $id_de_thi = app(Exam::class)->createItem($dataExam);

        //form_exam_question
        if(!empty($du_lieu_da_tron) && $id_de_thi > 0){
            $output =  view('tracnghiem.MixQuestion.form_exam_question',[
                'questions'=>$du_lieu_da_tron,
                'list_dap_an'=>$list_dap_an,
                'total_question'=>$total_question,
                'time_to_do'=>$time_to_do,
                'ten_de_thi'=>$ten_de_thi,
                'nam_hoc'=>$nam_hoc,
                'ten_khoi_lop'=>$ten_khoi_lop,
                'ten_mon_hoc'=>$ten_mon_hoc,
                'ten_chuyen_de'=>$ten_chuyen_de,
                'id_de_thi'=>$id_de_thi,
            ]);
            $filepath = "de_thi_".$id_de_thi.".doc";
            @header("Cache-Control: ");// leave blank to avoid IE errors
            @header("Pragma: ");// leave blank to avoid IE errors
            @header("Content-type: application/octet-stream");
            @header("Content-Disposition: attachment; filename=\"{$filepath}\"");
            $folder = 'uploads/dethi/';
            $ma_dethi = 'MaDe_'.$id_de_thi.'/';
            $dir = $folder.$ma_dethi;
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
                chmod($dir, 0777);
            }
            ob_start();
            echo $output;
            $output_so_far = ob_get_contents();
            ob_clean();
            file_put_contents($dir.$filepath, $output_so_far);
            echo $output;
        }
    }

    //chọn câu hỏi
    public function choseQuestion(){

        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $data = array('isIntOk' => 0);
        $dataId = Request::get('dataId', array());

        if(!empty($dataId)){
            $arrChose = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_QUESTION_CHOSE_MIX_EXAM) : [];
            foreach($dataId as $id){
                $arrChose[$id] = $id;
            }
            Cache::put(Memcache::CACHE_QUESTION_CHOSE_MIX_EXAM, $arrChose, CACHE_THREE_MONTH);
            $data['isIntOk'] = 1;
       }
        return Response::json($data);
    }
}
