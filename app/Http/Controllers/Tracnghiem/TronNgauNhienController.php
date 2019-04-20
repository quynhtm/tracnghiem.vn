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

class TronNgauNhienController extends BaseAdminController{

	private $permission_view = 'tronde_ngaunhien_view';
	private $permission_create = 'ronde_ngaunhien_create';
	private $permission_edit = 'ronde_ngaunhien_edit';
	private $permission_remove = 'ronde_ngaunhien_remove';

	public function __construct(){
		parent::__construct();
	}

	public function getRaDeTuFile(){

		CGlobal::$pageAdminTitle = "Trộn đề từ file | Admin CMS";
		//check permission
		if (!$this->checkMultiPermiss([$this->permission_view])) {
			return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
		}

		$dataSearch['question_name'] = Request::get('question_name', '');
		$dataSearch['question_type'] = Request::get('question_type', STATUS_DEFAULT);
		$dataSearch['created_at_from'] = Request::get('created_at_from', date('d-m-Y', time()));
		$dataSearch['created_at_to'] = Request::get('created_at_to', date('d-m-Y', time()));


		$page_no = Request::get('page_no', 1);
		$limit = CGlobal::number_limit_show;
		$offset = $stt = ($page_no - 1) * $limit;


		$dataSearch = app(Question::class)->searchByCondition($dataSearch, $limit, $offset, true);
		$data = isset($dataSearch['data']) ? $dataSearch['data'] :array();
		$total = isset($dataSearch['total']) ? $dataSearch['total'] : 0;

		$paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $dataSearch) : '';

		return view('tracnghiem.TronNgauNhien.TronTuFile', [
			'data' => $data,
			'dataSearch' => $dataSearch,
			'total' => $total,
			'stt' => $stt,
			'paging' => $paging,
		]);
	}
	public function postRaDeTuFile(){
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
}
