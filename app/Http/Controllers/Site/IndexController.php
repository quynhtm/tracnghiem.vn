<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 08/2016
* @Version	 : 1.0
*/

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseSiteController;
use App\Library\AdminFunction\FunctionLib;

class IndexController extends BaseSiteController{
	
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		echo "Index";
		$this->header();
		$this->slider();
		$this->footer();
	}
    public function actionRouter($catname, $catid){
        
    }
	public function post(){
		if(isset($_FILES)){
			$phpWord = \PHPExcel_IOFactory::load(app(FunctionLib::class)->getRootPath().'uploads/files/Cap nhat nhieu loai cau.docx');
			$sections = $phpWord->getSections();
			$arrItem = $color = [];
			foreach($sections as $s) {
				$els = $s->getElements();
				foreach ($els as $elementKey => $elementValue) {
					if($elementValue instanceof \PhpOffice\PhpWord\Element\TextRun) {
						$secondSectionElement = $elementValue->getElements();
						$text = '';
						foreach($secondSectionElement as $secondSectionElementKey => $secondSectionElementValue) {
							if($secondSectionElementValue instanceof \PhpOffice\PhpWord\Element\Text) {
								//Sentence
								$text .= $secondSectionElementValue->getText();

								//Color
								$secondFont = $secondSectionElementValue->getFontStyle();
								if($secondFont->getColor() != '' && $secondSectionElementValue->getText() != ' '){
									$arrExp = explode('.', $secondSectionElementValue->getText());
									if(count($arrExp) == 2){
										$color[][trim($secondSectionElementValue->getText())] = $secondFont->getColor();
									}
								}
							}
						}
						$arrItem[] = $text;
					}
				}
			}
			$result = [];
			if(sizeof($arrItem) > 0){
				$i = 0;
				foreach($arrItem as $k=>$item){
					$arrX = explode('#', $item);
					if(count($arrX) == 2){
						$i++;
						$result[$i]['CH'] = trim(str_replace('#', '', $item));
						$_color = isset($color[$i-1]) ? $color[$i-1] : [];
						foreach($_color as $k => $cl){$_color = str_replace('.', '', $k);}
						$result[$i]['TL'] =$_color;
					}else{
						$result[$i][] = $item;
					}
				}
				FuncLib::bug($result);
			}
		}
		return view('admin.news.post',[]);
	}
}
