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
        $du_lieu_da_tron = self::mixAutoQuestion($dataTron);
        vmDebug($du_lieu_da_tron);
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

    public function mixAutoQuestion($data=[]){
        $total = count($data);
        $result = [];
        if($total > 0){
            for( $i = 1 ; $i <= $total ; $i++ ){
                $random_keys=array_rand($data,1);
                $question = $data[$random_keys];
                //answer
                $question['list_answer'] = self::mixAutoAnswer($question['list_answer']);
                $result[$random_keys]= $question;
                unset($data[$random_keys]);
            }
        }
        return $result;
    }

    public function mixAutoAnswer($data=[]){
        $total = count($data);
        $result = [];
        if($total > 0){
            for( $i = 1 ; $i <= $total ; $i++ ){
                $random_keys=array_rand($data,1);
                $result[$random_keys]= $data[$random_keys];
                unset($data[$random_keys]);
            }
        }
        return $result;
    }

    public function exportContract(){
        $contract_id = (int)Request::get('contract_id',3);
        $type = (int)Request::get('type',1);
        if($contract_id > 0){
            $data1 = Contract::getContractById($contract_id);
        }
        $data = isset($data1['data'])?$data1['data']:array();
        if(!$this->is_root && !in_array($this->admin_contract,$this->permission) && !in_array($this->permiss_export_pdf,$this->permission)){
            if((int)$data['admin_id'] !== (int)$this->user['admin_id']){
                return Redirect::route('adminContract.index');
            }
        }
        if(empty($data))
            return;

        $data['contract_province_name'] = CGlobal::$aryProvince[$data['contract_province']];
        $data['today'] = time();
        $data['type_export'] = $type;
        $template = ($data['contract_type']== 1)?'admin.AdminAppendix.pdfs.HDSP':'admin.AdminAppendix.pdfs.HDDV';
        if($type == 1){
            $output = View::make($template)->with('data',$data);
            $filepath = "HDKD.doc";
            @header("Cache-Control: ");// leave blank to avoid IE errors
            @header("Pragma: ");// leave blank to avoid IE errors
            @header("Content-type: application/octet-stream");
            @header("Content-Disposition: attachment; filename=\"{$filepath}\"");
            echo $output;die;
        }elseif($type == 2){
            $html = View::make($template)->with('data',$data)->render();
            $signature = false;
            $this->filename = "HDKD.pdf";
            $this->pdfOutput($html, $this->filename, 'I', $signature);
        }
    }

    public function clearCache(){
        Artisan::call('cache:clear');die;
    }
}
