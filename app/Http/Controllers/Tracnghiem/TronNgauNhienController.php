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
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\Upload;
use Illuminate\Support\Facades\Redirect;

class TronNgauNhienController extends BaseAdminController{
	
	public function __construct(){
		parent::__construct();
	}
	public function getRaDeTuFile(){
		return view('tracnghiem.TronNgauNhien.TronTuFile', []);
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
					echo 'Upload thành công';
					FunctionLib::bug($dataInput);
				}else{
					die('Không tồn tại đường dẫn file!');
				}
			}
		}else{
			return Redirect::route('tronNgauNhien.getTronNgauNhien');
		}
	}
}
