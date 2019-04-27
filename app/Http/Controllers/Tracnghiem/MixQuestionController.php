<?php

namespace App\Http\Controllers\Tracnghiem;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\VmDefine;
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

    public function _outDataView($data)
    {
        $optionApprove = getOption($this->arrApprove, isset($data['question_approved']) ? $data['question_approved'] : STATUS_SHOW);
        $optionStatus = getOption($this->arrStatus, isset($data['question_status']) ? $data['question_status'] : STATUS_SHOW);


        $arrBlock = app(VmDefine::class)->getArrByType(TRAC_NGHIEM_KHOI_LOP);
        $optionBlock = getOption($arrBlock, isset($data['question_school_block']) ? $data['question_school_block'] : STATUS_DEFAULT);

        $arrSubs = app(VmDefine::class)->getArrByType(TRAC_NGHIEM_MON_HOC);
        $optionSubs = getOption($arrSubs, isset($data['question_subject']) ? $data['question_subject'] : STATUS_DEFAULT);


        $arrThematic= app(VmDefine::class)->getArrByType(TRAC_NGHIEM_CHUYEN_DE);
        $optionThematic = getOption($arrThematic, isset($data['question_thematic']) ? $data['question_thematic'] : STATUS_DEFAULT);


        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'optionApprove' => $optionApprove,
            'pageAdminTitle' => CGlobal::$pageAdminTitle,

            'optionBlock' => $optionBlock,
            'optionSubs' => $optionSubs,
            'optionThematic' => $optionThematic,

            'arrBlock' => $arrBlock,
            'arrSubs' => $arrSubs,
            'arrThematic' => $arrThematic,
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

        $search['mix_name'] = addslashes(Request::get('mix_name', ''));
        $search['mix_num'] = (int)(Request::get('mix_num', 0));
        $search['mix_year'] = Request::get('mix_year', date('Y'));
        $search['question_school_block'] = (int)Request::get('question_school_block', -1);
        $search['question_subject'] = (int)Request::get('question_subject', -1);
        $search['question_thematic'] = (int)Request::get('question_thematic', -1);

        $data = app(Question::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $pageNo, $data['total'], $limit, $search) : '';

        $this->_outDataView($search);
        return view('tracnghiem.MixQuestion.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
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
            $output =  view('tracnghiem.MixQuestion.form_exam_question',['questions'=>$du_lieu_da_tron,
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
