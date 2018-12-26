<?php
/**
 * Created by JetBrains PhpStorm.
 * User: QuynhTM
 */

namespace App\Library\AdminFunction;

class ArrayPermission
{
    public static $arrNewPermiss = array(
        1 => array(
            'group_permiss' => 'Quản trị site',
            'infor' => array(
                1 => array('code' => 'root', 'name' => 'Quản trị site '),
            ),
        ),
        2 => array(
            'group_permiss' => 'Tech code',
            'infor' => array(
                1 => array('code' => 'is_tech', 'name' => 'Tech code'),
            ),
        ),
        3 => array(
            'group_permiss' => 'Tài khoản Admin',
            'infor' => array(
                1 => array('code' => 'user_view', 'name' => 'Xem danh sách user'),
                2 => array('code' => 'user_create', 'name' => 'Tạo user'),
                3 => array('code' => 'user_edit', 'name' => 'Sửa user'),
                4 => array('code' => 'user_change_pass', 'name' => 'Đổi pass user'),
                5 => array('code' => 'user_remove', 'name' => 'Xóa user'),
                6 => array('code' => 'user_full_employee', 'name' => 'Full QL NV'),
            ),
        ),
        4 => array(
            'group_permiss' => 'Nhóm quyền',
            'infor' => array(
                1 => array('code' => 'group_user_view', 'name' => 'Xem nhóm quyền'),
                2 => array('code' => 'group_user_create', 'name' => 'Tạo nhóm quyền'),
                3 => array('code' => 'group_user_edit', 'name' => 'Sửa nhóm quyền'),
            ),
        ),
        5 => array(
            'group_permiss' => 'Tạo quyền',
            'infor' => array(
                1 => array('code' => 'permission_full', 'name' => 'Full tạo quyền'),
                2 => array('code' => 'permission_create', 'name' => 'Tạo quyền'),
                3 => array('code' => 'permission_edit', 'name' => 'Sửa tạo quyền'),
            ),
        ),
        6 => array(
            'group_permiss' => 'Menu admin',
            'infor' => array(
                1 => array('code' => 'menu_full', 'name' => 'Full menu'),
                2 => array('code' => 'menu_view', 'name' => 'View menu'),
                3 => array('code' => 'menu_create', 'name' => 'Tạo menu'),
                4 => array('code' => 'menu_delete', 'name' => 'Xóa menu'),
            ),
        ),
        7 => array(
            'group_permiss' => 'Quyền Role',
            'infor' => array(
                1 => array('code' => 'role_full', 'name' => 'Full role'),
                2 => array('code' => 'role_view', 'name' => 'View role'),
                3 => array('code' => 'role_create', 'name' => 'Tạo role'),
                4 => array('code' => 'role_delete', 'name' => 'Xóa role'),
            ),
        ),
        8 => array(
            'group_permiss' => 'Phân quyền role',
            'infor' => array(
                2 => array('code' => 'role_permission_view', 'name' => 'View quyền role'),
                3 => array('code' => 'role_permission_create', 'name' => 'Tạo quyền role'),
                4 => array('code' => 'role_permission_edit', 'name' => 'Sửa quyền role'),
            ),
        ),
        9 => array(
            'group_permiss' => 'Quyền Banner',
            'infor' => array(
                1 => array('code' => PERMISS_BANNER_FULL, 'name' => 'Full banner'),
                2 => array('code' => PERMISS_BANNER_VIEW, 'name' => 'View banner'),
                3 => array('code' => PERMISS_BANNER_CREATE, 'name' => 'Tạo banner'),
                4 => array('code' => PERMISS_BANNER_DELETE, 'name' => 'Xóa banner'),
            ),
        ),
        48 => array(
            'group_permiss' => 'Quyền Nội dung notification',
            'infor' => array(
                1 => array('code' => PERMISS_CONTENT_NOTIFICATION_FULL, 'name' => 'Full contentNotification'),
                2 => array('code' => PERMISS_CONTENT_NOTIFICATION_VIEW, 'name' => 'View contentNotification'),
                3 => array('code' => PERMISS_CONTENT_NOTIFICATION_CREATE, 'name' => 'Tạo contentNotification'),
                4 => array('code' => PERMISS_CONTENT_NOTIFICATION_DELETE, 'name' => 'Xóa contentNotification'),
                5 => array('code' => PERMISS_CONTENT_NOTIFICATION_LOCK, 'name' => 'Khóa contentNotification'),
                6 => array('code' => PERMISS_CONTENT_NOTIFICATION_ACTIVE, 'name' => 'Active contentNotification'),
            ),
        ),
        50 => array(
            'group_permiss' => 'Quyền Thông tin ngân hàng NV',
            'infor' => array(
                1 => array('code' => PERMISS_BANK_INFORMATION_BORROWER_FULL, 'name' => 'Full bankBorrower'),
                2 => array('code' => PERMISS_BANK_INFORMATION_BORROWER_VIEW, 'name' => 'View bankBorrower'),
                3 => array('code' => PERMISS_BANK_INFORMATION_BORROWER_CREATE, 'name' => 'Tạo bankBorrower'),
                4 => array('code' => PERMISS_BANK_INFORMATION_BORROWER_DELETE, 'name' => 'Xóa bankBorrower'),
            ),
        ),
        11 => array(
            'group_permiss' => 'Quyền quan hệ',
            'infor' => array(
                1 => array('code' => PERMISS_RELATIONSHIPS_FULL, 'name' => 'Full relationships'),
                2 => array('code' => PERMISS_RELATIONSHIPS_VIEW, 'name' => 'View relationships'),
                3 => array('code' => PERMISS_RELATIONSHIPS_CREATE, 'name' => 'Tạo relationships'),
                4 => array('code' => PERMISS_RELATIONSHIPS_DELETE, 'name' => 'Xóa relationships'),
            ),
        ),

        29 => array(
            'group_permiss' => 'Quyền Define hệ thống',
            'infor' => array(
                1 => array('code' => PERMISS_DEFINE_FULL, 'name' => 'Full Define'),
                2 => array('code' => PERMISS_DEFINE_VIEW, 'name' => 'View Define'),
                3 => array('code' => PERMISS_DEFINE_CREATE, 'name' => 'Tạo Define'),
                4 => array('code' => PERMISS_DEFINE_DELETE, 'name' => 'Xóa Define'),
            ),
        ),
        30 => array(
            'group_permiss' => 'Quyền trình độ học vấn',
            'infor' => array(
                1 => array('code' => PERMISS_LITERACY_FULL, 'name' => 'Full học vấn'),
                2 => array('code' => PERMISS_LITERACY_VIEW, 'name' => 'View học vấn'),
                3 => array('code' => PERMISS_LITERACY_CREATE, 'name' => 'Tạo học vấn'),
                4 => array('code' => PERMISS_LITERACY_DELETE, 'name' => 'Xóa học vấn'),
            ),
        ),
        31 => array(
            'group_permiss' => 'Quyền mục đích vay',
            'infor' => array(
                1 => array('code' => PERMISS_PURPOSE_FULL, 'name' => 'Full mục đích vay'),
                2 => array('code' => PERMISS_PURPOSE_VIEW, 'name' => 'View mục đích vay'),
                3 => array('code' => PERMISS_PURPOSE_CREATE, 'name' => 'Tạo mục đích vay'),
                4 => array('code' => PERMISS_PURPOSE_DELETE, 'name' => 'Xóa mục đích vay'),
            ),
        ),
        32 => array(
            'group_permiss' => 'Quyền notification',
            'infor' => array(
                1 => array('code' => PERMISS_NOTIFICATION_FULL, 'name' => 'Full notification'),
                2 => array('code' => PERMISS_NOTIFICATION_VIEW, 'name' => 'View notification'),
                3 => array('code' => PERMISS_NOTIFICATION_CREATE, 'name' => 'Tạo notification'),
                4 => array('code' => PERMISS_NOTIFICATION_DELETE, 'name' => 'Xóa notification'),
            ),
        ),
        33 => array(
            'group_permiss' => 'Quyền documentEntityAttribute',
            'infor' => array(
                1 => array('code' => PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_FULL, 'name' => 'Full documentEntityAttribute'),
                2 => array('code' => PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_VIEW, 'name' => 'View documentEntityAttribute'),
                3 => array('code' => PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_CREATE, 'name' => 'Tạo documentEntityAttribute'),
                4 => array('code' => PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_DELETE, 'name' => 'Xóa documentEntityAttribute'),
            ),
        ),
        34 => array(
            'group_permiss' => 'Quyền documentType',
            'infor' => array(
                1 => array('code' => PERMISS_DOCUMENT_TYPE_FULL, 'name' => 'Full documentType'),
                2 => array('code' => PERMISS_DOCUMENT_TYPE_VIEW, 'name' => 'View documentType'),
                3 => array('code' => PERMISS_DOCUMENT_TYPE_CREATE, 'name' => 'Tạo documentType'),
                4 => array('code' => PERMISS_DOCUMENT_TYPE_DELETE, 'name' => 'Xóa documentType'),
            ),
        ),

        37 => array(
            'group_permiss' => 'Quyền User Phone stringee',
            'infor' => array(
                1 => array('code' => PERMISS_USER_PHONE_STRINGEE_CALL_FULL, 'name' => 'Full userPhoneStringeeCall'),
                2 => array('code' => PERMISS_USER_PHONE_STRINGEE_CALL_VIEW, 'name' => 'View userPhoneStringeeCall'),
                3 => array('code' => PERMISS_USER_PHONE_STRINGEE_CALL_CREATE, 'name' => 'Tạo userPhoneStringeeCall'),
                4 => array('code' => PERMISS_USER_PHONE_STRINGEE_CALL_DELETE, 'name' => 'Xóa userPhoneStringeeCall'),
            ),
        ),
        38 => array(
            'group_permiss' => 'Quyền User Phone stringee',
            'infor' => array(
                1 => array('code' => PERMISS_USER_PHONE_STRINGEE_CALL_FULL, 'name' => 'Full userPhoneStringeeCall'),
                2 => array('code' => PERMISS_USER_PHONE_STRINGEE_CALL_VIEW, 'name' => 'View userPhoneStringeeCall'),
                3 => array('code' => PERMISS_USER_PHONE_STRINGEE_CALL_CREATE, 'name' => 'Tạo userPhoneStringeeCall'),
                4 => array('code' => PERMISS_USER_PHONE_STRINGEE_CALL_DELETE, 'name' => 'Xóa userPhoneStringeeCall'),
            ),
        ),
        43 => array(
            'group_permiss' => 'Quyền Log System',
            'infor' => array(
                1 => array('code' => PERMISS_USER_LOAN_LOG_FULL, 'name' => 'Full userLoanLog'),
                2 => array('code' => PERMISS_SMS_LOG_FULL, 'name' => 'Full smsLogFull'),
                3 => array('code' => PERMISS_LOG_CALL_FULL, 'name' => 'Full logCallFull'),
                4 => array('code' => PERMISS_LOG_CALL_VIEW, 'name' => 'Full logCallView'),
                5 => array('code' => PERMISS_LOG_CALL_VIEW_RECORD, 'name' => 'Dowloand file record'),
            ),
        ),
        12 => array(
            'group_permiss' => 'Quyền LENDER',
            'infor' => array(
                1 => array('code' => PERMISS_LENDER_FULL, 'name' => 'Full lender'),
                2 => array('code' => PERMISS_LENDER_LIST, 'name' => 'View lender'),
                3 => array('code' => PERMISS_LENDER_VIEW, 'name' => 'Detail lender'),
                5 => array('code' => PERMISS_LENDER_CREATE, 'name' => 'Tạo lender'),
                4 => array('code' => PERMISS_LENDER_DELETE, 'name' => 'Xóa lender'),
            ),
        ),
        39 => array(
            'group_permiss' => 'Quyền Nghề nghiệp Lender',
            'infor' => array(
                1 => array('code' => PERMISS_LENDER_CAREER_FULL, 'name' => 'Full lenderCareer'),
                2 => array('code' => PERMISS_LENDER_CAREER_VIEW, 'name' => 'View lenderCareer'),
                3 => array('code' => PERMISS_LENDER_CAREER_CREATE, 'name' => 'Tạo lenderCareer'),
                4 => array('code' => PERMISS_LENDER_CAREER_DELETE, 'name' => 'Xóa lenderCareer'),
            ),
        ),
        13 => array(
            'group_permiss' => 'Quyền LENDER SETTING',
            'infor' => array(
                1 => array('code' => PERMISS_LENDER_SETTING_FULL, 'name' => 'Full lenderSetting'),
                2 => array('code' => PERMISS_LENDER_SETTING_LIST, 'name' => 'View lenderSetting'),
                3 => array('code' => PERMISS_LENDER_SETTING_VIEW, 'name' => 'Detail lenderSetting'),
                5 => array('code' => PERMISS_LENDER_SETTING_CREATE, 'name' => 'Tạo lenderSetting'),
                6 => array('code' => PERMISS_LENDER_SETTING_UPDATE, 'name' => 'Update lenderSetting'),
                4 => array('code' => PERMISS_LENDER_SETTING_DELETE, 'name' => 'Xóa lenderSetting'),
            ),
        ),
        46 => array(
            'group_permiss' => 'Quyền LENDER_POPUP',
            'infor' => array(
                1 => array('code' => PERMISS_LENDER_POPUP_FULL, 'name' => 'Full lenderPopup'),
                2 => array('code' => PERMISS_LENDER_POPUP_VIEW, 'name' => 'View lenderPopup'),
                3 => array('code' => PERMISS_LENDER_POPUP_CREATE, 'name' => 'Tạo lenderPopup'),
                4 => array('code' => PERMISS_LENDER_POPUP_UPDATE, 'name' => 'Update lenderPopup'),
                5 => array('code' => PERMISS_LENDER_POPUP_DELETE, 'name' => 'Xóa lenderPopup'),
            ),
        ),
        14 => array(
            'group_permiss' => 'Quyền LENDER LOANS',
            'infor' => array(
                1 => array('code' => PERMISS_LENDER_LOANS_FULL, 'name' => 'Full lenderLoan'),
                2 => array('code' => PERMISS_LENDER_LOANS_LIST, 'name' => 'View lenderLoan'),
                3 => array('code' => PERMISS_LENDER_LOANS_VIEW, 'name' => 'Detail lenderLoan'),
                5 => array('code' => PERMISS_LENDER_LOANS_CREATE, 'name' => 'Tạo lenderLoan'),
                6 => array('code' => PERMISS_LENDER_LOANS_UPDATE, 'name' => 'Update lenderLoan'),
                4 => array('code' => PERMISS_LENDER_LOANS_DELETE, 'name' => 'Xóa lenderLoan'),
            ),
        ),
        15 => array(
            'group_permiss' => 'Quyền LENDER CONTRACTS',
            'infor' => array(
                1 => array('code' => PERMISS_LENDER_CONTRACTS_FULL, 'name' => 'Full lenderContracts'),
                2 => array('code' => PERMISS_LENDER_CONTRACTS_LIST, 'name' => 'View lenderContracts'),
                3 => array('code' => PERMISS_LENDER_CONTRACTS_VIEW, 'name' => 'Detail lenderContracts'),
                5 => array('code' => PERMISS_LENDER_CONTRACTS_CREATE, 'name' => 'Tạo lenderContracts'),
                6 => array('code' => PERMISS_LENDER_CONTRACTS_UPDATE, 'name' => 'Update lenderContracts'),
                7 => array('code' => PERMISS_LENDER_CONTRACTS_DELETE, 'name' => 'Xóa lenderContracts'),
                4 => array('code' => PERMISS_LENDER_CONTRACTS_PAY_DEBT, 'name' => 'Trả nợ NĐT lenderContracts'),
            ),
        ),
        16 => array(
            'group_permiss' => 'Quyền LENDER PAYMENTS',
            'infor' => array(
                1 => array('code' => PERMISS_LENDER_PAYMENTS_FULL, 'name' => 'Full lenderPayments'),
                2 => array('code' => PERMISS_LENDER_PAYMENTS_LIST, 'name' => 'View lenderPayments'),
                3 => array('code' => PERMISS_LENDER_PAYMENTS_VIEW, 'name' => 'Detail lenderPayments'),
                5 => array('code' => PERMISS_LENDER_PAYMENTS_CREATE, 'name' => 'Tạo lenderPayments'),
                6 => array('code' => PERMISS_LENDER_PAYMENTS_UPDATE, 'name' => 'Update lenderPayments'),
                7 => array('code' => PERMISS_LENDER_PAYMENTS_DELETE, 'name' => 'Xóa lenderPayments'),
            ),
        ),
        17 => array(
            'group_permiss' => 'Quyền REPORT LENDER',
            'infor' => array(
                1 => array('code' => PERMISS_REPORT_LENDER_COLLECT_FULL, 'name' => 'Full COLLECT'),
                2 => array('code' => PERMISS_REPORT_LENDER_COLLECT_VIEW, 'name' => 'Detail COLLECT'),
                3 => array('code' => PERMISS_REPORT_LENDER_PAYMENT_FULL, 'name' => 'Full PAYMENT'),
                5 => array('code' => PERMISS_REPORT_LENDER_PAYMENT_VIEW, 'name' => 'Detail PAYMENT'),
                6 => array('code' => PERMISS_REPORT_LENDER_HAVEPAY_FULL, 'name' => 'Full HAVEPAY'),
                7 => array('code' => PERMISS_REPORT_LENDER_HAVEPAY_VIEW, 'name' => 'Detail HAVEPAY'),
                8 => array('code' => PERMISS_REPORT_LENDER_OVERALL_FULL, 'name' => 'Full OVERALL'),
                10 => array('code' => PERMISS_REPORT_LENDER_OVERALL_VIEW, 'name' => 'Detail OVERALL'),
                11 => array('code' => PERMISS_REPORT_LENDER_SCHEDULE_FULL, 'name' => 'Full SCHEDULE'),
                12 => array('code' => PERMISS_REPORT_LENDER_SCHEDULE_VIEW, 'name' => 'Detail SCHEDULE'),
                13 => array('code' => PERMISS_REPORT_LENDER_TYPE_FULL, 'name' => 'Full TYPE'),
                14 => array('code' => PERMISS_REPORT_LENDER_TYPE_VIEW, 'name' => 'Detail TYPE'),
            ),
        ),
        18 => array(
            'group_permiss' => 'Quyền REPORT LOANER',
            'infor' => array(
                1 => array('code' => PERMISS_REPORT_LOANER_CONTRACT_FULL, 'name' => 'Full CONTRACT'),
                2 => array('code' => PERMISS_REPORT_LOANER_CONTRACT_VIEW, 'name' => 'Detail CONTRACT'),
                3 => array('code' => PERMISS_REPORT_LOANER_DISBURSEMENT_FULL, 'name' => 'Full DISBURSEMENT'),
                5 => array('code' => PERMISS_REPORT_LOANER_DISBURSEMENT_VIEW, 'name' => 'Detail DISBURSEMENT'),
                6 => array('code' => PERMISS_REPORT_LOANER_RECOVERY_FULL, 'name' => 'Full RECOVERY'),
                7 => array('code' => PERMISS_REPORT_LOANER_RECOVERY_VIEW, 'name' => 'Detail RECOVERY'),
                8 => array('code' => PERMISS_REPORT_LOANER_TOTAL_DEBT_FULL, 'name' => 'Full TOTAL_DEBT'),
                10 => array('code' => PERMISS_REPORT_LOANER_TOTAL_DEBT_VIEW, 'name' => 'Detail TOTAL_DEBT'),
                11 => array('code' => PERMISS_REPORT_LOANER_FIRST_CONTRACT_FULL, 'name' => 'Full FIRST_CONTRACT'),
                12 => array('code' => PERMISS_REPORT_LOANER_FIRST_CONTRACT_VIEW, 'name' => 'Detail FIRST_CONTRACT'),
                13 => array('code' => PERMISS_REPORT_LOANER_LOAN_FULL, 'name' => 'Full LOAN'),
                14 => array('code' => PERMISS_REPORT_LOANER_LOAN_VIEW, 'name' => 'Detail LOAN'),
                15 => array('code' => PERMISS_REPORT_LOANER_GROUP_DEBT_FULL, 'name' => 'Full GROUP_DEBT'),
                16 => array('code' => PERMISS_REPORT_LOANER_GROUP_DEBT_VIEW, 'name' => 'Detail GROUP_DEBT'),
                17 => array('code' => PERMISS_REPORT_LOANER_GROUP_MTD_FULL, 'name' => 'Full GROUP_MTD'),
                18 => array('code' => PERMISS_REPORT_LOANER_GROUP_MTD_VIEW, 'name' => 'Detail GROUP_MTD'),
                19 => array('code' => PERMISS_REPORT_LOANER_POINT_OVERALL_FULL, 'name' => 'Full POINT_OVERALL'),
                20 => array('code' => PERMISS_REPORT_LOANER_POINT_OVERALL_VIEW, 'name' => 'Detail POINT_OVERALL'),
                21 => array('code' => PERMISS_REPORT_LOANER_POINT_GROUP_FULL, 'name' => 'Full POINT_GROUP'),
                22 => array('code' => PERMISS_REPORT_LOANER_POINT_GROUP_VIEW, 'name' => 'Detail POINT_GROUP'),
                23 => array('code' => PERMISS_REPORT_LOANER_POINT_USED_FULL, 'name' => 'Full POINT_USED'),
                24 => array('code' => PERMISS_REPORT_LOANER_POINT_USED_VIEW, 'name' => 'Detail POINT_USED'),
                25 => array('code' => PERMISS_REPORT_LOANER_ALEGO_CARD_FULL, 'name' => 'Full ALEGO_CARD'),
                26 => array('code' => PERMISS_REPORT_LOANER_ALEGO_CARD_VIEW, 'name' => 'Detail ALEGO_CARD'),
                27 => array('code' => PERMISS_REPORT_LOANER_RECOVERY_DEBT_FULL, 'name' => 'Full RECOVERY_DEBT'),
                28 => array('code' => PERMISS_REPORT_LOANER_RECOVERY_DEBT_VIEW, 'name' => 'Detail RECOVERY_DEBT'),
                29 => array('code' => PERMISS_REPORT_LOANER_TOTAL_LOAN_FULL, 'name' => 'Full TOTAL_LOAN'),
                30 => array('code' => PERMISS_REPORT_LOANER_TOTAL_LOAN_VIEW, 'name' => 'Detail TOTAL_LOAN'),
                31 => array('code' => PERMISS_REPORT_LOANER_GIFT_CHARGE_FULL, 'name' => 'Full GIFT_CHARGE'),
                32 => array('code' => PERMISS_REPORT_LOANER_GIFT_CHARGE_VIEW, 'name' => 'Detail GIFT_CHARGE'),
                33 => array('code' => PERMISS_REPORT_LOANER_DETAIL_DEBT_FULL, 'name' => 'Full DETAIL_DEBT'),
                34 => array('code' => PERMISS_REPORT_LOANER_DETAIL_DEBT_VIEW, 'name' => 'Detail DETAIL_DEBT'),
                35 => array('code' => PERMISS_REPORT_LOANER_TIME_GROUP_DEBT_FULL, 'name' => 'Full TIME_GROUP_DEBT'),
                36 => array('code' => PERMISS_REPORT_LOANER_TIME_GROUP_DEBT_VIEW, 'name' => 'Detail TIME_GROUP_DEBT'),
            ),
        ),
        19 => array(
            'group_permiss' => 'Quyền REPORT MARKETING',
            'infor' => array(
                1 => array('code' => PERMISS_REPORT_MARKETING_CONTRACT_FULL, 'name' => 'Full CONTRACT'),
                2 => array('code' => PERMISS_REPORT_MARKETING_CONTRACT_VIEW, 'name' => 'Detail CONTRACT'),
                3 => array('code' => PERMISS_REPORT_MARKETING_PROMOTION_FULL, 'name' => 'Full PROMOTION'),
                5 => array('code' => PERMISS_REPORT_MARKETING_PROMOTION_VIEW, 'name' => 'Detail PROMOTION'),
            ),
        ),
        20 => array(
            'group_permiss' => 'Quyền REPORT VAYMUON',
            'infor' => array(
                1 => array('code' => PERMISS_REPORT_VAYMUON_LOAN_FULL, 'name' => 'Full LOAN'),
                2 => array('code' => PERMISS_REPORT_VAYMUON_LOAN_VIEW, 'name' => 'Detail LOAN'),
                3 => array('code' => PERMISS_REPORT_VAYMUON_CONTRACT_FULL, 'name' => 'Full CONTRACT'),
                5 => array('code' => PERMISS_REPORT_VAYMUON_CONTRACT_VIEW, 'name' => 'Detail CONTRACT'),
                6 => array('code' => PERMISS_REPORT_VAYMUON_OVERALL_FULL, 'name' => 'Full OVERALL'),
                7 => array('code' => PERMISS_REPORT_VAYMUON_OVERALL_VIEW, 'name' => 'Detail OVERALL'),
                8 => array('code' => PERMISS_REPORT_VAYMUON_RECEIPT_FULL, 'name' => 'Full RECEIPT'),
                10 => array('code' => PERMISS_REPORT_VAYMUON_RECEIPT_VIEW, 'name' => 'Detail RECEIPT'),
                11 => array('code' => PERMISS_REPORT_VAYMUON_FEE_RATE_FULL, 'name' => 'Full FEE_RATE'),
                12 => array('code' => PERMISS_REPORT_VAYMUON_FEE_RATE_VIEW, 'name' => 'Detail FEE_RATE'),
                13 => array('code' => PERMISS_REPORT_VAYMUON_REMIND_FULL, 'name' => 'Full REMIND'),
                14 => array('code' => PERMISS_REPORT_VAYMUON_REMIND_VIEW, 'name' => 'Detail REMIND'),
                15 => array('code' => PERMISS_REPORT_VAYMUON_CALL_LOG_FULL, 'name' => 'Full CALL_LOG'),
                16 => array('code' => PERMISS_REPORT_VAYMUON_CALL_LOG_VIEW, 'name' => 'Detail CALL_LOG'),
                17 => array('code' => PERMISS_REPORT_VAYMUON_LIST_GUEST_FULL, 'name' => 'Full LIST_GUEST'),
                18 => array('code' => PERMISS_REPORT_VAYMUON_LIST_GUEST_VIEW, 'name' => 'Detail LIST_GUEST'),
            ),
        ),
        21 => array(
            'group_permiss' => 'Quyền LOANS',
            'infor' => array(
                1 => array('code' => PERMISS_LOANS_FULL, 'name' => 'Full YCV'),
                2 => array('code' => PERMISS_LOANS_VIEW, 'name' => 'Detail YCV'),
                3 => array('code' => PERMISS_LOANS_CREATE, 'name' => 'Tạo YCV'),
                5 => array('code' => PERMISS_LOANS_DELETE, 'name' => 'Xóa YCV'),
                6 => array('code' => PERMISS_LOANS_VIEW_MINE, 'name' => 'YCV của tôi'),
                7 => array('code' => PERMISS_LOANS_WAIT_FULL, 'name' => 'Full YCV chờ nhận'),
                8 => array('code' => PERMISS_LOANS_WAIT_VIEW, 'name' => 'View YCV chờ nhận'),
                9 => array('code' => PERMISS_LOANS_WAIT_CREATE, 'name' => 'Nhận YCV chờ nhận'),
                10 => array('code' => PERMISS_LOANS_NHAN_YCV, 'name' => 'Nhận YCV CSKH'),
                11 => array('code' => PERMISS_LOANS_YCV_VH1, 'name' => 'Button YCV VH1'),
                12 => array('code' => PERMISS_LOANS_YCV_VH2, 'name' => 'Button YCV VH2'),
            ),
        ),
        10 => array(
            'group_permiss' => 'Quyền Nghề nghiệp NV',
            'infor' => array(
                1 => array('code' => PERMISS_CAREER_FULL, 'name' => 'Full career'),
                2 => array('code' => PERMISS_CAREER_VIEW, 'name' => 'View career'),
                3 => array('code' => PERMISS_CAREER_CREATE, 'name' => 'Tạo career'),
                4 => array('code' => PERMISS_CAREER_DELETE, 'name' => 'Xóa career'),
            ),
        ),
        27 => array(
            'group_permiss' => 'Quyền LOANER',
            'infor' => array(
                1 => array('code' => PERMISS_LOANER_FULL, 'name' => 'Full LOANER'),
                2 => array('code' => PERMISS_LOANER_VIEW, 'name' => 'List LOANER'),
                3 => array('code' => PERMISS_LOANER_CREATE, 'name' => 'Tạo LOANER'),
                5 => array('code' => PERMISS_LOANER_DELETE, 'name' => 'Xóa LOANER'),
                6 => array('code' => PERMISS_LOANER_AJAX_UPDATE_FIELD, 'name' => 'AJAX_UPDATE_FIELD'),
                7 => array('code' => PERMISS_LOANER_AJAX_GET_LOANER_DOCUMENT, 'name' => 'AJAX_LOANER_DOCUMENT'),
                8 => array('code' => PERMISS_LOANER_AJAX_GET_LOANER_PHONE_BOOK, 'name' => 'AJAX_LOANER_PHONE_BOOK'),
                10 => array('code' => PERMISS_LOANER_AJAX_GET_LOANER_REPAYMENT, 'name' => 'AJAX_LOANER_REPAYMENT'),
                11 => array('code' => PERMISS_LOANER_AJAX_GET_LOANER_WAY, 'name' => 'AJAX_GET_LOANER_WAY'),
                12 => array('code' => PERMISS_LOANER_AJAX_GET_CALL_LOG, 'name' => 'AJAX_CALL_LOG'),
                13 => array('code' => PERMISS_LOANER_AJAX_GET_LOANER_HISTORY_SETTING, 'name' => 'AJAX_LOANER_HISTORY'),
            ),
        ),
        28 => array(
            'group_permiss' => 'Quyền LoanContracts',
            'infor' => array(
                1 => array('code' => PERMISS_LOAN_CONTRACTS_FULL, 'name' => 'Full LoanContracts'),
                2 => array('code' => PERMISS_LOAN_CONTRACTS_VIEW, 'name' => 'List LoanContracts'),
                3 => array('code' => PERMISS_LOAN_CONTRACTS_DETAIL, 'name' => 'Detail LoanContracts'),
                5 => array('code' => PERMISS_AJAX_GET_LOAN_CONTRACTS_DOCUMENT, 'name' => 'AJAX_CONTRACTS_DOCUMENT'),
                6 => array('code' => PERMISS_AJAX_GET_LOAN_CONTRACTS_LENDER, 'name' => 'AJAX_UPDATE_FIELD'),
                7 => array('code' => PERMISS_AJAX_GET_LOAN_CONTRACTS_NOTIFY, 'name' => 'AJAX_LOANER_DOCUMENT'),
                8 => array('code' => PERMISS_AJAX_GET_LOAN_CONTRACTS_RECEIPTS, 'name' => 'AJAX_LOANER_PHONE_BOOK'),
                9 => array('code' => PERMISS_VIMO_FULL, 'name' => 'Full check trạng thái vimo'),
                10 => array('code' => PERMISS_VIMO_CHECK_PAY_TRANSACTION, 'name' => 'Check Vimo status'),
                11 => array('code' => PERMISS_VIMO_CHECK_TRANSACTION_DISBURSE_AUTO, 'name' => 'Check kết quả giao dịch'),
                12 => array('code' => PERMISS_VIMO_UPDATE_TRANSACTION_DISBURSE_AUTO, 'name' => 'Update giao dịch Vimo'),
                13 => array('code' => PERMISS_VIMO_UPDATE_WAITING_DISBURSED_FROM_ERROR_DISBURSED, 'name' => 'Gửi về Chờ Giải Ngân cho giải ngân tự động'),
            ),
        ),
        22 => array(
            'group_permiss' => 'Quyền Thẩm định',
            'infor' => array(
                1 => array('code' => PERMISS_LOAN_EXPERTISE_FULL, 'name' => 'Full thẩm định'),
                2 => array('code' => PERMISS_LOAN_EXPERTISE_VIEW, 'name' => 'Detail thẩm định'),
                3 => array('code' => PERMISS_LOAN_EXPERTISE_CREATE, 'name' => 'Tạo thẩm định'),
            ),
        ),
        42 => array(
            'group_permiss' => 'Quyền TRANSACTION LOANER',
            'infor' => array(
                1 => array('code' => PERMISS_TRANSACTION_LOANER_FULL, 'name' => 'Full transactionLoaner'),
                2 => array('code' => PERMISS_TRANSACTION_LOANER_VIEW, 'name' => 'View transactionLoaner'),
                3 => array('code' => PERMISS_TRANSACTION_LOANER_CREATE, 'name' => 'Tạo transactionLoaner'),
                4 => array('code' => PERMISS_TRANSACTION_LOANER_CANCEL, 'name' => 'Xóa transactionLoaner'),
                5 => array('code' => PERMISS_TRANSACTION_LOANER_DS, 'name' => 'DS transactionLoaner')
            ),
        ),
        24 => array(
            'group_permiss' => 'Quyền Chính sách áp dụng maketting',
            'infor' => array(
                1 => array('code' => PERMISS_DEFINE_POLICY_APPLIES_FULL, 'name' => 'Full Chính sách'),
                2 => array('code' => PERMISS_DEFINE_POLICY_APPLIES_VIEW, 'name' => 'Detail Chính sách'),
                3 => array('code' => PERMISS_DEFINE_POLICY_APPLIES_CREATE, 'name' => 'Tạo Chính sách'),
                4 => array('code' => PERMISS_DEFINE_POLICY_APPLIES_DELETE, 'name' => 'Xóa Chính sách'),
            ),
        ),
        23 => array(
            'group_permiss' => 'Quyền Nhóm nợ',
            'infor' => array(
                1 => array('code' => PERMISS_DEFINE_DEBT_FULL, 'name' => 'Full Nhóm nợ'),
                2 => array('code' => PERMISS_DEFINE_DEBT_VIEW, 'name' => 'Detail Nhóm nợ'),
                3 => array('code' => PERMISS_DEFINE_DEBT_CREATE, 'name' => 'Tạo Nhóm nợ'),
                4 => array('code' => PERMISS_DEFINE_DEBT_DELETE, 'name' => 'Xóa Nhóm nợ'),
            ),
        ),
        25 => array(
            'group_permiss' => 'Quyền thu nợ',
            'infor' => array(
                1 => array('code' => PERMISS_DEFINE_DEBT_RECOVERY_FULL, 'name' => 'Full thu nợ'),
                2 => array('code' => PERMISS_DEFINE_DEBT_RECOVERY_VIEW, 'name' => 'Detail thu nợ'),
                3 => array('code' => PERMISS_DEFINE_DEBT_RECOVERY_CREATE, 'name' => 'Tạo thu nợ'),
                4 => array('code' => PERMISS_DEFINE_DEBT_RECOVERY_DELETE, 'name' => 'Xóa thu nợ'),
            ),
        ),
        47 => array(
            'group_permiss' => 'Quyền lịch trả nợ',
            'infor' => array(
                1 => array('code' => PERMISS_REPAYMENT_FULL, 'name' => 'Full repayment'),
                2 => array('code' => PERMISS_REPAYMENT_VIEW, 'name' => 'View repayment'),
                3 => array('code' => PERMISS_REPAYMENT_CREATE, 'name' => 'Tạo repayment'),
                4 => array('code' => PERMISS_REPAYMENT_CANCEL, 'name' => 'Update repayment'),
                5 => array('code' => PERMISS_ADD_REPAYMENT_HISTORY, 'name' => 'Add history repayment'),
                6 => array('code' => PERMISS_AJAX_GET_RECEIPT, 'name' => 'AJAX_GET_RECEIPT'),
                7 => array('code' => PERMISS_AJAX_RECEIVE_REPAYMENT, 'name' => 'AJAX_RECEIVE_REPAYMENT'),
                8 => array('code' => PERMISS_AJAX_LOAD_PHI_PHAT, 'name' => 'AJAX_LOAD_PHI_PHAT'),
                8 => array('code' => PERMISS_AJAX_RECEIVE_LIST_REPAYMENT, 'name' => 'AJAX_RECEIVE_LIST_REPAYMENT'),
            ),
        ),
        54 => array(
            'group_permiss' => 'Quyền Nhắc nợ',
            'infor' => array(
                1 => array('code' => PERMISS_REMINDER_DEBT_FULL, 'name' => 'Full reminderDebt'),
                2 => array('code' => PERMISS_REMINDER_DEBT_VIEW, 'name' => 'View reminderDebt'),
                3 => array('code' => PERMISS_REMINDER_DEBT_CREATE, 'name' => 'Tạo reminderDebt'),
                4 => array('code' => PERMISS_REMINDER_DEBT_DELETE, 'name' => 'Xóa reminderDebt'),
                5 => array('code' => PERMISS_REMINDER_DEBT_DEACTIVE, 'name' => 'deactive reminderDebt'),
                6 => array('code' => PERMISS_REMINDER_DEBT_ACTIVE, 'name' => 'active reminderDebt'),
            ),
        ),
        26 => array(
            'group_permiss' => 'Quyền Sản phẩm',
            'infor' => array(
                1 => array('code' => PERMISS_PRODUCT_FULL, 'name' => 'Full PRODUCT'),
                2 => array('code' => PERMISS_PRODUCT_VIEW, 'name' => 'List PRODUCT'),
                3 => array('code' => PERMISS_PRODUCT_CREATE, 'name' => 'Tạo PRODUCT'),
                4 => array('code' => PERMISS_PRODUCT_DELETE, 'name' => 'Xóa PRODUCT'),
                5 => array('code' => PERMISS_PRODUCT_ACTIVE, 'name' => 'Active PRODUCT'),
                6 => array('code' => PERMISS_PRODUCT_DEACTIVE, 'name' => 'Deactive PRODUCT'),
            ),
        ),
        40 => array(
            'group_permiss' => 'Quyền công ty',
            'infor' => array(
                1 => array('code' => PERMISS_COMPANY_FULL, 'name' => 'Full company'),
                2 => array('code' => PERMISS_COMPANY_VIEW, 'name' => 'View company'),
                3 => array('code' => PERMISS_COMPANY_CREATE, 'name' => 'Tạo company'),
                4 => array('code' => PERMISS_COMPANY_DELETE, 'name' => 'Xóa company'),
                5 => array('code' => PERMISS_COMPANY_WALLET_USER_FULL, 'name' => 'Ví company'),
                6 => array('code' => PERMISS_COMPANY_BANK_USER_FULL, 'name' => 'Banks company'),
            ),
        ),
        41 => array(
            'group_permiss' => 'Quyền Phiếu thu chi Cty',
            'infor' => array(
                1 => array('code' => PERMISS_COMPANY_BILL_EXPENDITURE_FULL, 'name' => 'Full Phiếu thu chi'),
                2 => array('code' => PERMISS_COMPANY_BILL_EXPENDITURE_VIEW, 'name' => 'View Phiếu thu chi'),
                3 => array('code' => PERMISS_COMPANY_BILL_EXPENDITURE_CREATE, 'name' => 'Tạo Phiếu thu chi'),
            ),
        ),


        44 => array(
            'group_permiss' => 'Quyền Nhà đảm bảo',
            'infor' => array(
                1 => array('code' => PERMISS_GUARANTOR_FULL, 'name' => 'Full NĐB'),
                2 => array('code' => PERMISS_GUARANTOR_VIEW, 'name' => 'View NĐB'),
                3 => array('code' => PERMISS_GUARANTOR_CREATE, 'name' => 'Tạo NĐB'),
                4 => array('code' => PERMISS_GUARANTOR_DELETE, 'name' => 'Xóa NĐB'),
            ),
        ),
        45 => array(
            'group_permiss' => 'Quyền Phiếu thu chi NĐB',
            'infor' => array(
                1 => array('code' => PERMISS_GUARANTOR_BILL_EXPENDITURE_FULL, 'name' => 'Full Phiếu thu chi NĐB'),
                2 => array('code' => PERMISS_GUARANTOR_BILL_EXPENDITURE_VIEW, 'name' => 'View Phiếu thu chi NĐBĐB'),
                3 => array('code' => PERMISS_GUARANTOR_BILL_EXPENDITURE_CREATE, 'name' => 'Tạo Phiếu thu chi NĐB'),
            ),
        ),

        35 => array(
            'group_permiss' => 'Quyền Cấu hinh hoa hồng',
            'infor' => array(
                1 => array('code' => PERMISS_OPTION_COMMISSION_FULL, 'name' => 'Full optionCommission'),
                2 => array('code' => PERMISS_OPTION_COMMISSION_VIEW, 'name' => 'View optionCommission'),
                3 => array('code' => PERMISS_OPTION_COMMISSION_CREATE, 'name' => 'Tạo optionCommission'),
                4 => array('code' => PERMISS_OPTION_COMMISSION_DELETE, 'name' => 'Xóa optionCommission'),
            ),
        ),
        49 => array(
            'group_permiss' => 'Quyền người giới thiệu',
            'infor' => array(
                1 => array('code' => PERMISS_COMMISSION_FULL, 'name' => 'Full commission'),
                2 => array('code' => PERMISS_COMMISSION_VIEW, 'name' => 'View commission'),
                3 => array('code' => PERMISS_COMMISSION_CREATE, 'name' => 'Tạo commission'),
                4 => array('code' => PERMISS_COMMISSION_DELETE, 'name' => 'Xóa commission'),
            ),
        ),
        51 => array(
            'group_permiss' => 'Quyền thanh toán hoa hồng',
            'infor' => array(
                1 => array('code' => PERMISS_REPAYMENT_COMMISSION_FULL, 'name' => 'Full repaymentCommission'),
                2 => array('code' => PERMISS_REPAYMENT_COMMISSION_VIEW, 'name' => 'View repaymentCommission'),
                3 => array('code' => PERMISS_REPAYMENT_COMMISSION_CREATE, 'name' => 'Tạo repaymentCommission'),
                4 => array('code' => PERMISS_REPAYMENT_COMMISSION_DELETE, 'name' => 'Xóa repaymentCommission'),
            ),
        ),
        53 => array(
            'group_permiss' => 'Quyền Phiếu chi hoa hồng',
            'infor' => array(
                1 => array('code' => PERMISS_RECEIPT_COMMISSION_FULL, 'name' => 'Full receiptCommission'),
                2 => array('code' => PERMISS_RECEIPT_COMMISSION_VIEW, 'name' => 'View receiptCommission'),
                3 => array('code' => PERMISS_RECEIPT_COMMISSION_CREATE, 'name' => 'Tạo receiptCommission'),
                4 => array('code' => PERMISS_RECEIPT_COMMISSION_DELETE, 'name' => 'Xóa receiptCommission'),
            ),
        ),
        36 => array(
            'group_permiss' => 'Quyền Cấu hình điểm',
            'infor' => array(
                1 => array('code' => PERMISS_OPTION_POINT_FULL, 'name' => 'Full optionPoint'),
                2 => array('code' => PERMISS_OPTION_POINT_VIEW, 'name' => 'View optionPoint'),
                3 => array('code' => PERMISS_OPTION_POINT_CREATE, 'name' => 'Tạo optionPoint'),
                4 => array('code' => PERMISS_OPTION_POINT_DELETE, 'name' => 'Xóa optionPoint'),
            ),
        ),
        52 => array(
            'group_permiss' => 'Quyền Chính sách tích và tiêu xu',
            'infor' => array(
                1 => array('code' => PERMISS_MARKETING_COIN_POLICY_FULL, 'name' => 'Full CoinPolicy'),
                2 => array('code' => PERMISS_MARKETING_COIN_POLICY_VIEW, 'name' => 'View CoinPolicy'),
                3 => array('code' => PERMISS_MARKETING_COIN_POLICY_CREATE, 'name' => 'Tạo CoinPolicy'),
                4 => array('code' => PERMISS_MARKETING_COIN_POLICY_DELETE, 'name' => 'Xóa CoinPolicy'),
            ),
        ),

        55 => array(
            'group_permiss' => 'Quyền Chiến dịch marketing',
            'infor' => array(
                1 => array('code' => PERMISS_MARKETING_CAMPAIGN_FULL, 'name' => 'Full marketingCampaign'),
                2 => array('code' => PERMISS_MARKETING_CAMPAIGN_VIEW, 'name' => 'View marketingCampaign'),
                3 => array('code' => PERMISS_MARKETING_CAMPAIGN_CREATE, 'name' => 'Tạo marketingCampaign'),
                4 => array('code' => PERMISS_MARKETING_CAMPAIGN_ACTIVE, 'name' => 'Active marketingCampaign'),
                5 => array('code' => PERMISS_MARKETING_CAMPAIGN_LOCK, 'name' => 'Lock marketingCampaign'),
                6 => array('code' => PERMISS_MARKETING_CAMPAIGN_CANCEL, 'name' => 'Cancel marketingCampaign'),
            ),
        ),
        56 => array(
            'group_permiss' => 'Quyền Stringee group',
            'infor' => array(
                1 => array('code' => PERMISS_STRINGEE_GET_GROUP_LIST_FULL, 'name' => 'Full getGroupList'),
                2 => array('code' => PERMISS_STRINGEE_GET_GROUP_LIST_VIEW, 'name' => 'View getGroupList'),
                3 => array('code' => PERMISS_STRINGEE_GET_GROUP_CREATE, 'name' => 'Tạo getGroupList'),
                4 => array('code' => PERMISS_STRINGEE_GET_GROUP_DELETE, 'name' => 'Xóa getGroupList'),
            ),
        ),

        58 => array(
            'group_permiss' => 'Quyền Stringee Call',
            'infor' => array(
                1 => array('code' => PERMISS_STRINGEE_CALL_ANSWER_FULL, 'name' => 'Xóa Stringee Call'),
                2 => array('code' => PERMISS_STRINGEE_CALL_ANSWER_VIEW, 'name' => 'Xóa Stringee Call'),
                3 => array('code' => PERMISS_STRINGEE_CALL_ANSWER_CREATE, 'name' => 'Xóa Stringee Call'),
            ),
        ),
        57 => array(
            'group_permiss' => 'Quyền Setting Version App',
            'infor' => array(
                1 => array('code' => PERMISS_VERSION_APP_FULL, 'name' => 'Full version app'),
                2 => array('code' => PERMISS_VERSION_APP_VIEW, 'name' => 'View version app'),
                3 => array('code' => PERMISS_VERSION_APP_CREATE, 'name' => 'Tạo version app'),
            ),
        ),
        59 => array(
            'group_permiss' => 'Quyền Setting nhà cung cấp SMS',
            'infor' => array(
                1 => array('code' => PERMISS_CONFIG_PROVIDER_FULL, 'name' => 'Full NCC SMS'),
                2 => array('code' => PERMISS_CONFIG_PROVIDER_VIEW, 'name' => 'View NCC SMS'),
                3 => array('code' => PERMISS_CONFIG_PROVIDER_CREATE, 'name' => 'Tạo NCC SMS'),
                4 => array('code' => PERMISS_CONFIG_PROVIDER_UPDATE, 'name' => 'Update NCC SMS'),
                5 => array('code' => PERMISS_CONFIG_PROVIDER_DELETE, 'name' => 'Xóa NCC SMS'),
            ),
        ),
    );

}