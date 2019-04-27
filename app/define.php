<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 10/17/2016
 * Time: 2:06 PM
 */

define('URL_IMAGE','https://demo.vn');

define('IMAGE_DIRECTORY','uploads');
define('AUDIO_DIRECTORY','demo');

define('KEY_API_REMOVE_CACHE','demo_vn');

define('ES_TYPE', '_doc');
define('LIMIT_ES_MAX', 100);
define('PAGE_SCROLL', 3);
define('LIMIT_RECORD_10', 10);
define('LIMIT_RECORD_15', 15);
define('LIMIT_RECORD_20', 20);
define('LIMIT_RECORD_30', 30);
define('LIMIT_RECORD_50', 50);
define('LIMIT_RECORD_100', 100);
define('LIMIT_RECORD_200', 200);
define('LIMIT_RECORD_300', 300);
define('LIMIT_RECORD_400', 400);
define('LIMIT_RECORD_500', 500);

define('AUTO_LOAN_VALUE', 2);

define('TOTAL_DAY', 360);
define('NGAY', 'ngay');
define('THANG', 'thang');
define('TIME_CANCEL_LOAN', 30);

define('CURRENCY', 'VNĐ');
define('VERSION_APP', '1.0');
define('OPTION_POINT', 5);
define('REQUIRE_POINT', 10);
define('_REQUIRE', 'require');
define('RATE_TYPE', '%/năm');

define('VIETNAM_LANGUAGE', 1);
define('ENGLISH_LANGUAGE', 2);

define('STATUS_HIDE', 0);
define('STATUS_SHOW', 1);
define('STATUS_DEFAULT', -1);
define('STATUS_BLOCK', -2);
define('STATUS_NEW', 0);
define('STATUS_STOP', 2);
define('STATUS_DELETE', -3);

define('SEX_NAM', 0);
define('SEX_NU',  1);

define('STATUS_MOI', 'moi');
define('STATUS_HOAT_DONG', 'hoat_dong');
define('STATUS_KHOA', 'khoa');
define('STATUS_KHOA_VINH_VIEN', 'khoa_vinh_vien');

define('ERROR_PERMISSION',  1);

define('STATUS_INT_AM_HAI', -2);
define('STATUS_INT_AM_MOT', -1);
define('STATUS_INT_KHONG',  0);
define('STATUS_INT_MOT',    1);
define('STATUS_INT_HAI',    2);
define('STATUS_INT_BA',     3);
define('STATUS_INT_BON',    4);
define('STATUS_INT_NAM',    5);
define('STATUS_INT_SAU',    6);
define('STATUS_INT_CHIN',   9);

define('CACHE_FIVE_MINUTE', 300);
define('CACHE_TEN_MINUTE', 600);
define('CACHE_THIRTY_MINUTE', 1800);
define('CACHE_ONE_HOUR', 3600);
define('CACHE_SIX_HOUR', 21600);
define('CACHE_ONE_DAY', 86400);
define('CACHE_TWO_DAY', 172800);
define('CACHE_THREE_DAY', 259200);
define('CACHE_SIX_DAY', 518400);
define('CACHE_ONE_WEEK', 604800);
define('CACHE_ONE_MONTH', 2592000);
define('CACHE_THREE_MONTH', 7776000);
define('CACHE_ONE_YEAR', 31104000);
define('CACHE_FIVE_YEAR', 155520000);

/**************************************************************************************************************
 * define_type hệ thống common
 **************************************************************************************************************/
define('TRAC_NGHIEM_KHOI_LOP',1);
define('TRAC_NGHIEM_MON_HOC',2);
define('TRAC_NGHIEM_CHUYEN_DE',3);
define('TRAC_NGHIEM_CHUC_VU',4);

/**************************************************************************************************************
 * Định nghĩa thư mục chứa file ảnh
 **************************************************************************************************************/
define('FOLDER_FILE_DEFAULT','default');
define('FOLDER_FILE_BILL_EXPENDITURE','bill_expenditure');
define('FOLDER_FILE_USER_ADMIN','user_admin');
define('FOLDER_FILE_TRANSACTION_LOANER','loaner/transaction');
define('FOLDER_FILE_CRONJOB','Cronjob');

define('USER_POSITION_CSKH', 118);//vi tri CSKH
define('USER_POSITION_VH1', 113);//vi tri VH1
define('USER_POSITION_VH2', 114);//vi tri VH2

define('TRUONG_PHONG_VAN_HANH', 20);//role_id trong user

/**************************************************************************************************************
 * định nghĩa Table
 **************************************************************************************************************/
define('PREFIX', 'web_');
define('PREFIX_TRAC_NGHIEM', 'tracnghiem_');

define('TABLE_USER_ADMIN', PREFIX.'user_admin');
define('TABLE_GROUP_USER', PREFIX.'group_user');
define('TABLE_PERMISSION', PREFIX.'permission');
define('TABLE_MENU_SYSTEM',PREFIX.'menu_system');
define('TABLE_ROLE_MENU', PREFIX.'role_menu');
define('TABLE_ROLE',PREFIX.'role');
define('TABLE_DEFINE',PREFIX.'define');
define('TABLE_GROUP_USER_PERMISSION', PREFIX.'group_user_permission');

define('TABLE_QUESTION', PREFIX_TRAC_NGHIEM.'question');
define('TABLE_EXAM', PREFIX_TRAC_NGHIEM.'exam');
define('TABLE_QUESTION_EXAM', PREFIX_TRAC_NGHIEM.'questions_exam');

/**************************************************************************************************************
 * định nghĩa quyền
 **************************************************************************************************************/
//permiss banner
define('PERMISS_BANNER_FULL', 'bannerFull');
define('PERMISS_BANNER_VIEW', 'bannerView');
define('PERMISS_BANNER_CREATE', 'bannerCreate');
define('PERMISS_BANNER_DELETE', 'bannerDelete');

//Permiss DEFINE
define('PERMISS_DEFINE_FULL', 'defineFull');
define('PERMISS_DEFINE_VIEW', 'defineView');
define('PERMISS_DEFINE_CREATE', 'defineCreate');
define('PERMISS_DEFINE_DELETE', 'defineDelete');


//permiss question
define('PERMISS_QUESTION_FULL', 'questionFull');
define('PERMISS_QUESTION_VIEW', 'questionView');
define('PERMISS_QUESTION_CREATE', 'questionCreate');
define('PERMISS_QUESTION_DELETE', 'questionDelete');

//permiss question
define('PERMISS_EXAMQUESTION_FULL', 'examQuestionFull');
define('PERMISS_EXAMQUESTION_VIEW', 'examQuestionView');
define('PERMISS_EXAMQUESTION_CREATE', 'examQuestionCreate');
define('PERMISS_EXAMQUESTION_DELETE', 'examQuestionDelete');


//Upload trộn đề ngẫu nhiên
define('PERMISS_TRONDE_NGAUNHIEN_FULL', 'tronDeNgauNhienFull');
define('PERMISS_TRONDE_NGAUNHIEN_VIEW', 'tronDeNgauNhienView');
define('PERMISS_TRONDE_NGAUNHIEN_CREATE', 'tronDeNgauNhienCreate');
define('PERMISS_TRONDE_NGAUNHIEN_DELETE', 'tronDeNgauNhienDelete');
define('PERMISS_TRONDE_NGAUNHIEN_APPROVE', 'tronDeNgauNhienApprove');
define('PERMISS_TRONDE_NGAUNHIEN_APPROVE_ROOT', 'tronDeNgauNhienApproveRoot');
define('PERMISS_TRONDE_NGAUNHIEN_UPLOADFILE', 'tronDeNgauNhienUploadFile');

