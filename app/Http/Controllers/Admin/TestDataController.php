<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\Loaners;
use App\Http\Models\Admin\Lenders;
use App\Http\Models\Admin\Loans;
use App\Http\Models\Admin\Products;
use App\Http\Models\Admin\User;
use App\Services\ElasticSearchService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;

class TestDataController extends BaseAdminController
{

    private $elasticService;

    public function __construct(ElasticSearchService $elasticService)
    {
        parent::__construct();
        $this->elasticService = $elasticService;
    }

    public function testDataUser() {
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard', array('error' =>STATUS_INT_MOT));
        }
        /*
         * 1	Admin
            4	CSKH
            5	VH1
            6	VH2
            7	TĐ1
            8	TĐ2
            9	Thu nợ
            10	QL nợ
            11	KT
            12	TP VH
            13	GĐ
            14	TP KT
            15	Khóa
            16	Lead CSKH
            17	NDT
            18	MKT
         */

        /**
         *  6	    Admin ------1
            7		Tech code
            11		CSKH ------4
            12		Đăng nhập mặc đinh
            13		Vận hành 1 ------5
            14		Vận hành 2 ------6
            15		Thẩm định 1 ------7
            16		Thẩm định 2 ------8
            17		Thu nợ nhóm 1 ------9
            18		Quản lý nợ ------10
            19		Kế toán ------11
            20		Trưởng phòng Vận hành ------12
            21		Giám đốc ------13
            22		Trưởng phòng Kế toán ------14
            23		Lead CSKH ------16
            24		Nhà đầu tư ------17
            25		Maketting ------18
            26		Thu nợ nhóm 2
            27		Thu nợ nhóm 3
            28		Thu nợ nhóm 4
            29		Thu nợ nhóm 5
            30		Thu nợ nhóm 6
         */
        $arrRole = [
            1=>6,
            4=>11,
            5=>13,
            6=>14,
            7=>15,
            8=>16,
            9=>17,
            10=>18,
            11=>19,
            12=>20,
            13=>21,
            14=>22,
            16=>23,
            17=>24,
            18=>25,
        ];
        $users = DB::table('users')->get();
        $ojb = new User();
        $i=0;
        foreach ($users as $u){
            $dataUserNew = [
                'user_id'=>$u->id,
                'user_full_name'=>$u->name,
                'user_name'=>$u->account,
                'user_password'=>'vaymuon6789',
                'role_type'=>isset($arrRole[$u->role_id])? $arrRole[$u->role_id]: 12,//quyền đăng nhập mặc định ứng với quyền cũ: $u->role_id
                'user_group'=>3,//quyền
                'user_group_menu'=>76,//user đăng nhập mặc định
                'position'=>112,//chức vụ
                'change_pass'=>STATUS_INT_KHONG,//change pass
                'user_email'=>$u->email,
                'user_status'=>($u->role_id == 15)? STATUS_BLOCK: STATUS_SHOW,
            ];
            $ojb->createNew($dataUserNew);
            $i++;
        }
        vmDebug($i);
    }

    public function testElasticsearchService() {
        dd($this->elasticService->countRecordByGroup(new Lenders, 'status'));
        dd($this->elasticService->search(new Lenders, ['stored_fields'=>'_none_', 'field_get' => 'id']));
        $time_start = microtime(true); 
        $searchFields = [
            'Loans' => ['status' => 'huy', 'field_get' => 'id,code,amount,duration,created_at,status,approve_amount,approve_duration,loaner_id,product_id'],
            'Loaners' => ['full_name' => 'a', 'field_get' => 'id,full_name,so_can_cuoc'],
            'Products' => ['field_get' => 'id,name'],
            'sort' => ['id' => 'desc']
        ];

        $models = [
            'root' => 'Loans',
            'loaner_id' => 'Loaners',
            'product_id' => 'Products'
        ];

        $r = $this->elasticService->searchMultiTable($models, $searchFields);
        
        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        dd($r, $execution_time);
        // $r = $this->elasticService->find('Loans', 32);
        
    }

    public function clearCache(){
        Artisan::call('cache:clear');die;
    }

    /**
     * @return mixed
     * run test crộnb
     */
    public function runCronjob(){
        //Check phan quyen.
        if (!$this->checkMultiPermiss()) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $nameCronjob = trim(Request::get('job', ''));
        if($nameCronjob != ''){
            Artisan::call('cronjob:'.$nameCronjob);
        }else{
            echo 'Chưa nhập tên cronjob để chạy, hãy nhập lại';
        }

    }
}
