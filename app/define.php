<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 10/17/2016
 * Time: 2:06 PM
 */

define('URL_IMAGE','https://v3.vaymuon.vn');

define('IMAGE_DIRECTORY','uploads');
define('AUDIO_DIRECTORY','vaymuon');

define('KEY_API_REMOVE_CACHE','vaymuon_ver_4');

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

define('STEP_NUM_SPLIT_CDC1',  1);//chờ duyệt cấp 1
define('STEP_NUM_SPLIT_KHEUOC',  2);//khế ươc - video

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

define('STATUS_STRING_CHO_DUYET',   'cho_duyet');
define('STATUS_STRING_DA_DUYET',    'da_duyet');
define('STATUS_STRING_CHUA_CO',     'chua_co');
define('STATUS_STRING_MOI',         'moi');
define('STATUS_STRING_LOAI',        'loai');
define('STATUS_STRING_DUYET',       'duyet');
define('STATUS_STRING_XEP_HANG',    'xep_hang');
define('STATUS_STRING_DANG_CAP_NHAT','dang_cap_nhat');
define('STATUS_STRING_CHO_DUYET_CAP_1', 'cho_duyet_cap_1');
define('STATUS_STRING_CHO_DUYET_CAP_2', 'cho_duyet_cap_2');
define('STATUS_STRING_THAM_DINH', 'tham_dinh_1');
define('STATUS_STRING_THAM_DINH_2', 'tham_dinh_2');
define('STATUS_STRING_CHO_KHE_UOC', 'cho_khe_uoc');
define('STATUS_STRING_HOAN_THANH', 'hoan_thanh');
define('STATUS_STRING_TU_CHOI', 'tu_choi');

define('STATUS_STRING_DANG_CHO_VAY',    'dang_cho_vay');
define('STATUS_STRING_HOAN_TRA_TIEN',   'hoan_tra_tien');
define('STATUS_STRING_DA_CHI',          'da_chi');
define('STATUS_STRING_DANG_XU_LY',      'dang_xu_ly');
define('STATUS_STRING_DA_TRA_NO',       'da_tra_no');
define('STATUS_STRING_THANH_CONG',      'thanh_cong');

define('STATUS_STRING_CHO_NHAN_HOA_HONG',    'cho_nhan_hoa_hong');
define('STATUS_STRING_DA_THANH_TOAN_LAN_1',   'da_thanh_toan_lan_1');
define('STATUS_STRING_CHO_THANH_TOAN_LAN_2',          'cho_thanh_toan_lan_2');
define('STATUS_STRING_DA_THANH_TOAN_LAN_2',      'da_thanh_toan_lan_2');
define('STATUS_STRING_QUA_HAN',       'qua_han');
define('STATUS_STRING_DA_LIEN_KET',       'da_lien_ket');


define('STEP_NUM_APPROVE_DEFAULT', -1000);
define('STEP_NUM_LOAN_SPLIT_EMPTY', -1);
define('STEP_NUM_LOAN_SPLIT_MOI', -2);
define('STEP_NUM_LOAN_SPLIT_HOAN_THANH', -3);
define('STEP_NUM_LOAN_SPLIT_TU_CHOI', -4);
define('STEP_NUM_LOAN_SPLIT_HUY', -5);

define('STEP_NUM_LOAN_SPLIT_DANG_CAP_NHAT', 0);
define('STEP_NUM_LOAN_SPLIT_CHO_DUYET_CAP_1', 1);
define('STEP_NUM_LOAN_SPLIT_THAM_DINH_1', 2);
define('STEP_NUM_LOAN_SPLIT_THAM_DINH_2', 3);
define('STEP_NUM_LOAN_SPLIT_CHO_KHE_UOC', 4);

define('TYPE_APPROVE_LOANS', 1);
define('TYPE_TRANS_LOANS', 2);
define('TYPE_REFUSE_LOANS', 3);

define('USER_AUTO_LOAN', 2);


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

define('STATUS_RUNNING','running');
define('STATUS_ADD_SUCCESS','Thêm mới thành công');
define('STATUS_ADD_FAILED','Thêm mới thất bại');
define('STATUS_UPDATE_SUCCESS','Thêm mới thành công');
define('STATUS_UPDATE_FAILED','Thêm mới thất bại');

define('LOCK_TIME_30', 30);
define('LOCK_TIME_60', 60);
define('LOCK_TIME_FOREVER', 'forever');

// định nghĩa những hàm trong ajax
// các hàm xoá
define('DELETE_PRODUCT',7);

//maketting
define('MAKETTING_TICH_XU',1);
define('MAKETTING_TIEU_XU',2);

define('WEEKENDS','weekends');
define('EVERYDAY','everyday');
define('EVERYMONTH','everymonth');
define('WEEKDAYS','weekdays');
define('NOLOOP','noloop');

define('TOPIC_TOTAL_LOANER','VM_2018');
define('TOPIC_TOTAL_LENDER','Lender_2018');

define('MAKETTING_DK_NHAN_HDV_GIAI_NGAN_THANH_CONG',1);
define('MAKETTING_DK_NHAN_HDV_THANH_TOAN_DUNG_HAN',2);

define('MAKETTING_ACTION_GUI_NGAY',1);
define('MAKETTING_ACTION_GUI_THEO_LICH',2);
define('MAKETTING_ACTION_GUI_THEO_TIN_NHAN',3);

//define_type hệ thống common
define('THU_NO_DEFINE_TYPE',1);
define('TIEU_CHI_THAM_DINH_DEFINE_TYPE',2);
define('LY_DO_TU_CHOI_DEFINE_TYPE',3);
define('NGAN_HANG_DEFINE_TYPE',4);
define('PHUONG_THUC_CHUYEN_TIEN_DEFINE_TYPE',5);
define('PHUONG_THUC_THANH_TOAN_DEFINE_TYPE',6);
define('NHOM_NO_DEFINE_TYPE',7);
define('DOI_TUONG_AP_DUNG_DEFINE_TYPE',8);
define('MAKETTING_CHINH_SACH_AP_DUNG_DEFINE_TYPE',9);
define('THE_DIEN_THOAI_DEFINE_TYPE',10);
define('REPAYMENT_HISTORY_HINH_THUC',11);
define('REPAYMENT_HISTORY_NOI_DUNG_TRAO_DOI',12);
define('USER_SALE_GROUP',13);//nhóm sale
define('USER_POSITION',14);//chức vụ
define('DEFINE_DEPARMENT',15);//Phòng ban

define('STATUS_CHUA_THANH_TOAN','chua_thanh_toan');
define('STATUS_THANH_TOAN_THIEU','thanh_toan_thieu');
define('STATUS_THANH_TOAN_THUA','thanh_toan_thua');
define('STATUS_THANH_TOAN_TRONG_HAN','thanh_toan_trong_han');
define('STATUS_HOAN_THANH','hoan_thanh');
define('STATUS_TRONG_HAN','trong_han');
define('STATUS_QUA_HAN','qua_han');
define('STATUS_AN_HAN','an_han');
define('STATUS_STRING_CHO_DUYET_HOP_DONG','cho_duyet_hop_dong');
define('STATUS_CHO_GIAI_NGAN','cho_giai_ngan');
define('STATUS_DANG_GIAI_NGAN','dang_giai_ngan');
define('STATUS_GIAI_NGAN_LOI','giai_ngan_loi');
define('STATUS_DA_GIAI_NGAN','da_giai_ngan');
define('STATUS_DONG','dong');
define('STATUS_HUY','huy');
define('STATUS_CHECK_LAI_GIAO_DICH','check_lai_giao_dich');
define('STATUS_THAT_BAI','that_bai');

define('VIMO_TU_DONG','tu_dong');
define('VIMO_THU_CONG','thu_cong');

define('LENDING_STATUS_THU_CONG','thu_cong');
define('LENDING_STATUS_TU_DONG','tu_dong');

define('DISPLAY_DOCUMENT_ENTITY_DISPLAY','display');
define('DISPLAY_DOCUMENT_ENTITY_HIDE','hide');

//phiếu thu chi
define('PHIEU_THU',1);
define('PHIEU_CHI',2);
define('GIAI_NGAN_TU_DONG',1);
define('GIAI_NGAN_THU_CONG',2);
define('PHUONG_THUC_THANH_TOAN_VIMO',1);
define('NGUOI_VAY',1);
define('NHA_DAU_TU',2);
define('NHA_DAM_BAO',3);
define('CONG_TY_VAYMUON',4);

define('CONG_TY_VAYMUON_ID',1);
define('NHA_DAM_BAO_ID',1);

//version app define
define('TYPE_ANDROID','android');
define('TYPE_IOS','ios');
define('TYPE_MAINTENCE','maintence');

//muc dich THU
define('VM_THU_NDT',11);
define('VM_THU_NDB',12);
define('NDB_THU_NGUOI_VAY',13);
define('NDB_THU_KHAC',14);
//muc dich CHI
define('VM_CHI_GIAI_NGAN',21);
define('VM_CHI_HOA_HONG',22);
define('VM_CHI_KHAC',23);
define('NDB_CHI_NHA_DAU_TU',24);
define('NDB_CHI_VAY_MUON',25);

//loại sản phẩm vay
define('TYPE_PRODUCT_TIEN_MAT',1);
define('TYPE_PRODUCT_TIN_DUNG',2);

//loại tiền sản phẩm vay
define('CURRENCY_USD','USD');
define('CURRENCY_VND','VND');

//type duration
define('TYPE_DURATION_NGAY','ngay');
define('TYPE_DURATION_THANG','thang');

define('DEBT_GROUP_1','Nhóm cấp 1');
define('DEBT_GROUP_2','Nhóm cấp 2');
define('DEBT_GROUP_3','Nhóm cấp 3');
define('DEBT_GROUP_4','Nhóm cấp 4');
define('DEBT_GROUP_5','Nhóm cấp 5');
define('DEBT_GROUP_6','Nhóm cấp 6');

define('REPAYMENT_TIEP_NHAN','Tiếp nhận');
define('REPAYMENT_DA_XU_LI','Đã xử lí');

define('DOCUMENT_ENTITY_ATTRIBUTE_CODE_TINH_CHI_NHANH', 'tinh_chi_nhanh');

// Define MARKETING
define('MARKETING_TICH_XU',1);
define('MARKETING_TIEU_XU',2);

define('MARKETING_DK_NHAN_HDV_GIAI_NGAN_THANH_CONG',1);
define('MARKETING_DK_NHAN_HDV_THANH_TOAN_DUNG_HAN',2);

define('MARKETING_ACTION_GUI_NGAY',1);
define('MARKETING_ACTION_GUI_THEO_LICH',2);
define('MARKETING_ACTION_GUI_THEO_TIN_NHAN',3);

define('SPEND_COIN_UU_DAI_VM', 1);
define('SPEND_COIN_NAP_THE_DIEN_THOAI', 2);
define('SPEND_COIN_DOI_MA_VOUCHER', 3);
define('SPEND_COIN_THANH_TOAN', 4);

define('OPTION_POINT_VAY_SIEU_TOC', 'vay_sieu_toc');
/**************************************************************************************************************
 * Định nghĩa thư mục chứa file ảnh
 **************************************************************************************************************/
define('FOLDER_FILE_DEFAULT','default');
define('FOLDER_FILE_BILL_EXPENDITURE','bill_expenditure');
define('FOLDER_FILE_USER_ADMIN','user_admin');
define('FOLDER_FILE_TRANSACTION_LOANER','loaner/transaction');
define('FOLDER_FILE_CRONJOB','Cronjob');

/**************************************************************************************************************
 * Định nghĩa ROLE ID
 **************************************************************************************************************/
define('ROLE_ID_VAN_HANH_1', 5);
define('ROLE_ID_VAN_HANH_2', 6);
define('ROLE_ID_TP_VAN_HANH', 12);

define('ROLE_CODE_CHAM_SOC_KHACH_HANG', 'cskh');
define('ROLE_CODE_VAN_HANH_1', 'vh1');
define('ROLE_CODE_VAN_HANH_2', 'vh2');
define('ROLE_CODE_THAM_DINH_1', 'tham_dinh_1');
define('ROLE_CODE_THAM_DINH_2', 'tham_dinh_2');
define('ROLE_CODE_TP_VAN_HANH', 'tp_van_hanh');
define('ROLE_CODE_ADMIN', 'admin');

/*Dinh nghia cac buoc chia YCV*/
define('STEP_CHIA_YCV_0', 0);//Moi
define('STEP_CHIA_YCV_1', 1);//Dang cap nhat
define('STEP_CHIA_YCV_2', 2);//CD cap 1
define('STEP_CHIA_YCV_3', 3);//Tham dinh 1
define('STEP_CHIA_YCV_4', 4);//Tham dinh 2
define('STEP_CHIA_YCV_5', 5);//Cho khe uoc

//Dinh nghia num apporve in table: user_loan
define('NUM_APPROVE_0', 0);//Moi
define('NUM_APPROVE_1', 1);//Xac nhan
define('NUM_APPROVE_2', 2);//Bo qua - khoa


define('USER_POSITION_CSKH', 118);//vi tri CSKH
define('USER_POSITION_VH1', 113);//vi tri VH1
define('USER_POSITION_VH2', 114);//vi tri VH2


//QuynhTM define role nhóm nợ
define('ROLE_ID_QUAN_LY_NO', 18);
define('ROLE_ID_THU_NO_NHOM_1', 17);
define('ROLE_ID_THU_NO_NHOM_2', 26);
define('ROLE_ID_THU_NO_NHOM_3', 27);
define('ROLE_ID_THU_NO_NHOM_4', 28);
define('ROLE_ID_THU_NO_NHOM_5', 29);
define('ROLE_ID_THU_NO_NHOM_6', 30);

//QuynhTM define id nhóm nợ
define('DEFINE_ID_DEBT_1', 65);
define('DEFINE_ID_DEBT_2', 66);
define('DEFINE_ID_DEBT_3', 67);
define('DEFINE_ID_DEBT_4', 68);
define('DEFINE_ID_DEBT_5', 69);
define('DEFINE_ID_DEBT_6', 70);

define('TRUONG_PHONG_VAN_HANH', 20);//role_id trong user


/**************************************************************************************************************
 * định nghĩa Table vaymuon
 **************************************************************************************************************/
define('PREFIX', 'web_');
//define('PREFIX', PREFIX_VM);//local

define('TABLE_USER_ADMIN', PREFIX.'user_admin');
define('TABLE_GROUP_USER', PREFIX.'group_user');
define('TABLE_PERMISSION', PREFIX.'permission');
define('TABLE_MENU_SYSTEM',PREFIX.'menu_system');
define('TABLE_ROLE_MENU', PREFIX.'role_menu');
define('TABLE_ROLE',PREFIX.'role');
define('TABLE_DEFINE',PREFIX.'define');
define('TABLE_GROUP_USER_PERMISSION', PREFIX.'group_user_permission');

define('TABLE_QUESTION', PREFIX.'question');

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


