<?php
/**
 * QuynhTM
 */

namespace App\Http\Commands;

use App\Services\LoansSplit\ServiceLoanSplit;
use Exception;
use Illuminate\Console\Command;
use App\Http\Controllers\Notification\VMNotification;
use Illuminate\Support\Facades\DB;
use Monolog\Logger;

class CronChiaYCVKheUoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:CronChiaYCVKheUoc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob chia YCV khế ước';// Video

    protected $_notification;
    private $logger;

    /**
     * Create a new command instance.
     *
     * @param VMNotification $notification
     */
    public function __construct(VMNotification $notification)
    {
        $this->_notification = $notification;

        parent::__construct();
        $this->logger = new Logger('CronChiaYCVKheUoc');
    }

    public function set($key, $value, $default = null)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        } else {
            $this->$key = $default;
        }
    }

    public function get($key, $default = null)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        } else {
            return $default;
        }
    }

    public function handle()
    {
       //lấy user VH đăng nhập
        $userVH = app(ServiceLoanSplit::class)->getUserSplitLoan(USER_POSITION_VH2);
        $name_file_log ='chia_khe_uoc_date_'.getParamDate().'.log';
        $name_folder = 'chia_ycv_khe_uoc_'.getParamDate('m').'_'.getParamDate('Y');

        if(!empty($userVH)){
            //danh sach YCV sẽ chia
            $dataLoan = app(ServiceLoanSplit::class)->getListLoanSplit(STATUS_STRING_CHO_KHE_UOC);
            $tong_user_online = count($userVH);

            $tong_ycv_mmoi = $dataLoan['total_loan_new'];
            $data_loan_moi = $dataLoan['loan_new'];

            $tong_ycv_cu = $dataLoan['total_loan_old'];
            $data_loan_cu = $dataLoan['loan_old'];

            //cả 2 data YCV đều lớn hơn tổng số người online
            $result_split_new = $result_split_old = [];
            $title_result = '';
            if($tong_ycv_mmoi > $tong_user_online && $tong_ycv_cu > $tong_user_online){
                $result_split_new = app(ServiceLoanSplit::class)->chiaYcvChoVanHanh($tong_ycv_mmoi,$data_loan_moi,$tong_user_online, $userVH);
                $result_split_old = app(ServiceLoanSplit::class)->chiaYcvChoVanHanh($tong_ycv_cu,$data_loan_cu,$tong_user_online, $userVH);
                //log file
                $title_result = 'Cũ và Mới lớn hơn số online';
            }
            else{
                //Mới > tổng số online
                if($tong_ycv_mmoi > $tong_user_online){
                    $result_split_new = app(ServiceLoanSplit::class)->chiaYcvChoVanHanh($tong_ycv_mmoi,$data_loan_moi,$tong_user_online, $userVH);
                    $title_result = 'Mới lớn hơn số online';
                }
                //Cũ > tổng số online
                elseif($tong_ycv_cu > $tong_user_online){
                    $result_split_old = app(ServiceLoanSplit::class)->chiaYcvChoVanHanh($tong_ycv_cu,$data_loan_cu,$tong_user_online, $userVH);
                    $title_result = 'CŨ lớn hơn số online';
                }
            }
            //log file
            $dataLog['title_result'] = (trim($title_result) != '')? $title_result: 'Khong co du lieu de chia';
            $dataLog['tong_ycv_mmoi'] = $tong_ycv_mmoi;
            $dataLog['data_loan_moi'] = $data_loan_moi;
            $dataLog['tong_user_online'] = $tong_user_online;
            $dataLog['userVH'] = $userVH;
            $dataLog['dataLoanChiaMoi'] = $result_split_new;
            $dataLog['dataLoanChiaCũ'] = $result_split_old;

            debugLog($dataLog,$name_file_log,$name_folder);
            endLog($name_file_log,$name_folder);
            vmDebug($dataLog);
            die();

        }
        $dataLog['title_result'] = ' Không co user VH online';

        debugLog($dataLog,$name_file_log,$name_folder);
        endLog($name_file_log,$name_folder);
        die('Không có user VH online');
    }

}

?>