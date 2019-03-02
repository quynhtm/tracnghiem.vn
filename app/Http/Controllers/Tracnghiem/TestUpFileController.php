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
use App\Library\AdminFunction\FunctionLib;
use PhpOffice\PhpWord\IOFactory;

class TestUpFileController extends BaseAdminController{
	
	public function __construct(){
		parent::__construct();
	}

	public function post_1(){
		$phpWord = IOFactory::load(app(FunctionLib::class)->getRootPath().'uploads/files/toan 6-chuong 1.docx');
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
			FunctionLib::bug($result);
		}
		return view('admin.news.post',[]);
	}
    public function post(){
        $phpWord = IOFactory::load(app(FunctionLib::class)->getRootPath().'uploads/files/toan 6-chuong new.docx');
        $sections = $phpWord->getSections();
        $arrItem = [];
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
                $item = trim($item);
                $arrX = explode('NB.', trim($item));
                if(count($arrX) == 2){
                    $i++;
                    $result[$i]['CH'] = trim(str_replace('NB.', '', $item));
                }else{
					//True
                    $arrX = explode('#$.', $item);
                    if(count($arrX) == 2){
                        $result[$i]['TL'] =  trim(str_replace('#$.', '', $item));
                    }
                    //False
                    $arrX = explode('#.', $item);
                    if(count($arrX) == 2){
                        $result[$i][$k] =  trim(str_replace('#.', '', $item));
                    }
                }
            }

            foreach($result as $k => $item){
				$tmp = [];
				$i = 0;
				foreach($item as $_k => $v){
					if($_k == 'CH'){
						$tmp['question_name'] = $item['CH'];
					}else{
						$i++;
						if($_k == 'TL'){
							$tmp['correct_answer'] = $i;

						}
						$tmp['answer_'.$i] = $v;
					}
				}
				app(Question::class)->createItem($tmp);
		    }
        }
    }
}
