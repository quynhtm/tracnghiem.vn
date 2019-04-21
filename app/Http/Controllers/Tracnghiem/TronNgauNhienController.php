<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 08/2016
* @Version	 : 1.0
*/

namespace App\Http\Controllers\Tracnghiem;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Tracnghiem\Question;
use App\Library\AdminFunction\CExtracts;
use App\Library\AdminFunction\CGlobal;
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

		$this->arrApprove = array(
			STATUS_INT_AM_MOT => viewLanguage('--Chọn duyệt--'),
			STATUS_INT_KHONG => viewLanguage('Chưa duyệt'),
			STATUS_INT_MOT => viewLanguage('Chờ duyệt'),
			STATUS_INT_HAI => viewLanguage('Đã duyệt')
		);

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

		return view('tracnghiem.TronNgauNhien.TronTuFile', array_merge([
			'data' => $data,
			'dataSearch' => $dataSearch,
			'total' => $total,
			'stt' => $stt,
			'paging' => $paging,
			'arrApprove' => $this->arrApprove,
		], $this->viewPermission));

	}
	public function postQuestionFile(){
		if(isset($_POST) && isset($_FILES) && sizeof($_FILES) > 0){
			$file = app(Upload::class)->uploadFile('myFile', 'docx', 'files', 5 * 1024 * 1024, $id=0, true);
			if($file != ''){
				$path = app(FunctionLib::class)->getRootPath().'uploads/'.$file;
				if(is_file($path)){
					$arrText = CExtracts::extractsText($path);
					$arrCheck = array_keys(CExtracts::$arrTypeQuestion);
					$result = CExtracts::extractsQuestions($arrText, $arrCheck);
					$dataInput = CExtracts::extractsCreateOneQuestions($result);
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
			return view('tracnghiem.TronNgauNhien.add', array_merge([
				'id'=>$id,
				'data'=>$data,
				'optionApprove'=>$optionApprove,
			], $this->viewPermission));
		}
		return Redirect::route('tronNgauNhien.getTronNgauNhien')->with('status_error', viewLanguage('Không tồn câu hỏi này.'));
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
					return Redirect::route('tronNgauNhien.getTronNgauNhien');
				}
			} else {
				if (app(Question::class)->createItem($data)) {
					return Redirect::route('tronNgauNhien.getTronNgauNhien');
				}
			}
		}

		$this->_getDataDefault();
		$optionApprove = getOption($this->arrApprove, isset($data['question_approved']) ? $data['question_approved'] : STATUS_INT_AM_MOT);

		return view('tracnghiem.Question.add', array_merge([
			'data' => $data,
			'id' => $id,
			'error' => $this->error,
			'optionApprove'=>$optionApprove,
		], $this->viewPermission));
	}
	public function delete(){
		$data['isIntOk'] = 0;
		if(!$this->is_root && !in_array($this->permission_delete, $this->permission)) {
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
		$items = Request::get('item', array());
		if(!empty($items)){
			foreach($items as $id){
				$data['question_approved'] = STATUS_INT_MOT;
				app(Question::class)->updateItem($id, $data);
			}
			return Redirect::route('tronNgauNhien.getTronNgauNhien')->with('status', 'Cập nhật thành công!');
		}else{
			return Redirect::route('tronNgauNhien.getTronNgauNhien')->with('status_error', 'Cập nhật thất bại!');
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
}
