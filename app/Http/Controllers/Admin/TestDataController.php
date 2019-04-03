<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\Loaners;
use App\Http\Models\Admin\Lenders;
use App\Http\Models\Admin\Loans;
use App\Http\Models\Admin\Products;
use App\Http\Models\Admin\User;
use App\Http\Models\Tracnghiem\Question;
use App\Services\ElasticSearchService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;

class TestDataController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testDataUser() {
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard', array('error' =>STATUS_INT_MOT));
        }
        $arrField = ['id','question_name','answer_1','answer_2','answer_3','answer_4','answer_5','answer_6','correct_answer'];
        $data = Question::where('id','>',0)->get($arrField);
        $dataTron = [];
        if($data){
            foreach ($data->toArray() as $v){
                $list_dap_an = [
                    'answer_1'=>$v['answer_1'],
                    'answer_2'=>$v['answer_2'],
                    'answer_3'=>$v['answer_3'],
                    'answer_4'=>$v['answer_4'],
                    'answer_5'=>$v['answer_5'],
                    'answer_6'=>$v['answer_6']];
                $kkk = 1;
                foreach ($list_dap_an as $key=>$da){
                    $kk = ($key === 'answer_'.$v['correct_answer'])? 13: $kkk;
                    $arrDapAn[$kk] = $da;
                    $kkk ++;
                }
                $v['dap_an'] = $list_dap_an;
                $v['list_dap_an'] = $arrDapAn;
                $dataTron[] = $v;
            }
        }

        vmDebug($dataTron);
    }
    public function tronAuto(){
        $a = [['red'=>'red'],['red1'=>'red1'],['red2'=>'red2'],['red3'=>'red3']];
        $resul = [];
        for( $i= 0 ; $i <= 100 ; $i++ ){
            $random_keys=array_rand($a,1);
            $key_new = key($a[$random_keys]);
            $resul[$key_new]= $a[$random_keys];
            if(count($resul)==4){
                break;
            }
        }
        vmDebug('mang moi',false);
        vmDebug($a,false);
        vmDebug('mang tron',false);
        vmDebug($resul);
    }
    public function clearCache(){
        Artisan::call('cache:clear');die;
    }
}
