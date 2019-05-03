<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 08/2016
* @Version	 : 1.0
*/

namespace App\Http\Controllers\Tracnghiem;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\VmDefine;
use App\Http\Models\Tracnghiem\Question;
use App\Library\AdminFunction\CExtracts;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\CZips;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class TronNgauNhienController extends BaseAdminController{

	private $viewPermission = array();
	private $error = array();
	private $arrApprove = array();

	public function __construct(){
		parent::__construct();

		CGlobal::$pageAdminTitle = "Trộn đề từ file | Admin CMS";
	}

	public function _getDataDefault(){

		$this->arrApprove = Question::$arrApprove;

		if(!$this->is_root){
			unset($this->arrApprove[STATUS_INT_HAI]);
		}

		$this->viewPermission = [
			'is_root' => $this->is_root,
			'permission_full' => $this->checkPermiss(PERMISS_TRONDE_NGAUNHIEN_FULL),
			'permission_view' => $this->checkPermiss(PERMISS_TRONDE_NGAUNHIEN_VIEW),
			'permission_create' => $this->checkPermiss(PERMISS_TRONDE_NGAUNHIEN_CREATE),
			'permission_delete' => $this->checkPermiss(PERMISS_TRONDE_NGAUNHIEN_DELETE),
			'permission_approve' => $this->checkPermiss(PERMISS_TRONDE_NGAUNHIEN_APPROVE),
			'permission_uploadfile' => $this->checkPermiss(PERMISS_TRONDE_NGAUNHIEN_UPLOADFILE),
		];
	}

	public function _outDataView($data){


		$arrBlock = app(VmDefine::class)->getArrByType(TRAC_NGHIEM_KHOI_LOP);
		$optionBlock = getOption($arrBlock, isset($data['question_school_block']) ? $data['question_school_block'] : STATUS_DEFAULT);

		$arrSubs = app(VmDefine::class)->getArrByType(TRAC_NGHIEM_MON_HOC);
		$optionSubs = getOption($arrSubs, isset($data['question_subject']) ? $data['question_subject'] : STATUS_DEFAULT);


		$arrThematic= app(VmDefine::class)->getArrByType(TRAC_NGHIEM_CHUYEN_DE);
		$optionThematic = getOption($arrThematic, isset($data['question_thematic']) ? $data['question_thematic'] : STATUS_DEFAULT);

		return $this->viewOptionData = [
			'optionBlock' => $optionBlock,
			'optionSubs' => $optionSubs,
			'optionThematic' => $optionThematic,

			'arrBlock' => $arrBlock,
			'arrSubs' => $arrSubs,
			'arrThematic' => $arrThematic,
		];
	}

	public function getQuestionFile(){

		if (!$this->checkMultiPermiss([PERMISS_TRONDE_NGAUNHIEN_FULL, PERMISS_TRONDE_NGAUNHIEN_VIEW])) {
			return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
		}
		$dataSearch['question_name'] = Request::get('question_name', '');
		$dataSearch['question_type'] = Request::get('question_type', STATUS_DEFAULT);
		$dataSearch['created_at_from'] = Request::get('created_at_from', date('d-m-Y', time()));
		$dataSearch['created_at_to'] = Request::get('created_at_to', date('d-m-Y', time()));
		$page_no = Request::get('page_no', 1);
		$limit = CGlobal::number_show_1000;
		$offset = $stt = ($page_no - 1) * $limit;

		$dataSearch = app(Question::class)->searchByCondition($dataSearch, $limit, $offset, true);
		$data = isset($dataSearch['data']) ? $dataSearch['data'] :array();
		$total = isset($dataSearch['total']) ? $dataSearch['total'] : 0;
		$paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $dataSearch) : '';

		$this->_getDataDefault();
		$this->_outDataView($dataSearch);
		return view('tracnghiem.TronNgauNhien.TronTuFile', array_merge([
			'data' => $data,
			'dataSearch' => $dataSearch,
			'total' => $total,
			'stt' => $stt,
			'paging' => $paging,
			'arrApprove' => $this->arrApprove,
			'arrTypeQuestionText' => CExtracts::$arrTypeQuestionText
		], $this->viewPermission, $this->viewOptionData));

	}
	public function postQuestionFile(){
		if (!$this->checkMultiPermiss([PERMISS_TRONDE_NGAUNHIEN_FULL, PERMISS_TRONDE_NGAUNHIEN_UPLOADFILE])) {
			return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
		}
		if(isset($_POST) && isset($_FILES) && sizeof($_FILES) > 0){
			$file = app(Upload::class)->uploadFile('myFile', 'docx', 'files', 5 * 1024 * 1024, $id=0, true);

			$dataSearch['question_school_block'] = (int)Request::get('question_school_block', 0);
			$dataSearch['question_subject'] = (int)Request::get('question_subject', 0);
			$dataSearch['question_thematic'] = (int)Request::get('question_thematic', 0);

			if($file != ''){
				$path = app(FunctionLib::class)->getRootPath().'uploads/'.$file;
				if(is_file($path)){
					$arrText = CExtracts::extractsText($path);
					$arrCheck = array_keys(CExtracts::$arrTypeQuestion);
					$result = CExtracts::extractsQuestions($arrText, $arrCheck);
					$dataInput = CExtracts::extractsCreateOneQuestions($result, $dataSearch);
					app(Question::class)->insertMultiple($dataInput);
					return Redirect::route('tronNgauNhien.getTronNgauNhien');
				}else{
					die('Không tồn tại đường dẫn file!');
				}
			}
		}else{
			return Redirect::route('tronNgauNhien.getTronNgauNhien');
		}
	}

	public function getItem($id=0){
		if (!$this->checkMultiPermiss([PERMISS_TRONDE_NGAUNHIEN_FULL, PERMISS_TRONDE_NGAUNHIEN_CREATE])) {
			return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
		}

		$this->_getDataDefault();
		$data = array();

		if($id > 0){
			$data = app(Question::class)->getItemById($id);
		}
		if(isset($data->id)){
			$optionApprove = getOption($this->arrApprove, isset($data['question_approved']) ? $data['question_approved'] : STATUS_INT_AM_MOT);
			$optionType = getOption(CExtracts::$arrTypeQuestionText, isset($data['question_type']) ? $data['question_type'] : STATUS_INT_MOT);
			return view('tracnghiem.TronNgauNhien.add', array_merge([
				'id'=>$id,
				'data'=>$data,
				'optionApprove'=>$optionApprove,
				'optionType'=>$optionType,
			], $this->viewPermission));
		}
		return Redirect::route('tracnghiem.questionView')->with('status_error', viewLanguage('Không tồn câu hỏi này.'));
	}
	public function postItem($id=0){
		if (!$this->checkMultiPermiss([PERMISS_TRONDE_NGAUNHIEN_FULL, PERMISS_TRONDE_NGAUNHIEN_CREATE])) {
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
				if (app(Question::class)->updateItem($id, $data)) {
					return Redirect::route('tracnghiem.questionView');
				}
			} else {
				if (app(Question::class)->createItem($data)) {
					return Redirect::route('tracnghiem.questionView');
				}
			}
		}

		$this->_getDataDefault();
		$optionApprove = getOption($this->arrApprove, isset($data['question_approved']) ? $data['question_approved'] : STATUS_INT_AM_MOT);
		$optionType = getOption(CExtracts::$arrTypeQuestionText, isset($data['question_type']) ? $data['question_type'] : STATUS_INT_MOT);

		return view('tracnghiem.Question.add', array_merge([
			'data' => $data,
			'id' => $id,
			'error' => $this->error,
			'optionApprove'=>$optionApprove,
			'optionType'=>$optionType,
		], $this->viewPermission));
	}
	public function delete(){
		$data['isIntOk'] = 0;
		if (!$this->checkMultiPermiss([PERMISS_TRONDE_NGAUNHIEN_FULL, PERMISS_TRONDE_NGAUNHIEN_DELETE])) {
			return Response::json($data);
		}
		$id = (int)Request::get('id', 0);
		$item = Question::find($id);
		if ($item) {
			if (app(Question::class)->deleteItem($id)) {
				$data['isIntOk'] = 1;
			}
		}
		return Response::json($data);
	}

	public function approve(){

		if (!$this->checkMultiPermiss([PERMISS_TRONDE_NGAUNHIEN_FULL, PERMISS_TRONDE_NGAUNHIEN_APPROVE])) {
			return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
		}

		$items = Request::get('item', array());
		if(!empty($items)){
			foreach($items as $id){
				$data['question_approved'] = STATUS_INT_MOT;
				app(Question::class)->updateItem($id, $data);
			}
			return Redirect::route('tracnghiem.questionView')->with('status', 'Cập nhật thành công!');
		}else{
			return Redirect::route('tracnghiem.questionView')->with('status_error', 'Cập nhật thất bại!');
		}
	}
	public function approveRoot(){
		if (!$this->checkMultiPermiss([PERMISS_TRONDE_NGAUNHIEN_FULL, PERMISS_TRONDE_NGAUNHIEN_APPROVE_ROOT])) {
			return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
		}

		$items = Request::get('item', array());
		$valAprove = (int)Request::get('valAprove', -1);

		if(!empty($items)){
			foreach($items as $id) {
				if (isset(Question::$arrApprove[$valAprove])){
					$data['question_approved'] = $valAprove;
					app(Question::class)->updateItem($id, $data);
				}
			}
			return Redirect::route('tracnghiem.questionView')->with('status', 'Cập nhật thành công!');
		}else{
			return Redirect::route('tracnghiem.questionView')->with('status_error', 'Cập nhật thất bại!');
		}
	}

	private function _validData($data = array()){
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

	//Demo zip

	private function zipFiles(){
		$data['directory'][] = "/Volumes/PROJECT/xampp/project.vn/Edu/trondethi.vn/uploads/DeThi/MaDe_10";
		$data['directory'][] = "/Volumes/PROJECT/xampp/project.vn/Edu/trondethi.vn/uploads/DeThi/MaDe_11";
		$data['file'] = '/Volumes/PROJECT/xampp/project.vn/Edu/trondethi.vn/uploads/file_cau_hoi_mau1.docx';
		$a = app(CZips::class)->zipPclZip($data, $name='/Volumes/PROJECT/xampp/project.vn/Edu/trondethi.vn/uploads/Archive.zip');
		vmDebug($a);
	}
}
