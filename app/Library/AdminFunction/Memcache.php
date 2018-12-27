<?php
namespace App\Library\AdminFunction;

class Memcache{
    const CACHE_ON = 1;// 0: khong dung qua cache, 1: dung qua cache

    const CACHE_MENU_BY_TAB_ID = 'cache_menu_by_tab_id_';
    const CACHE_LIST_MENU_PERMISSION = 'cache_list_menu_permission';
    const CACHE_ALL_PARENT_MENU = 'cache_all_parent_menu_';
    const CACHE_TREE_MENU = 'cache_tree_menu_';

    const CACHE_GUARANTOR_ID = 'cache_guarantor_id_';
    const CACHE_GUARANTOR_ALL = 'cache_guarantor_all';

    const CACHE_USER_ADMIN_ID = 'cache_user_admin_id_';
    const CACHE_ALL_USER_ADMIN = 'cache_all_user_admin';
    const CACHE_OPTION_USER = 'cache_option_user';
    const CACHE_INFO_USER = 'cache_info_user';
    const CACHE_USER_BY_MANAGER = 'cache_user_by_manager_';
    const CACHE_USER_BY_DEPART = 'cache_user_by_depart_';
    const CACHE_USER_BY_DEPART_ONE = 'cache_user_by_depart_one_';

    const CACHE_COMPANY_ID = 'cache_company_id_';

    const CACHE_ROLE_ID = 'cache_role_id_';
    const CACHE_OPTION_ROLE = 'cache_option_role';
    const CACHE_ROLE_ALL = 'cache_option_all';

    const CACHE_BANK_USERS_ITEM_ID = 'cache_bank_users_item_id_';

    const CACHE_LOG_CHECK_BANK_ID = 'cache_log_check_bank_id_';

    const CACHE_WALLET_USERS_ITEM_ID = 'cache_wallet_users_item_id_';
    const CACHE_WALLET_USERS_WITH_COMPANY_ID = 'cache_wallet_users_with_company_id_';

    const CACHE_REPAYMENT_HISTORY_ID = 'cache_repayment_history_id_';

    const CACHE_BILL_EXPENDITURE_ID = 'cache_bill_expenditure_id_';

    const CACHE_MAKETING_CAMPAIGN_ID = 'cache_maketing_campaign_id_';
    const CACHE_MAKETING_CAMPAIGN_ALL = 'cache_maketing_campaign_all';
    const CACHE_MAKETING_CAMPAIGN_SCHEDULE = 'cache_maketing_campaign_';

    const CACHE_MAKETING_COIN_POLICY_ID = 'cache_maketing_coin_policy_id_';
    const CACHE_MAKETING_COIN_POLICY_ALL = 'cache_maketing_coin_policy_all';

    const CACHE_MAKETING_PROGRAM_ID = 'cache_maketing_program_id_';
    const CACHE_MAKETING_PROGRAM_ALL = 'cache_maketing_program_all';

    const CACHE_CONTENT_NOTIFICATIONS_ID = 'cache_content_notifications_id_';

    const CACHE_BANNER_ID = 'cache_banner_id_';

    const CACHE_ALEGO_PHONE_CARD_ID = 'cache_alego_phone_card_id_';

    const CACHE_BANK_INFORMATION_BORROWERS_ID = 'cache_bank_information_borrowers_id_';

    const CACHE_BILL_PAYMENT_ID = 'cache_bill_payment_id_';

    const CACHE_CALL_LOGS_ID = 'cache_call_logs_id_';

    const CACHE_CAREERS_ID = 'cache_careers_id_';
    const CACHE_CAREERS_ALL = 'cache_careers_all_';
    const CACHE_CAREERS_OPTIONS = 'cache_careers_options_';

    const CACHE_COMMISSIONS_ID = 'cache_commissions_id_';

    const CACHE_CHECKOUT_LENDERS_ID = 'cache_checkout_lenders_id_';

    const CACHE_CHECK_LENDING_DUPLICATE_ID = 'cache_check_lending_duplicate_id_';

    const CACHE_CONTACTS_ID = 'cache_contacts_id_';

    const CACHE_VERSION_APP_ID = 'cache_version_app_id_';

    const CACHE_PRODUCT_ID = 'cache_product_id_';
    const CACHE_PRODUCT_ALL = 'cache_product_all';

    const CACHE_CONTRACTS_ID = 'cache_contracts_id_';

    const CACHE_EXPERTISE_ID = 'cache_expertise_id_';
    const CACHE_EXPERTISE_BY_LOANER_ID = 'cache_expertise_by_loaner_id_';

    const CACHE_FACEBOOK_ID = 'cache_facebook_id_';

    const CACHE_HISTORY_ID = 'cache_history_id_';

    const CACHE_IMAGES_ID = 'cache_images_id_';

    const CACHE_LITERACY_ID = 'cache_literacy_id_';
    const CACHE_LITERACY_ALL = 'cache_literacy_all';

    const CACHE_LOANERS_ID = 'cache_loaners_id_';

    const CACHE_LOANS_ID = 'cache_loans_id_';

    const CACHE_MATRIX_ID = 'cache_matrix_id_';

    const CACHE_MESSAGES_ID = 'cache_messages_id_';

    const CACHE_PROMOTION_ID = 'cache_promotion_id_';

    const CACHE_PURPOSES_ID = 'cache_purposes_id_';
    const CACHE_PURPOSES_ALL = 'cache_purposes_all';

    const CACHE_RECEIPTS_ID = 'cache_receipts_id_';
    const CACHE_RECEIPTS_BY_REPAYMENT_ID = 'cache_receipts_by_repayment_id_';

    const CACHE_RELATIONSHIPS_ID = 'cache_relationships_id_';
    const CACHE_RELATIONSHIPS_ALL = 'cache_relationships_all';

    const CACHE_REPAYMENTS_ID = 'cache_repayments_id_';
    const CACHE_REPAYMENTS_FOR_CRONJOB = 'cache_repayments_for_cronjob';
    const CACHE_REPAYMENTS_FOR_CRONJOB_VER2 = 'cache_repayments_for_cronjob_ver2';
    const CACHE_REPAYMENTS_ID_CONTRACT = 'cache_repayments_id_contract_';

    const CACHE_SESSION_ID = 'cache_session_id_';

    const CACHE_TOKENS_ID = 'cache_tokens_id_';

    const CACHE_USERS_NOTI_ID = 'cache_users_noti_id_';

    const CACHE_USERS_PHONE_STRINGEE_CALL_ID = 'cache_users_phone_stringee_call_id_';

    const CACHE_USERS_PHONE_STRINGEE_AGENT_ID = 'cache_users_phone_stringee_agent_id_';
    const CACHE_USERS_PHONE_STRINGEE_AGENT_USER = 'cache_users_phone_stringee_agent_user_';
    const CACHE_USERS_PHONE_STRINGEE_AGENT_STATUS_AVAILABLE = 'cache_users_phone_stringee_agent_status_available';

    const CACHE_USERS_PERMISSION_STRINGEE_CALL_ID = 'cache_users_permission_stringee_call_id_';
    const CACHE_USERS_PERMISSION_STRINGEE_CALL_UID = 'cache_users_permission_stringee_call_uid_';

    const CACHE_USERS_LOGS_STRINGEE_CALL_ID = 'cache_users_logs_stringee_call_id_';

    const CACHE_ALL_NUMBER_PHONE_STRINGEE_AGENT = 'cache_all_number_phone_stringee_agent';

    const CACHE_USERS_LOAN_LOGS_ID = 'cache_users_loan_logs_id_';

    const CACHE_USERS_LOAN_ID = 'cache_users_loan_id_';

    const CACHE_SPLIP_LOAN_ARCHIVE_ID = 'cache_splip_loan_archive_id_';

    const CACHE_SPLIP_USER_ITEM_ID = 'cache_splip_user_item_id_';

    const CACHE_TRANSACTION_LOANER_ID = 'cache_transaction_loaner_id_';

    const CACHE_SMS_FORGOT_LOG_ID = 'cache_sms_forgot_log_id_';

    const CACHE_REPAYMENT_METHOD_COMMISSTION_ID = 'cache_repayment_method_commisstion_id_';

    const CACHE_REPAYMENT_COMMISSION_ID = 'cache_repayment_commission_id_';

    const CACHE_REMINDER_DEPT_ID = 'cache_reminder_dept_id_';

    const CACHE_REMINDER_BORROWER_ID = 'cache_reminder_borrower_id_';

    const CACHE_RECEIPT_COMMISSION_ID = 'cache_receipt_commission_id_';

    const CACHE_PUSH_NOTIFICATION_ID = 'cache_push_notification_id_';

    const CACHE_PRODUCT_DOCUMENT_TYPE_ID = 'cache_product_document_type_id_';
    const CACHE_PRODUCT_DOCUMENT_TYPE_LIST = 'cache_product_document_type_list';
    const CACHE_PRODUCT_DOCUMENT_TYPE_BY_PRODUCT_AND_DOCUMENT = 'cache_product_document_type_by_product_and_document_';
    const CACHE_PRODUCT_DOCUMENT_TYPE_BY_PRODUCT_ID = 'cache_product_document_type_by_product_';

    const CACHE_PREQUALIFICATI_ID = 'cache_prequalificati_id_';

    const CACHE_POPUP_LENDER_ID = 'cache_popup_lender_id_';
    const CACHE_POPUP_LENDER_ALL = 'cache_popup_lender_all_';

    const CACHE_POINTS_CHARGE_ID = 'cache_points_charge_id_';

    const CACHE_POINTS_CHARGE_HISTORY_ID = 'cache_points_charge_history_id_';

    const CACHE_PHONE_COMPANY_FINANCE_ID = 'cache_phone_company_finance_id_';

    const CACHE_PAYMENT_METHODS_ID = 'cache_payment_methods_id_';

    const CACHE_OPTION_POINTS_ID = 'cache_option_points_id_';

    const CACHE_OPTION_COMMISSION_ID = 'cache_option_commission_id_';

    const CACHE_NUMBER_CONTRACT_LENDING_ID = 'cache_number_contract_lending_id_';

    const CACHE_NOTIFICATIONS_ID = 'cache_notifications_id_';

    const CACHE_MESSAGE_SMS_ID = 'cache_message_sms_id_';

    const CACHE_MARKETING_ID = 'cache_marketing_id_';

    const CACHE_LOCATIONS_ID = 'cache_locations_id_';

    const CACHE_LOANS_FREE_ID = 'cache_loans_free_id_';

    const CACHE_LOANER_BACKLISTS_ID = 'cache_loaner_backlists_id_';

    const CACHE_LOAN_DOCUMENT_ID = 'cache_loan_document_id_';

    const CACHE_LENDER_TOKEN_ID = 'cache_lender_token_id_';

    const CACHE_LENDERS_ID = 'cache_lenders_id_';
    const CACHE_LENDERS_APPROVE = 'cache_lenders_approve'; //cache những NĐT ở trạng thái da_duyet

    const CACHE_LENDER_NOTIFICATIONS_ID = 'cache_lender_notifications_id_';

    const CACHE_LENDER_LOANS_ID = 'cache_lender_loans_id_';
    const CACHE_LENDER_LOAN_INVEST_ID = 'cache_lender_loan_invest_id_';

    const CACHE_LENDER_HISTORY_ID = 'cache_lender_history_id_';

    const CACHE_LENDER_DISBURSE_SLIPS_ID = 'cache_lender_disburse_slips_id_';
    const CACHE_LENDER_DISBURSE_SLIPS_BY_LENDER_CONTRACT_ID = 'cache_lender_disburse_slips_by_lender_contract_id';

    const CACHE_LENDER_CONTRACTS_ID = 'cache_lender_contracts_id_';
    const CACHE_LENDER_CONTRACTS_CONTRACT_ID = 'cache_lender_contracts_contract_id_';

    const CACHE_LENDER_CAREERS_ID = 'cache_lender_careers_id_';
    const CACHE_LENDER_CAREERS_ALL = 'cache_lender_careers_all_';

    const CACHE_LENDER_APPORTIONS_ID = 'cache_lender_apportions_id_';
    const CACHE_LENDER_APPORTIONS_ALL = 'cache_lender_apportions_all_';

    const CACHE_CONFIG_PROVIDER_ID = 'cache_config_provider_id_';
    const CACHE_CONFIG_PROVIDER_ALL = 'cache_config_provider_all_';

    const CACHE_HISTORY_OPTION_POINTS_ID = 'cache_history_option_points_id_';

    const CACHE_GIFT_CHARGE_ID = 'cache_gift_charge_id_';

    const CACHE_FRIENDS_FB360_ID = 'cache_friends_fb360_id_';

    const CACHE_FACEBOOK_FRIENDS_ID = 'cache_facebook_friends_id_';

    const CACHE_DOCUMENT_TYPE_ID = 'cache_document_type_id_';
    const CACHE_DOCUMENT_TYPE_ALL = 'cache_document_type_all';

    const CACHE_DOCUMENT_ENTITY_ATTRIBUTE_VALUE_ID = 'cache_document_entity_attribute_value_id_';
    const CACHE_DOCUMENT_ENTITY_ATTRIBUTE_VALUE_BY_LOANER_ID = 'cache_document_entity_attribute_value_by_loaner_id_';

    const CACHE_DOCUMENT_ENTITY_ATTRIBUTE_ID = 'cache_document_entity_attribute_id_';

    const CACHE_DOCUMENT_ENTITY_ID = 'cache_document_entity_id_';
    const CACHE_DOCUMENT_ENTITY_BY_LOANER_ID = 'cache_document_entity_by_loaner_id_';

    const CACHE_DEVICE_APP_ID = 'cache_device_app_id_';

    const CACHE_CONTRACT_INFO_DISBURSED_AUTO_ID = 'cache_contract_info_disbursed_auto_id_';

    const CACHE_CONTRACT_DOCUMENT_ENTITY_ATTRIBUTE_VALUE_ID = 'cache_contract_document_entity_attribute_value_id_';

    const CACHE_CONTRACT_DOCUMENT_ENTITY_ID = 'cache_contract_document_entity_id_';

    const CACHE_QUESTION_ID = 'cache_question_id_';

    const CACHE_VMDEFINE_ID = 'cache_vmdefine_id_';
    const CACHE_VMDEFINE_BY_TYPE = 'cache_vmdefine_by_type_';

    const CACHE_LOANS_INFO_OTHER_ID = 'cache_loans_info_other_id_';
    const CACHE_LOANS_INFO_OTHER_LOAN_ID = 'cache_loans_info_other_loan_id_';


    const LOGIN_SESSION = 'login_session_';
    const LOGIN_SESSION_KEYS = 'login_session_keys';
}
