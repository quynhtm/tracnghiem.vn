<?php

$mappings = [
	'Loans' => [
		"mappings" => [
            "_doc"=> [
                "properties" => [
					'id' => ['type' => 'keyword'],
			        'code' => ['type' => 'keyword'],
			        'loaner_id' => ['type' => 'keyword'],
			        'loaner_code' => ['type' => 'keyword'],
			        'product_id' => ['type' => 'keyword'],
			        'purpose_id' => ['type' => 'keyword'],
			        'payment_method_id' => ['type' => 'keyword'],
			        'amount' => ['type' => 'long'],
			        'duration' => ['type' => 'integer'],
			        'approve_amount' => ['type' => 'long'],
			        'approve_duration' => ['type' => 'integer'],
			        'type_duration' => ['type' => 'keyword'],
			        'fee_rate' => ['type' => 'float'],
			        'interest_rate' => ['type' => 'float'],
			        'ensure_rate' => ['type' => 'float'],
			        'sale_interest_rate' => ['type' => 'float'],
			        'total_interest' => ['type' => 'float'],
			        'number_position' => ['type' => 'integer'],
			        'status_indenture' => ['type' => 'keyword'],
			        'backlist' => ['type' => 'keyword'],
			        'check_backlist' => ['type' => 'keyword'],
			        'assign_user' => ['type' => 'keyword'],
			        'promotion_code' => ['type' => 'keyword'],
			        'promotion_value' => ['type' => 'float'],
			        'reference_code' => ['type' => 'keyword'],
			        'reference_name' => ['type' => 'text'],
			        'reference_value' => ['type' => ' '],
			        'commission_id' => ['type' => 'keyword'],
			        'reference_prepaid' => ['type' => 'float'],
			        'reference_percent_fix' => ['type' => 'float'],
			        'reference_percent' => ['type' => 'float'],
			        'charge_code' => ['type' => 'keyword'],
			        'charge_desc' => ['type' => 'text'],
			        'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
			        'updated_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss']
			    ]
			]
		]
	],
	'Loaners' => [
		"mappings" => [
            "_doc"=> [
                "properties" => [
					'id' => ['type' => 'keyword'],
					'code' => ['type' => 'keyword'],
					'facebook_id' => ['type' => 'keyword'],
					'facebook_token' => ['type' => 'keyword'],
					'facebook_link' => ['type' => 'keyword'],
					'user_name' => ['type' => 'keyword'],
					'full_name' => ['type' => 'text'],
					'birthday' => ['type' => 'text'],
					'avatar' => ['type' => 'keyword'],
					'so_can_cuoc' => ['type' => 'keyword'],
					'so_tai_khoan_ngan_hang' => ['type' => 'keyword'],
					'email' => ['type' => 'keyword'],
					'email_status' => ['type' => 'keyword'],
					'password' => ['type' => 'keyword'],
					'phone' => ['type' => 'keyword'],
					'phone_status' => ['type' => 'keyword'],
					'full_address' => ['type' => 'text'],
					'temp_full_address' => ['type' => 'text'],
					'sex' => ['type' => 'keyword'],
					'job' => ['type' => 'text'],
					'status' => ['type' => 'keyword'],
					'amount_of_debt' => ['type' => 'text'],
					'literacy_id' => ['type' => 'keyword'],
					'relationship_id' => ['type' => 'keyword'],
					'career_id' => ['type' => 'keyword'],
					'email_otp' => ['type' => 'keyword'],
					'email_otp_expire_time' => ['type' => 'text'],
					'phone_otp' => ['type' => 'keyword'],
					'phone_otp_expire_time' => ['type' => 'keyword'],
					'app_id' => ['type' => 'keyword'],
					'device_token' => ['type' => 'keyword'],
					'os_type' => ['type' => 'keyword'],
					'loaner_system_profile_status' => ['type' => 'keyword'],
					'is_first_time_login' => ['type' => 'text'],
					'update_location' => ['type' => 'text'],
					'update_phone_book' => ['type' => 'text'],
					'update_call_log' => ['type' => 'text'],
					'token' => ['type' => 'keyword'],
					'lock_duration' => ['type' => 'keyword'],
					'lock_date' => ['type' => 'text'],
					'number_loan' => ['type' => 'keyword'],
					'number_contract' => ['type' => 'keyword'],
					'status_profile' => ['type' => 'keyword'],
					'lock_reason' => ['type' => 'text'],
					'refer_code' => ['type' => 'keyword'],
					'refer_name' => ['type' => 'text'],
					'forms_commission' => ['type' => 'keyword'],
					'acount_forms_commission' => ['type' => 'keyword'],
					'option_commission_id' => ['type' => 'keyword'],
					'request_fb' => ['type' => 'keyword'],
					'end_time_usually_activity' => ['type' => 'keyword'],
					'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'updated_at' => ['type' => 'text']
			    ]
			]
		]
	],
	'LenderLoans' => [
		'mappings' => [
			"_doc"=> [
                "properties" => [
                	'id' => ['type' => 'keyword'],
                	'code' => ['type' => 'keyword'],
                	'loaner_id' => ['type' => 'keyword'],
                	'status' => ['type' => 'keyword'],
                	'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
                	'updated_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
                ]
            ]
		]
	],
	'Contracts' => [
		"mappings" => [
            "_doc"=> [
                "properties" => [
					'id' => ['type' => 'keyword'],
					'loaner_id' => ['type' => 'keyword'],
					'code' => ['type' => 'keyword'],
					'loaner_name' => ['type' => 'text'],
					'loaner_career' => ['type' => 'text'],
					'loaner_address' => ['type' => 'text'],
					'loaner_facebook_id' => ['type' => 'keyword'],
					'loaner_code' => ['type' => 'keyword'],
					'product_id' => ['type' => 'keyword'],
					'purpose_id' => ['type' => 'keyword'],
					'loan_id' => ['type' => 'keyword'],
					'loan_code' => ['type' => 'keyword'],
					'payment_method_id' => ['type' => 'keyword'],
					'contract_document_entity_id' => ['type' => 'keyword'],
					'amount' => ['type' => 'long'],
					'duration' => ['type' => 'integer'],
					'approve_amount' => ['type' => 'long'],
					'approve_duration' => ['type' => 'integer'],
					'type_duration' => ['type' => 'keyword'],
					'fee_rate' => ['type' => 'float'],
					'interest_rate' => ['type' => 'float'],
					'ensure_rate' => ['type' => 'float'],
					'sale_interest_rate' => ['type' => 'float'],
					'total_interest' => ['type' => 'float'],
					'history' => ['type' => 'text'],
					'comment' => ['type' => 'text'],
					'user_id' => ['type' => 'keyword'],
					'user_name' => ['type' => 'text'],
					'user_id_disbursed' => ['type' => 'keyword'],
					'user_name_disbursed' => ['type' => 'text'],
					'accepted_date' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'disbursed_date' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'disbursed_type' => ['type' => 'keyword'],
					'disbursed_transaction_code' => ['type' => 'keyword'],
					'disbursed_comment' => ['type' => 'text'],
					'currency' => ['type' => 'text'],
					'rejection_reason' => ['type' => 'text'],
					'disbursed_auto_status' => ['type' => 'keyword'],
					'acount_bank_old' => ['type' => 'keyword'],
					'note_edit_bank' => ['type' => 'text'],
					'promotion' => ['type' => 'text'],
					'status' => ['type' => 'keyword'],
					'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'updated_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'repayment' => ['type' => 'nested'],
				]
			]
		]
	],
	'Contacts' => [
		"mappings" => [
            "_doc"=> [
                "properties" => [
					'id' => ['type' => 'keyword'],
					'loaner_id' => ['type' => 'keyword'],
					'full_name' => ['type' => 'text'],
					'status' => ['type' => 'keyword'],
					'phone_number' => ['type' => 'text'],
					'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'updated_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'loaner' => ['type' => 'nested'],
				]
			]
		]
	],
	'Locations' => [
		"mappings" => [
            "_doc"=> [
                "properties" => [
					'id' => ['type' => 'keyword'],
					'loaner_id' => ['type' => 'keyword'],
					'location' => ['type' => 'keyword'],
					'created_time' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'updated_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'loaner' => ['type' => 'nested']
				]
			]
		]
	],
	'Repayments' => [
		"mappings" => [
            "_doc"=> [
                "properties" => [
					'id' => ['type' => 'keyword'],
					'loan_id' => ['type' => 'keyword'],
					'loan_code' => ['type' => 'keyword'],
					'contract_id' => ['type' => 'keyword'],
					'contract_code' => ['type' => 'keyword'],
					'loaner_id' => ['type' => 'keyword'],
					'loaner_code' => ['type' => 'keyword'],
					'repayment_period' => ['type' => 'text'],
					'original_amount_period' => ['type' => 'float'],
					'original_grace_amount_period' => ['type' => 'float'],
					'original_over_amount_period' => ['type' => 'float'],
					'interest_rate' => ['type' => 'float'],
					'interest_grace' => ['type' => 'float'],
					'interest_over' => ['type' => 'float'],
					'interest_rate_amount_period' => ['type' => 'float'],
					'interest_grace_amount_period' => ['type' => 'float'],
					'interest_over_amount_period' => ['type' => 'float'],
					'disbursed_date' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'interest_amount_period' => ['type' => 'float'],
					'period_amount' => ['type' => 'float'],
					'real_repayment_amount' => ['type' => 'float'],
					'repayment_date' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'real_repayment_date' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'number_of_grace_date' => ['type' => 'integer'],
					'transaction_code' => ['type' => 'keyword'],
					'status' => ['type' => 'keyword'],
					'status_type_repayment' => ['type' => 'keyword'],
					'check_backlist' => ['type' => 'keyword'],
					'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'updated_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
				]
			]
		]
	],
	'Receipts' => [
		"mappings" => [
            "_doc"=> [
                "properties" => [
					'id' => ['type' => 'keyword'],
					'loaner_id' => ['type' => 'keyword'],
					'loan_id' => ['type' => 'keyword'],
					'contract_id' => ['type' => 'keyword'],
					'repayment_id' => ['type' => 'keyword'],
					'amount' => ['type' => 'float'],
					'amount_sum' => ['type' => 'float'],
					'current_deb' => ['type' => 'float'],
					'repayment_period' => ['type' => 'integer'],
					'transaction_code' => ['type' => 'keyword'],
					'payment_date' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'balance_amount' => ['type' => 'float'],
					'type' => ['type' => 'keyword'],
					'status' => ['type' => 'keyword'],
					'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'updated_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'repayment' => ['type' => 'nested']
				]
			]
		]
	],
	'Lenders' => [
		"mappings" => [
            "_doc"=> [
                "properties" => [
					'personal_info_status' => ['type' => 'keyword'],
					'identity_number_status' => ['type' => 'keyword'],
					'vimo_linked_status' => ['type' => 'keyword'],
					'status' => ['type' => 'keyword'],
					'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'updated_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
				]
			]
		]
	],
	'DocumentEntityAttributeValue' => [
		"mappings" => [
            "_doc"=> [
                "properties" => [
					'id' => ['type' => 'keyword'],
					'document_entity_id' => ['type' => 'keyword'],
					'loaner_id' => ['type' => 'keyword'],
					'document_entity_attribute_id' => ['type' => 'keyword'],
					'document_entity_attribute_code' => ['type' => 'keyword'],
					'document_entity_attribute_name' => ['type' => 'text'],
					'document_type_id' => ['type' => 'keyword'],
					'document_type_code' => ['type' => 'keyword'],
					'document_type_name' => ['type' => 'text'],
					'document_entity_attribute_input_type' => ['type' => 'keyword'],
					'document_entity_attribute_input_data' => ['type' => 'keyword'],
					'value' => ['type' => 'text'],
					'position' => ['type' => 'keyword'],
					'status' => ['type' => 'keyword'],
					'created_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
					'updated_at' => ['type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
				]
			]
		]
	]
];

define('ELASTIC_MAPPINGS', $mappings);