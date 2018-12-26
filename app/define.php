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
define('PREFIX_STRINGEE_USER', 'vm_');
define('PREFIX_VM', 'vm_');
define('PREFIX_V4', 'v4_');
define('PREFIX', '');
//define('PREFIX', PREFIX_VM);//local

define('TABLE_BANNERS', PREFIX.'banners');
define('TABLE_CONTACTS', PREFIX.'contacts');
define('TABLE_VERSION_APP', PREFIX_VM.'version_app');
define('TABLE_CONTRACT_DOCUMENT_ENTITY', PREFIX.'contract_document_entity');
define('TABLE_CONTRACT_DOCUMENT_ENTITY_ATTRIBUTE_VALUE', PREFIX.'contract_document_entity_attribute_value');
define('TABLE_CONTRACT_INFO_DISBURSED_AUTO', PREFIX.'contract_info_disbursed_auto');
define('TABLE_CONTRACTS', PREFIX.'contracts');
define('TABLE_BANK_INFORMATION_BORROWERS', PREFIX.'bank_information_borrowers');
define('TABLE_BILL_PAYMENT', PREFIX.'bill_payment');
define('TABLE_CALL_LOGS', PREFIX.'call_logs');
define('TABLE_CAREERS', PREFIX.'careers');
define('TABLE_CHECK_LENDING_DUPLICATE', PREFIX.'check_lending_duplicate');
define('TABLE_CHECKOUT_LENDERS', PREFIX.'checkout_lenders');
define('TABLE_COMMISSIONS', PREFIX.'commissions');
define('TABLE_DEVICE_APP', PREFIX.'device_app');
define('TABLE_DOCUMENT_ENTITY', PREFIX.'document_entity');
define('TABLE_DOCUMENT_ENTITY_ATTRIBUTE', PREFIX.'document_entity_attribute');
define('TABLE_DOCUMENT_ENTITY_ATTRIBUTE_VALUE', PREFIX.'document_entity_attribute_value');
define('TABLE_DOCUMENT_TYPE', PREFIX.'document_type');
define('TABLE_EXPERTISE', PREFIX.'expertise');
define('TABLE_FACEBOOK', PREFIX.'facebook');
define('TABLE_FACEBOOK_FRIENDS', PREFIX.'facebook_friends');
define('TABLE_FRIENDS_FB360', PREFIX.'friends_fb360');
define('TABLE_HISTORY', PREFIX.'history');
define('TABLE_IMAGES', PREFIX.'images');
define('TABLE_LENDER_APPORTIONS', PREFIX.'lender_apportions');
define('TABLE_LENDER_CAREERS', PREFIX.'lender_careers');
define('TABLE_LENDER_CONTRACTS', PREFIX.'lender_contracts');
define('TABLE_LENDER_DISBURSE_SLIPS', PREFIX.'lender_disburse_slips');
define('TABLE_LENDER_HISTORY', PREFIX.'lender_history');
define('TABLE_LENDER_LOANS', PREFIX.'lender_loans');
define('TABLE_LENDER_NOTIFICATIONS', PREFIX.'lender_notifications');
define('TABLE_LENDERS', PREFIX.'lenders');
define('TABLE_LENDER_TOKEN', PREFIX.'lender_token');
define('TABLE_LITERACY', PREFIX.'literacy');
define('TABLE_LOAN_DOCUMENT', PREFIX.'loan_document');
define('TABLE_LOANER_BACKLISTS', PREFIX.'loaner_backlists');
define('TABLE_LOANERS', PREFIX.'loaners');
define('TABLE_LOANS', PREFIX.'loans');
define('TABLE_LOANS_FREE', PREFIX.'loans_free');
define('TABLE_LOCATIONS', PREFIX.'locations');
define('TABLE_MATRIX', PREFIX.'matrix');
define('TABLE_MESSAGE_SMS', PREFIX.'message_sms');
define('TABLE_MESSAGES', PREFIX.'messages');
define('TABLE_NOTIFICATIONS', PREFIX.'notifications');
define('TABLE_ALEGO_PHONE_CARD', PREFIX_VM.'alego_phone_card');
define('TABLE_GIFT_CHARGE', PREFIX_VM.'gift_charge');
define('TABLE_HISTORY_OPTION_POINTS', PREFIX_VM.'history_option_points');
define('TABLE_MARKETING', PREFIX_VM.'marketing');
define('TABLE_OPTION_POINTS', PREFIX_VM.'option_points');
define('TABLE_POINTS_CHARGE', PREFIX_VM.'point_charge');
define('TABLE_POINTS_CHARGE_HISTORY', PREFIX_VM.'point_charge_history');
define('TABLE_POPUP_LENDER', PREFIX_VM.'popup_lender');
define('TABLE_PROMOTION', PREFIX_VM.'promotion');
define('TABLE_PUSH_NOTIFICATION', PREFIX_VM.'push_notification');
define('TABLE_REMINDER_BORROWER', PREFIX_VM.'reminder_borrower');
define('TABLE_REMINDER_DEPT', PREFIX_VM.'reminder_dept');
define('TABLE_SMS_FORGOT_LOG', PREFIX_VM.'sms_forgot_log');
define('TABLE_TRANSACTION_LOANER', PREFIX_VM.'transaction_loaner');
define('TABLE_NUMBER_CONTRACT_LENDING', PREFIX.'number_contract_lending');
define('TABLE_OPTION_COMMISSION', PREFIX.'option_commission');
define('TABLE_PAYMENT_METHODS', PREFIX.'payment_methods');
define('TABLE_PHONE_COMPANY_FINANCE', PREFIX.'phone_company_finance');
define('TABLE_PREQUALIFICATI', PREFIX.'prequalificati');
define('TABLE_PRODUCT_DOCUMENT_TYPE', PREFIX.'product_document_type');
define('TABLE_PRODUCT', PREFIX.'products');
define('TABLE_PURPOSES', PREFIX.'purposes');
define('TABLE_RECEIPT_COMMISSION', PREFIX.'receipt_commission');
define('TABLE_RECEIPTS', PREFIX.'receipts');
define('TABLE_RELATIONSHIPS', PREFIX.'relationships');
define('TABLE_REPAYMENT_COMMISSION', PREFIX.'repayment_commission');
define('TABLE_REPAYMENT_METHOD_COMMISSTION', PREFIX.'repayment_method_commisstion');
define('TABLE_REPAYMENTS', PREFIX.'repayments');
define('TABLE_TOKENS', PREFIX.'tokens');
define('TABLE_SESSION', PREFIX.'session');
define('TABLE_LOG_CHECK_BANK', PREFIX.'log_check_bank');
define('TABLE_USERS_LOAN', PREFIX.'users_loan');
define('TABLE_USERS_LOAN_LOGS', PREFIX.'users_loan_logs');
define('TABLE_USERS_LOGS_STRINGEE_CALL', PREFIX.'users_logs_stringee_call');
define('TABLE_USERS_NOTI', PREFIX.'users_noti');
define('TABLE_USERS_PERMISSION_STRINGEE_CALL', PREFIX.'users_permission_stringee_call');
define('TABLE_USERS_PHONE_STRINGEE_AGENT', PREFIX.'users_phone_stringee_agent');
define('TABLE_USERS_PHONE_STRINGEE_CALL', PREFIX.'users_phone_stringee_call');

define('TABLE_USER_ADMIN', PREFIX_V4.'user_admin');
define('TABLE_GROUP_USER', PREFIX_V4.'group_user');
define('TABLE_PERMISSION', PREFIX_V4.'permission');
define('TABLE_MENU_SYSTEM',PREFIX_V4.'menu_system');
define('TABLE_ROLE_MENU', PREFIX_V4.'role_menu');
define('TABLE_ROLE',PREFIX_V4.'role');
define('TABLE_GROUP_USER_PERMISSION', PREFIX_V4.'group_user_permission');
define('TABLE_DEFINE',PREFIX_V4.'define');
define('TABLE_BANK_USERS',PREFIX_V4.'bank_users');//ngân hàng người dùng
define('TABLE_COMPANY',PREFIX_V4.'company');
define('TABLE_GUARANTOR',PREFIX_V4.'guarantor');//Nhà đảm bảo
define('TABLE_WALLET_USERS',PREFIX_V4.'wallet_users');//ví người dùng
define('TABLE_BILL_EXPENDITURE',PREFIX_V4.'bill_expenditure');//Phiếu thu phiếu chi
define('TABLE_MAKETING_CAMPAIGN',PREFIX_V4.'maketing_campaign');//Chiến dịch maketing
define('TABLE_MAKETING_COIN_POLICY',PREFIX_V4.'maketing_coin_policy');//Chính sách tích&tiêu xu
define('TABLE_MAKETING_PROGRAM',PREFIX_V4.'maketing_program');//Chương trình maketting
define('TABLE_CONTENT_NOTIFICATIONS',PREFIX_V4.'content_notifications');//noi dung thong bao
define('TABLE_REPAYMENT_HISTORY',PREFIX_V4.'repayment_history');//lịch sử thu hồi nợ của VH
define('TABLE_LENDER_LOAN_INVEST', PREFIX_V4.'lender_loan_invest');
define('TABLE_LOANS_INFO_OTHER', PREFIX_V4.'loans_info_other');
define('TABLE_SPLIT_LOAN_ARCHIVE', PREFIX_V4.'split_loan_archive');//các YCV chưa được chia
define('TABLE_SPLIT_USER', PREFIX_V4.'split_user');//danh sách người VH được chia YCV trong ngày

define('TABLE_CONFIG_PROVIDER', PREFIX_V4.'config_provider');
/**************************************************************************************************************
 * định nghĩa quyền
 **************************************************************************************************************/
//permiss banner
define('PERMISS_BANNER_FULL', 'bannerFull');
define('PERMISS_BANNER_VIEW', 'bannerView');
define('PERMISS_BANNER_CREATE', 'bannerCreate');
define('PERMISS_BANNER_DELETE', 'bannerDelete');

//permiss career
define('PERMISS_CAREER_FULL', 'careerFull');
define('PERMISS_CAREER_VIEW', 'careerView');
define('PERMISS_CAREER_CREATE', 'careerCreate');
define('PERMISS_CAREER_DELETE', 'careerDelete');

//permiss version app
define('PERMISS_VERSION_APP_FULL', 'versionAppFull');
define('PERMISS_VERSION_APP_VIEW', 'versionAppView');
define('PERMISS_VERSION_APP_CREATE', 'versionAppCreate');

//permiss relationships
define('PERMISS_RELATIONSHIPS_FULL', 'relationshipsFull');
define('PERMISS_RELATIONSHIPS_VIEW', 'relationshipsView');
define('PERMISS_RELATIONSHIPS_CREATE', 'relationshipsCreate');
define('PERMISS_RELATIONSHIPS_DELETE', 'relationshipsDelete');

#permision config provider
define('PERMISS_CONFIG_PROVIDER_FULL',   'configProviderFull');
define('PERMISS_CONFIG_PROVIDER_VIEW',   'configProviderView');
define('PERMISS_CONFIG_PROVIDER_CREATE', 'configProviderCreate');
define('PERMISS_CONFIG_PROVIDER_UPDATE', 'configProviderUpdate');
define('PERMISS_CONFIG_PROVIDER_DELETE', 'configProviderDelete');

#permiss lender
define('PERMISS_LENDER_FULL',   'lenderFull');
define('PERMISS_LENDER_LIST',   'lenderList');
define('PERMISS_LENDER_VIEW',   'lenderView');
define('PERMISS_LENDER_CREATE', 'lenderCreate');
define('PERMISS_LENDER_UPDATE', 'lenderUpdate');
define('PERMISS_LENDER_DELETE', 'lenderDelete');

define('PERMISS_LENDER_SETTING_FULL',   'lenderSettingFull');
define('PERMISS_LENDER_SETTING_LIST',   'lenderSettingList');
define('PERMISS_LENDER_SETTING_VIEW',   'lenderSettingView');
define('PERMISS_LENDER_SETTING_CREATE', 'lenderSettingCreate');
define('PERMISS_LENDER_SETTING_UPDATE', 'lenderSettingUpdate');
define('PERMISS_LENDER_SETTING_DELETE', 'lenderSettingDelete');

define('PERMISS_LENDER_LOANS_FULL',   'lenderLoanFull');
define('PERMISS_LENDER_LOANS_LIST',   'lenderLoanList');
define('PERMISS_LENDER_LOANS_VIEW',   'lenderLoanView');
define('PERMISS_LENDER_LOANS_CREATE', 'lenderLoanCreate');
define('PERMISS_LENDER_LOANS_UPDATE', 'lenderLoanUpdate');
define('PERMISS_LENDER_LOANS_DELETE', 'lenderLoanDelete');

define('PERMISS_LENDER_CONTRACTS_FULL',   'lenderContractsFull');
define('PERMISS_LENDER_CONTRACTS_LIST',   'lenderContractsList');
define('PERMISS_LENDER_CONTRACTS_VIEW',   'lenderContractsView');
define('PERMISS_LENDER_CONTRACTS_CREATE', 'lenderContractsCreate');
define('PERMISS_LENDER_CONTRACTS_UPDATE', 'lenderContractsUpdate');
define('PERMISS_LENDER_CONTRACTS_DELETE', 'lenderContractsDelete');
define('PERMISS_LENDER_CONTRACTS_PAY_DEBT', 'lenderContractsPayDebt');//trả nợ nhà đầu tư

define('PERMISS_LENDER_PAYMENTS_FULL',   'lenderPaymentsFull');
define('PERMISS_LENDER_PAYMENTS_LIST',   'lenderPaymentsList');
define('PERMISS_LENDER_PAYMENTS_VIEW',   'lenderPaymentsView');
define('PERMISS_LENDER_PAYMENTS_CREATE', 'lenderPaymentsCreate');
define('PERMISS_LENDER_PAYMENTS_UPDATE', 'lenderPaymentsUpdate');
define('PERMISS_LENDER_PAYMENTS_DELETE', 'lenderPaymentsDelete');

define('PERMISS_REPORT_LENDER_COLLECT_FULL',    'reportLenderCollectFull');
define('PERMISS_REPORT_LENDER_COLLECT_VIEW',    'reportLenderCollectView');
define('PERMISS_REPORT_LENDER_PAYMENT_FULL',    'reportLenderPaymentFull');
define('PERMISS_REPORT_LENDER_PAYMENT_VIEW',    'reportLenderPaymentView');
define('PERMISS_REPORT_LENDER_HAVEPAY_FULL',    'reportLenderHavePayFull');
define('PERMISS_REPORT_LENDER_HAVEPAY_VIEW',    'reportLenderHavePayView');
define('PERMISS_REPORT_LENDER_OVERALL_FULL',    'reportLenderOverallFull');
define('PERMISS_REPORT_LENDER_OVERALL_VIEW',    'reportLenderOverallView');
define('PERMISS_REPORT_LENDER_SCHEDULE_FULL',   'reportLenderScheduleFull');
define('PERMISS_REPORT_LENDER_SCHEDULE_VIEW',   'reportLenderScheduleView');
define('PERMISS_REPORT_LENDER_TYPE_FULL',       'reportLenderTypeFull');
define('PERMISS_REPORT_LENDER_TYPE_VIEW',       'reportLenderTypeView');

define('PERMISS_REPORT_LOANER_CONTRACT_FULL',       'reportLoanerContractFull');
define('PERMISS_REPORT_LOANER_CONTRACT_VIEW',       'reportLoanerContractView');
define('PERMISS_REPORT_LOANER_DISBURSEMENT_FULL',   'reportLoanerDisbursementFull');
define('PERMISS_REPORT_LOANER_DISBURSEMENT_VIEW',   'reportLoanerDisbursementView');
define('PERMISS_REPORT_LOANER_RECOVERY_FULL',       'reportLoanerRecoveryFull');
define('PERMISS_REPORT_LOANER_RECOVERY_VIEW',       'reportLoanerRecoveryView');
define('PERMISS_REPORT_LOANER_TOTAL_DEBT_FULL',     'reportLoanerTotalDebtFull');
define('PERMISS_REPORT_LOANER_TOTAL_DEBT_VIEW',     'reportLoanerTotalDebtView');
define('PERMISS_REPORT_LOANER_FIRST_CONTRACT_FULL', 'reportLoanerFirstContractFull');
define('PERMISS_REPORT_LOANER_FIRST_CONTRACT_VIEW', 'reportLoanerFirstContractView');
define('PERMISS_REPORT_LOANER_LOAN_FULL',           'reportLoanerLoanFull');
define('PERMISS_REPORT_LOANER_LOAN_VIEW',           'reportLoanerLoanView');
define('PERMISS_REPORT_LOANER_GROUP_DEBT_FULL',     'reportLoanerGroupDebtFull');
define('PERMISS_REPORT_LOANER_GROUP_DEBT_VIEW',     'reportLoanerGroupDebtView');
define('PERMISS_REPORT_LOANER_GROUP_MTD_FULL',      'reportLoanerGroupMtdFull');
define('PERMISS_REPORT_LOANER_GROUP_MTD_VIEW',      'reportLoanerGroupMtdView');
define('PERMISS_REPORT_LOANER_POINT_OVERALL_FULL',  'reportLoanerPointOverallFull');
define('PERMISS_REPORT_LOANER_POINT_OVERALL_VIEW',  'reportLoanerPointOverallView');
define('PERMISS_REPORT_LOANER_POINT_GROUP_FULL',    'reportLoanerPointGroupFull');
define('PERMISS_REPORT_LOANER_POINT_GROUP_VIEW',    'reportLoanerPointGroupView');
define('PERMISS_REPORT_LOANER_POINT_USED_FULL',     'reportLoanerPointUsedFull');
define('PERMISS_REPORT_LOANER_POINT_USED_VIEW',     'reportLoanerPointUsedView');
define('PERMISS_REPORT_LOANER_ALEGO_CARD_FULL',     'reportLoanerAlegoCardFull');
define('PERMISS_REPORT_LOANER_ALEGO_CARD_VIEW',     'reportLoanerAlegoCardView');
define('PERMISS_REPORT_LOANER_RECOVERY_DEBT_FULL',  'reportLoanerRecoveryDebtFull');
define('PERMISS_REPORT_LOANER_RECOVERY_DEBT_VIEW',  'reportLoanerRecoveryDebtView');
define('PERMISS_REPORT_LOANER_TOTAL_LOAN_FULL',     'reportLoanerTotalLoanFull');
define('PERMISS_REPORT_LOANER_TOTAL_LOAN_VIEW',     'reportLoanerTotalLoanView');
define('PERMISS_REPORT_LOANER_GIFT_CHARGE_FULL',    'reportLoanerGiftChargeFull');
define('PERMISS_REPORT_LOANER_GIFT_CHARGE_VIEW',    'reportLoanerGiftChargeView');
define('PERMISS_REPORT_LOANER_DETAIL_DEBT_FULL',    'reportLoanerDetailDebtFull');
define('PERMISS_REPORT_LOANER_DETAIL_DEBT_VIEW',    'reportLoanerDetailDebtView');
define('PERMISS_REPORT_LOANER_TIME_GROUP_DEBT_FULL',    'reportLoanerDetailDebtFull');
define('PERMISS_REPORT_LOANER_TIME_GROUP_DEBT_VIEW',    'reportLoanerDetailDebtView');

define('PERMISS_REPORT_MARKETING_CONTRACT_FULL',    'reportMarketingContractFull');
define('PERMISS_REPORT_MARKETING_CONTRACT_VIEW',    'reportMarketingContractView');
define('PERMISS_REPORT_MARKETING_PROMOTION_FULL',    'reportMarketingPromotionFull');
define('PERMISS_REPORT_MARKETING_PROMOTION_VIEW',    'reportMarketingPromotionView');

define('PERMISS_REPORT_VAYMUON_LOAN_FULL',          'reportVayMuonLoanFull');
define('PERMISS_REPORT_VAYMUON_LOAN_VIEW',          'reportVayMuonLoanView');
define('PERMISS_REPORT_VAYMUON_CONTRACT_FULL',      'reportVayMuonContractFull');
define('PERMISS_REPORT_VAYMUON_CONTRACT_VIEW',      'reportVayMuonContractView');
define('PERMISS_REPORT_VAYMUON_OVERALL_FULL',       'reportVayMuonOverallFull');
define('PERMISS_REPORT_VAYMUON_OVERALL_VIEW',       'reportVayMuonOverallView');
define('PERMISS_REPORT_VAYMUON_RECEIPT_FULL',       'reportVayMuonReceiptFull');
define('PERMISS_REPORT_VAYMUON_RECEIPT_VIEW',       'reportVayMuonReceiptView');
define('PERMISS_REPORT_VAYMUON_FEE_RATE_FULL',      'reportVayMuonFeeRateFull');
define('PERMISS_REPORT_VAYMUON_FEE_RATE_VIEW',      'reportVayMuonFeeRateView');
define('PERMISS_REPORT_VAYMUON_REMIND_FULL',        'reportVayMuonRemindFull');
define('PERMISS_REPORT_VAYMUON_REMIND_VIEW',        'reportVayMuonRemindView');
define('PERMISS_REPORT_VAYMUON_CALL_LOG_FULL',      'reportVayMuonCallLogFull');
define('PERMISS_REPORT_VAYMUON_CALL_LOG_VIEW',      'reportVayMuonCallLogView');
define('PERMISS_REPORT_VAYMUON_LIST_GUEST_FULL',    'reportVayMuonListGuestFull');
define('PERMISS_REPORT_VAYMUON_LIST_GUEST_VIEW',    'reportVayMuonListGuestView');

//permiss LOANS
define('PERMISS_LOANS_FULL', 'loansFull');
define('PERMISS_LOANS_VIEW', 'loansView');
define('PERMISS_LOANS_CREATE', 'loansCreate');
define('PERMISS_LOANS_DELETE', 'loansDelete');
define('PERMISS_LOANS_VIEW_MINE', 'loansViewMine');
//nhận YCV thủ công
define('PERMISS_LOANS_WAIT_FULL', 'loansWaitFull');
define('PERMISS_LOANS_WAIT_VIEW', 'loansWaitView');
define('PERMISS_LOANS_WAIT_CREATE', 'loansWaitCreate');

define('PERMISS_LOANS_NHAN_YCV', 'loansNhanYcv');
define('PERMISS_LOANS_YCV_VH1', 'loansYcvVh1');
define('PERMISS_LOANS_YCV_VH2', 'loansYcvVh2');


//permiss thẩm định yêu cầu vay
define('PERMISS_LOAN_EXPERTISE_FULL', 'loanExpertiseFull');
define('PERMISS_LOAN_EXPERTISE_VIEW', 'loanExpertiseView');
define('PERMISS_LOAN_EXPERTISE_CREATE', 'loanExpertiseCreate');

//permiss Nhóm nợ
define('PERMISS_DEFINE_DEBT_FULL', 'defineDebtFull');
define('PERMISS_DEFINE_DEBT_VIEW', 'defineDebtView');
define('PERMISS_DEFINE_DEBT_CREATE', 'defineDebtCreate');
define('PERMISS_DEFINE_DEBT_DELETE', 'defineDebtDelete');

//permiss Chính sách áp dụng maketting
define('PERMISS_DEFINE_POLICY_APPLIES_FULL', 'definePolicyAppliesFull');
define('PERMISS_DEFINE_POLICY_APPLIES_VIEW', 'definePolicyAppliesView');
define('PERMISS_DEFINE_POLICY_APPLIES_CREATE', 'definePolicyAppliesCreate');
define('PERMISS_DEFINE_POLICY_APPLIES_DELETE', 'definePolicyAppliesDelete');

//permiss thu NỢ
define('PERMISS_DEFINE_DEBT_RECOVERY_FULL', 'defineDebtRecoveryFull');
define('PERMISS_DEFINE_DEBT_RECOVERY_VIEW', 'defineDebtRecoveryView');
define('PERMISS_DEFINE_DEBT_RECOVERY_CREATE', 'defineDebtRecoveryCreate');
define('PERMISS_DEFINE_DEBT_RECOVERY_DELETE', 'defineDebtRecoveryDelete');

//permiss product
define('PERMISS_PRODUCT_FULL', 'productFull');
define('PERMISS_PRODUCT_VIEW', 'productView');
define('PERMISS_PRODUCT_CREATE', 'productCreate');
define('PERMISS_PRODUCT_DELETE', 'productDelete');
define('PERMISS_PRODUCT_ACTIVE', 'productActive');
define('PERMISS_PRODUCT_DEACTIVE', 'productDeactive');

//Permiss LOANER
define('PERMISS_LOANER_FULL', 'loanerFull');
define('PERMISS_LOANER_VIEW', 'loanerView');
define('PERMISS_LOANER_CREATE', 'loanerCreate');
define('PERMISS_LOANER_DELETE', 'loanerDelete');
define('PERMISS_LOANER_AJAX_UPDATE_FIELD', 'loanerAjaxUpdateField');
define('PERMISS_LOANER_AJAX_GET_LOANER_DOCUMENT', 'loanerAjaxGetLoanerDocument');
define('PERMISS_LOANER_AJAX_GET_LOANER_PHONE_BOOK', 'loanerAjaxGetLoanerPhoneBook');
define('PERMISS_LOANER_AJAX_GET_LOANER_REPAYMENT', 'loanerAjaxGetLoanerRepayment');
define('PERMISS_LOANER_AJAX_GET_LOANER_WAY', 'loanerAjaxGetLoanerWay');
define('PERMISS_LOANER_AJAX_GET_CALL_LOG', 'loanerAjaxGetLoanerCallLog');
define('PERMISS_LOANER_AJAX_GET_LOANER_HISTORY_SETTING', 'loanerAjaxGetLoanerHistorySetting');

//Permiss LoanContracts
define('PERMISS_LOAN_CONTRACTS_FULL', 'loanContractsFull');
define('PERMISS_LOAN_CONTRACTS_VIEW', 'loanContractsView');
define('PERMISS_LOAN_CONTRACTS_DETAIL', 'loanContractsDetail');
define('PERMISS_AJAX_GET_LOAN_CONTRACTS_DOCUMENT', 'loanContractsDocument');
define('PERMISS_AJAX_GET_LOAN_CONTRACTS_LENDER', 'loanContractsLender');
define('PERMISS_AJAX_GET_LOAN_CONTRACTS_NOTIFY', 'loanContractsNotify');
define('PERMISS_AJAX_GET_LOAN_CONTRACTS_RECEIPTS', 'loanContractsReceipts');
//check Vimo
define('PERMISS_VIMO_FULL', 'loanContractsVimoFull');
define('PERMISS_VIMO_CHECK_PAY_TRANSACTION', 'vimoCheckPayTransaction');
define('PERMISS_VIMO_CHECK_TRANSACTION_DISBURSE_AUTO', 'vimoCheckTransactionDisburseAuto');
define('PERMISS_VIMO_UPDATE_TRANSACTION_DISBURSE_AUTO', 'vimoUpdateTransactionDisburseAuto');
define('PERMISS_VIMO_UPDATE_WAITING_DISBURSED_FROM_ERROR_DISBURSED', 'vimoUpdateWaitingDisbursedFromErrorDisbursed');

//Permiss DEFINE
define('PERMISS_DEFINE_FULL', 'defineFull');
define('PERMISS_DEFINE_VIEW', 'defineView');
define('PERMISS_DEFINE_CREATE', 'defineCreate');
define('PERMISS_DEFINE_DELETE', 'defineDelete');

//permiss career
define('PERMISS_LITERACY_FULL', 'literacyFull');
define('PERMISS_LITERACY_VIEW', 'literacyView');
define('PERMISS_LITERACY_CREATE', 'literacyCreate');
define('PERMISS_LITERACY_DELETE', 'literacyDelete');

//permiss purpose
define('PERMISS_PURPOSE_FULL', 'purposeFull');
define('PERMISS_PURPOSE_VIEW', 'purposeView');
define('PERMISS_PURPOSE_CREATE', 'purposeCreate');
define('PERMISS_PURPOSE_DELETE', 'purposeDelete');

//permiss purpose
define('PERMISS_NOTIFICATION_FULL', 'notificationFull');
define('PERMISS_NOTIFICATION_VIEW', 'notificationView');
define('PERMISS_NOTIFICATION_CREATE', 'notificationCreate');
define('PERMISS_NOTIFICATION_DELETE', 'notificationDelete');

//permiss document_entity_attribute
define('PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_FULL', 'documentEntityAttributeFull');
define('PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_VIEW', 'documentEntityAttributeView');
define('PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_CREATE', 'documentEntityAttributeCreate');
define('PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_DELETE', 'documentEntityAttributeDelete');

//permiss document_entity_attribute
define('PERMISS_DOCUMENT_TYPE_FULL', 'documentTypeFull');
define('PERMISS_DOCUMENT_TYPE_VIEW', 'documentTypeView');
define('PERMISS_DOCUMENT_TYPE_CREATE', 'documentTypeCreate');
define('PERMISS_DOCUMENT_TYPE_DELETE', 'documentTypeDelete');

//permiss option commission
define('PERMISS_OPTION_COMMISSION_FULL', 'optionCommissionFull');
define('PERMISS_OPTION_COMMISSION_VIEW', 'optionCommissionView');
define('PERMISS_OPTION_COMMISSION_CREATE', 'optionCommissionCreate');
define('PERMISS_OPTION_COMMISSION_DELETE', 'optionCommissionDelete');

//option point
define('PERMISS_OPTION_POINT_FULL', 'optionPointFull');
define('PERMISS_OPTION_POINT_VIEW', 'optionPointView');
define('PERMISS_OPTION_POINT_CREATE', 'optionPointCreate');
define('PERMISS_OPTION_POINT_DELETE', 'optionPointDelete');

//user phone stringee call
define('PERMISS_USER_PHONE_STRINGEE_CALL_FULL', 'userPhoneStringeeCallFull');
define('PERMISS_USER_PHONE_STRINGEE_CALL_VIEW', 'userPhoneStringeeCallView');
define('PERMISS_USER_PHONE_STRINGEE_CALL_CREATE', 'userPhoneStringeeCallCreate');
define('PERMISS_USER_PHONE_STRINGEE_CALL_DELETE', 'userPhoneStringeeCallDelete');

//permiss career
define('PERMISS_LENDER_CAREER_FULL', 'lenderCareerFull');
define('PERMISS_LENDER_CAREER_VIEW', 'lenderCareerView');
define('PERMISS_LENDER_CAREER_CREATE', 'lenderCareerCreate');
define('PERMISS_LENDER_CAREER_DELETE', 'lenderCareerDelete');

// Permission Company
define('PERMISS_COMPANY_FULL', 'companyFull');
define('PERMISS_COMPANY_VIEW', 'companyView');
define('PERMISS_COMPANY_CREATE', 'companyCreate');
define('PERMISS_COMPANY_DELETE', 'companyDelete');
define('PERMISS_COMPANY_WALLET_USER_FULL', 'walletUserFull');
define('PERMISS_COMPANY_BANK_USER_FULL', 'bankUserFull');

// Permission Company bill
define('PERMISS_COMPANY_BILL_EXPENDITURE_FULL', 'companyBillExpenditureFull');
define('PERMISS_COMPANY_BILL_EXPENDITURE_VIEW', 'companyBillExpenditureView');
define('PERMISS_COMPANY_BILL_EXPENDITURE_CREATE', 'companyBillExpenditureCreate');

//transaction loaner
define('PERMISS_TRANSACTION_LOANER_FULL', 'transactionLoanerFull');
define('PERMISS_TRANSACTION_LOANER_VIEW', 'transactionLoanerView');
define('PERMISS_TRANSACTION_LOANER_CREATE', 'transactionLoanerCreate');
define('PERMISS_TRANSACTION_LOANER_CANCEL', 'transactionLoanerCancel');
define('PERMISS_TRANSACTION_LOANER_DS', 'transactionLoanerDS');

// Permisson Users Loan Log
define('PERMISS_USER_LOAN_LOG_FULL', 'userLoanLogFull');

// Permission SMS Log
define('PERMISS_SMS_LOG_FULL', 'smsLogFull');

// Permission Guarantor
define('PERMISS_GUARANTOR_FULL', 'guarantorFull');
define('PERMISS_GUARANTOR_VIEW', 'guarantorView');
define('PERMISS_GUARANTOR_CREATE', 'guarantorCreate');
define('PERMISS_GUARANTOR_DELETE', 'guarantorDelete');

// Permission Guarantor bill
define('PERMISS_GUARANTOR_BILL_EXPENDITURE_FULL', 'guarantorBillExpenditureFull');
define('PERMISS_GUARANTOR_BILL_EXPENDITURE_VIEW', 'guarantorBillExpenditureView');
define('PERMISS_GUARANTOR_BILL_EXPENDITURE_CREATE', 'guarantorBillExpenditureCreate');

//permiss lender popup
define('PERMISS_LENDER_POPUP_FULL', 'lenderPopupFull');
define('PERMISS_LENDER_POPUP_VIEW', 'lenderPopupView');
define('PERMISS_LENDER_POPUP_CREATE', 'lenderPopupCreate');
define('PERMISS_LENDER_POPUP_UPDATE', 'lenderPopupUpdate');
define('PERMISS_LENDER_POPUP_DELETE', 'lenderPopupDelete');

//transaction loaner
define('PERMISS_REPAYMENT_FULL', 'repaymentFull');
define('PERMISS_REPAYMENT_VIEW', 'repaymentView');
define('PERMISS_REPAYMENT_CREATE', 'repaymentCreate');
define('PERMISS_REPAYMENT_CANCEL', 'transactionLoanerCancel');
define('PERMISS_ADD_REPAYMENT_HISTORY', 'addRepaymentHistory');
define('PERMISS_AJAX_GET_RECEIPT', 'ajaxGetReceipt');
define('PERMISS_AJAX_RECEIVE_REPAYMENT', 'ajaxReceiveRepayment');
define('PERMISS_AJAX_LOAD_PHI_PHAT', 'ajaxLoadPhiPhat');
define('PERMISS_AJAX_RECEIVE_LIST_REPAYMENT', 'ajaxReceiveListRepayment');

// Permission Content Notification
define('PERMISS_CONTENT_NOTIFICATION_FULL', 'contentNotificationFull');
define('PERMISS_CONTENT_NOTIFICATION_VIEW', 'contentNotificationView');
define('PERMISS_CONTENT_NOTIFICATION_CREATE', 'contentNotificationCreate');
define('PERMISS_CONTENT_NOTIFICATION_DELETE', 'contentNotificationDelete');
define('PERMISS_CONTENT_NOTIFICATION_LOCK', 'contentNotificationLock');
define('PERMISS_CONTENT_NOTIFICATION_ACTIVE', 'contentNotificationActive');

// Permission commission
define('PERMISS_COMMISSION_FULL', 'commissionFull');
define('PERMISS_COMMISSION_VIEW', 'commissionView');
define('PERMISS_COMMISSION_CREATE', 'commissionCreate');
define('PERMISS_COMMISSION_DELETE', 'commissionDelete');

// Permission bank information borrower
define('PERMISS_BANK_INFORMATION_BORROWER_FULL', 'bankInformationBorrowerFull');
define('PERMISS_BANK_INFORMATION_BORROWER_VIEW', 'bankInformationBorrowerView');
define('PERMISS_BANK_INFORMATION_BORROWER_CREATE', 'bankInformationBorrowerCreate');
define('PERMISS_BANK_INFORMATION_BORROWER_DELETE', 'bankInformationBorrowerDelete');


// Permission repayment commission
define('PERMISS_REPAYMENT_COMMISSION_FULL', 'repaymentCommissionFull');
define('PERMISS_REPAYMENT_COMMISSION_VIEW', 'repaymentCommissionView');
define('PERMISS_REPAYMENT_COMMISSION_CREATE', 'repaymentCommissionCreate');
define('PERMISS_REPAYMENT_COMMISSION_DELETE', 'repaymentCommissionDelete');

// Permission Marketing coin policy
define('PERMISS_MARKETING_COIN_POLICY_FULL', 'marketingCoinPolicyFull');
define('PERMISS_MARKETING_COIN_POLICY_VIEW', 'marketingCoinPolicyView');
define('PERMISS_MARKETING_COIN_POLICY_CREATE', 'marketingCoinPolicyCreate');
define('PERMISS_MARKETING_COIN_POLICY_DELETE', 'marketingCoinPolicyDelete');

// Permission receipt commission
define('PERMISS_RECEIPT_COMMISSION_FULL', 'receiptCommissionFull');
define('PERMISS_RECEIPT_COMMISSION_VIEW', 'receiptCommissionView');
define('PERMISS_RECEIPT_COMMISSION_CREATE', 'receiptCommissionCreate');
define('PERMISS_RECEIPT_COMMISSION_DELETE', 'receiptCommissionDelete');

//permiss reminder debt
define('PERMISS_REMINDER_DEBT_FULL', 'reminderDebtFull');
define('PERMISS_REMINDER_DEBT_VIEW', 'reminderDebtView');
define('PERMISS_REMINDER_DEBT_CREATE', 'reminderDebtCreate');
define('PERMISS_REMINDER_DEBT_DELETE', 'reminderDebtDelete');
define('PERMISS_REMINDER_DEBT_DEACTIVE', 'reminderDebtDeactive');
define('PERMISS_REMINDER_DEBT_ACTIVE', 'reminderDebtActive');

//permiss marketing campaign
define('PERMISS_MARKETING_CAMPAIGN_FULL', 'marketingCampaignFull');
define('PERMISS_MARKETING_CAMPAIGN_VIEW', 'marketingCampaignView');
define('PERMISS_MARKETING_CAMPAIGN_CREATE', 'marketingCampaignCreate');
define('PERMISS_MARKETING_CAMPAIGN_ACTIVE', 'marketingCampaignActive');
define('PERMISS_MARKETING_CAMPAIGN_LOCK', 'marketingCampaignLock');
define('PERMISS_MARKETING_CAMPAIGN_CANCEL', 'marketingCampaignCancel');

//permiss marketing campaign
define('PERMISS_MARKETING_PROGRAM_FULL', 'marketingProgramFull');
define('PERMISS_MARKETING_PROGRAM_VIEW', 'marketingProgramView');
define('PERMISS_MARKETING_PROGRAM_CREATE', 'marketingProgramCreate');
define('PERMISS_MARKETING_PROGRAM_ACTIVE', 'marketingProgramActive');
define('PERMISS_MARKETING_PROGRAM_LOCK', 'marketingProgramLock');
define('PERMISS_MARKETING_PROGRAM_CANCEL', 'marketingProgramCancel');

//Permission log call
define('PERMISS_LOG_CALL_FULL', 'logCallFull');
define('PERMISS_LOG_CALL_VIEW', 'logCallView');
define('PERMISS_LOG_CALL_VIEW_RECORD', 'logCallViewRecord');

//Permission stringee group
define('PERMISS_STRINGEE_GET_GROUP_LIST_FULL', 'getGroupListFull');
define('PERMISS_STRINGEE_GET_GROUP_LIST_VIEW', 'getGroupListView');
define('PERMISS_STRINGEE_GET_GROUP_CREATE', 'getGroupListCreate');
define('PERMISS_STRINGEE_GET_GROUP_DELETE', 'getGroupListDelete');

define('PERMISS_STRINGEE_CALL_ANSWER_FULL', 'getStringeCallAnswerFull');
define('PERMISS_STRINGEE_CALL_ANSWER_VIEW', 'getStringeCallAnswerView');
define('PERMISS_STRINGEE_CALL_ANSWER_CREATE', 'getStringeCallAnswerCreate');