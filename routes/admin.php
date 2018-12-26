<?php
Route::get('logout', array('as' => 'admin.logout','uses' => Admin.'\AdminLoginController@logout'));
Route::post('forgot_password', array('as' => 'admin.forgot_password','uses' => Admin.'\AdminLoginController@forgot_password'));
Route::get('dashboard', array('as' => 'admin.dashboard','uses' => Admin.'\AdminDashBoardController@dashboard'));

//testData
Route::get('testUser',array('as' => 'admin.testUser','uses' => Admin.'\TestDataController@testDataUser'));
Route::get('runCronjob',array('as' => 'admin.runCronjob','uses' => Admin.'\TestDataController@runCronjob'));
Route::get('clear',array('as' => 'admin.clear','uses' => Admin.'\TestDataController@clearCache'));
Route::get('testElasticsearch',array('as' => 'admin.testElasticsearch','uses' => Admin.'\TestDataController@testElasticsearchService'));

//Define common
Route::match(['GET','POST'],'define', array('as' => 'admin.viewDefine','uses' => Admin.'\AdminDefineController@view'));
Route::post('define/post/{id?}', array('as' => 'admin.getDefine','uses' => Admin.'\AdminDefineController@postItem'))->where('id', '[0-9]+');
Route::get('define/delete',array('as' => 'admin.deleteDefine','uses' => Admin.'\AdminDefineController@deleteItem'));
Route::post('define/ajaxLoad', array('as' => 'admin.ajaxDefine','uses' => Admin.'\AdminDefineController@ajaxLoadForm'));

//Define Bank
Route::match(['GET','POST'],'defineBank', array('as' => 'admin.viewDefineBank','uses' => Admin.'\AdminDefineBankController@view'));
Route::post('defineBank/post/{id?}', array('as' => 'admin.getDefineBank','uses' => Admin.'\AdminDefineBankController@postItem'))->where('id', '[0-9]+');
Route::get('defineBank/delete',array('as' => 'admin.deleteDefineBank','uses' => Admin.'\AdminDefineBankController@deleteItem'));
Route::post('defineBank/ajaxLoad', array('as' => 'admin.ajaxDefineBank','uses' => Admin.'\AdminDefineBankController@ajaxLoadForm'));

/*thông tin tài khoản*/
Route::match(['GET','POST'],'user/view', array('as' => 'admin.user_view','uses' => Admin.'\AdminUserController@view'));
Route::get('user/edit/{id}',array('as' => 'admin.user_edit','uses' => Admin.'\AdminUserController@editInfo'));
Route::post('user/edit/{id}',array('as' => 'admin.user_edit','uses' => Admin.'\AdminUserController@edit'));
Route::get('user/profile',array('as' => 'admin.user_profile','uses' => Admin.'\AdminUserController@getProfile'));
Route::post('user/profile',array('as' => 'admin.user_profile','uses' => Admin.'\AdminUserController@postProfile'));
Route::get('user/change/{id}',array('as' => 'admin.user_change','uses' => Admin.'\AdminUserController@changePassInfo'));
Route::post('user/change/{id}',array('as' => 'admin.user_change','uses' => Admin.'\AdminUserController@changePass'));
Route::post('user/remove/{id}',array('as' => 'admin.user_remove','uses' => Admin.'\AdminUserController@remove'));
Route::get('user/getInfoSettingUser', array('as' => 'admin.getInfoSettingUser','uses' => Admin.'\AdminUserController@getInfoSettingUser'));//ajax
Route::post('user/submitInfoSettingUser', array('as' => 'admin.submitInfoSettingUser','uses' => Admin.'\AdminUserController@submitInfoSettingUser'));//ajax
//quan lý nhân viên cấp dưới
Route::match(['GET','POST'],'employee/view', array('as' => 'admin.viewEmployee','uses' => Admin.'\AdminUserController@viewEmployee'));
Route::get('employee/edit/{id}',array('as' => 'admin.employeeEdit','uses' => Admin.'\AdminUserController@getEmployee'));
Route::post('employee/edit/{id}',array('as' => 'admin.employeeEdit','uses' => Admin.'\AdminUserController@postEmployee'));

/*thông tin quyền*/
Route::match(['GET','POST'],'permission/view',array('as' => 'admin.permission_view','uses' => Admin.'\AdminPermissionController@view'));
Route::get('permission/addPermiss',array('as' => 'admin.addPermiss','uses' => Admin.'\AdminPermissionController@addPermiss'));
Route::get('permission/create',array('as' => 'admin.permission_create','uses' => Admin.'\AdminPermissionController@createInfo'));
Route::post('permission/create',array('as' => 'admin.permission_create','uses' => Admin.'\AdminPermissionController@create'));
Route::get('permission/edit/{id}',array('as' => 'admin.permission_edit','uses' => Admin.'\AdminPermissionController@editInfo'))->where('id', '[0-9]+');
Route::post('permission/edit/{id}',array('as' => 'admin.permission_edit','uses' => Admin.'\AdminPermissionController@edit'))->where('id', '[0-9]+');
Route::post('permission/deletePermission', array('as' => 'admin.deletePermission','uses' => Admin.'\AdminPermissionController@deletePermission'));//ajax

/*thông tin nhóm quyền*/
Route::match(['GET','POST'],'groupUser/view',array('as' => 'admin.groupUser_view','uses' => Admin.'\AdminGroupUserController@view'));
Route::get('groupUser/create',array('as' => 'admin.groupUser_create','uses' => Admin.'\AdminGroupUserController@createInfo'));
Route::post('groupUser/create',array('as' => 'admin.groupUser_create','uses' => Admin.'\AdminGroupUserController@create'));
Route::get('groupUser/edit/{id?}',array('as' => 'admin.groupUser_edit','uses' => Admin.'\AdminGroupUserController@editInfo'))->where('id', '[0-9]+');
Route::post('groupUser/edit/{id?}',array('as' => 'admin.groupUser_edit','uses' => Admin.'\AdminGroupUserController@edit'))->where('id', '[0-9]+');
Route::post('groupUser/remove/{id}',array('as' => 'admin.groupUser_remove','uses' => Admin.'\AdminGroupUserController@remove'));

/*thông tin quyền theo role */
Route::get('groupUser/viewRole',array('as' => 'admin.viewRole','uses' => Admin.'\AdminGroupUserController@viewRole'));
Route::get('groupUser/editRole/{id?}', array('as' => 'admin.editRole','uses' => Admin.'\AdminGroupUserController@getRole'));
Route::post('groupUser/editRole/{id?}', array('as' => 'admin.editRole','uses' => Admin.'\AdminGroupUserController@postRole'));
Route::post('groupUser/deleteGroupRole', array('as' => 'admin.deleteGroupRole','uses' => Admin.'\AdminGroupUserController@deleteGroupRole'));

/*thông tin role */
Route::get('role/view',array('as' => 'admin.roleView','uses' => Admin.'\AdminRoleController@view'));
Route::post('role/addRole/{id?}',array('as' => 'admin.addRole','uses' => Admin.'\AdminRoleController@addRole'));
Route::get('role/deleteRole',array('as' => 'admin.deleteRole','uses' => Admin.'\AdminRoleController@deleteRole'));
Route::post('role/ajaxLoadForm',array('as' => 'admin.loadForm','uses' => Admin.'\AdminRoleController@ajaxLoadForm'));

/*thông tin menu */
Route::get('menu/view',array('as' => 'admin.menuView','uses' => Admin.'\AdminManageMenuController@view'));
Route::get('menu/edit/{id?}', array('as' => 'admin.menuEdit','uses' => Admin.'\AdminManageMenuController@getItem'));
Route::post('menu/edit/{id?}', array('as' => 'admin.menuEdit','uses' => Admin.'\AdminManageMenuController@postItem'));
Route::post('menu/deleteMenu', array('as' => 'admin.deleteMenu','uses' => Admin.'\AdminManageMenuController@deleteMenu'));//ajax/
Route::post('menu/ajaxGetOptionParent', array('as' => 'admin.ajaxGetOptionParent','uses' => Admin.'\AdminManageMenuController@ajaxGetOptionParent'));//ajax

//Career
Route::match(['GET','POST'],'career', array('as' => 'admin.careerView','uses' => Admin.'\AdminCareerController@view'));
Route::post('career/post/{id?}', array('as' => 'admin.careerEdit','uses' => Admin.'\AdminCareerController@postItem'))->where('id', '[0-9]+');
Route::get('career/delete',array('as' => 'admin.deleteCareer','uses' => Admin.'\AdminCareerController@deleteItem'));
Route::post('career/ajaxLoad', array('as' => 'admin.ajaxCareer','uses' => Admin.'\AdminCareerController@ajaxLoadForm'));

//Version App
Route::match(['GET','POST'],'version_app', array('as' => 'admin.versionAppView','uses' => Admin.'\AdminVersionAppController@view'));
Route::post('version_app/post/{id?}', array('as' => 'admin.versionAppEdit','uses' => Admin.'\AdminVersionAppController@postItem'))->where('id', '[0-9]+');
//Route::get('version_app/delete',array('as' => 'admin.deleteCareer','uses' => Admin.'\AdminCareerController@deleteItem'));
Route::post('version_app/ajaxLoad', array('as' => 'admin.ajaxVersionAppCareer','uses' => Admin.'\AdminVersionAppController@ajaxLoadForm'));

//Relationship
Route::match(['GET','POST'],'relationships', array('as' => 'admin.relationshipsView','uses' => Admin.'\AdminRelationshipController@view'));
Route::post('relationships/post/{id?}', array('as' => 'admin.relationshipsEdit','uses' => Admin.'\AdminRelationshipController@postItem'))->where('id', '[0-9]+');
Route::get('relationships/delete',array('as' => 'admin.deleteRelationships','uses' => Admin.'\AdminRelationshipController@deleteItem'));
Route::post('relationships/ajaxLoad', array('as' => 'admin.ajaxRelationships','uses' => Admin.'\AdminRelationshipController@ajaxLoadForm'));

//*thông tin banner */
Route::match(['GET','POST'],'banner',array('as' => 'admin.bannerView','uses' => Admin.'\AdminBannersController@view'));
Route::get('banner/edit/{id?}', array('as' => 'admin.bannerEdit','uses' => Admin.'\AdminBannersController@getItem'));
Route::post('banner/edit/{id?}', array('as' => 'admin.bannerEdit','uses' => Admin.'\AdminBannersController@postItem'));
Route::post('banner/deleteBanner', array('as' => 'admin.deleteBanner','uses' => Admin.'\AdminBannersController@deleteBanner'));//ajax

//*thông tin product */
Route::match(['GET','POST'],'product',array('as' => 'admin.productView','uses' => Admin.'\AdminProductsController@view'));
Route::get('product/edit/{id?}', array('as' => 'admin.productEdit','uses' => Admin.'\AdminProductsController@getItem'));
Route::post('product/edit/{id?}', array('as' => 'admin.productEdit','uses' => Admin.'\AdminProductsController@postItem'));
Route::post('product/deleteProduct', array('as' => 'admin.deleteProduct','uses' => Admin.'\AdminProductsController@deleteProduct'));//ajax
Route::post('product/activeProduct', array('as' => 'admin.activeProduct','uses' => Admin.'\AdminProductsController@activeProduct'));//ajax


//Literacy
Route::match(['GET','POST'],'literacy', array('as' => 'admin.literacyView','uses' => Admin.'\AdminLiteracyController@view'));
Route::post('literacy/post/{id?}', array('as' => 'admin.literacyEdit','uses' => Admin.'\AdminLiteracyController@postItem'))->where('id', '[0-9]+');
Route::get('literacy/delete',array('as' => 'admin.deleteLiteracy','uses' => Admin.'\AdminLiteracyController@deleteItem'));
Route::post('literacy/ajaxLoad', array('as' => 'admin.ajaxLiteracy','uses' => Admin.'\AdminLiteracyController@ajaxLoadForm'));

//Purpose
Route::match(['GET','POST'],'purpose', array('as' => 'admin.purposeView','uses' => Admin.'\AdminPurposeController@view'));
Route::post('purpose/post/{id?}', array('as' => 'admin.purposeEdit','uses' => Admin.'\AdminPurposeController@postItem'))->where('id', '[0-9]+');
Route::get('purpose/delete',array('as' => 'admin.deletePurpose','uses' => Admin.'\AdminPurposeController@deleteItem'));
Route::post('purpose/ajaxLoad', array('as' => 'admin.ajaxPurpose','uses' => Admin.'\AdminPurposeController@ajaxLoadForm'));

//*thông tin notification */
Route::match(['GET','POST'],'notification',array('as' => 'admin.notificationView','uses' => Admin.'\AdminNotificationController@view'));

//Document Type
Route::match(['GET','POST'],'document_entity_attribute', array('as' => 'admin.documentEntityAttributeView','uses' => Admin.'\AdminDocumentEntityAttributeController@view'));
Route::post('document_entity_attribute/post/{id?}', array('as' => 'admin.documentEntityAttributeEdit','uses' => Admin.'\AdminDocumentEntityAttributeController@postItem'))->where('id', '[0-9]+');
Route::get('document_entity_attribute/post/{id?}', array('as' => 'admin.documentEntityAttributeEdit','uses' => Admin.'\AdminDocumentEntityAttributeController@getItem'))->where('id', '[0-9]+');

//Document Type
Route::match(['GET','POST'],'document_type', array('as' => 'admin.documentTypeView','uses' => Admin.'\AdminDocumentTypeController@view'));
Route::post('document_type/post/{id?}', array('as' => 'admin.documentTypeEdit','uses' => Admin.'\AdminDocumentTypeController@postItem'))->where('id', '[0-9]+');
Route::get('document_type/post/{id?}', array('as' => 'admin.documentTypeEdit','uses' => Admin.'\AdminDocumentTypeController@getItem'))->where('id', '[0-9]+');

//option commission
Route::match(['GET','POST'],'option_commission', array('as' => 'admin.optionCommissionView','uses' => Admin.'\AdminOptionCommissionController@view'));
Route::post('option_commission/post/{id?}', array('as' => 'admin.optionCommissionEdit','uses' => Admin.'\AdminOptionCommissionController@postItem'))->where('id', '[0-9]+');
Route::get('option_commission/post/{id?}', array('as' => 'admin.optionCommissionEdit','uses' => Admin.'\AdminOptionCommissionController@getItem'))->where('id', '[0-9]+');

//Career lender
Route::match(['GET','POST'],'lender_career', array('as' => 'admin.lenderCareerView','uses' => Admin.'\AdminLenderCareerController@view'));
Route::post('lender_career/post/{id?}', array('as' => 'admin.lenderCareeEdit','uses' => Admin.'\AdminLenderCareerController@postItem'))->where('id', '[0-9]+');
Route::get('lender_career/delete',array('as' => 'admin.deleteLenderCareer','uses' => Admin.'\AdminLenderCareerController@deleteItem'));
Route::post('lender_career/ajaxLoad', array('as' => 'admin.ajaxLenderCareer','uses' => Admin.'\AdminLenderCareerController@ajaxLoadForm'));

// User Loan Log - Lich su chia YCV
Route::match(['GET','POST'], 'loan_logs', array('as' => 'admin.loanLogsView', 'uses' => Admin.'\AdminUserLoanLogController@view'));

// SMS Log - Lich su sms
Route::match(['GET','POST'], 'sms_logs', array('as' => 'admin.smsLogsView', 'uses' => Admin.'\AdminSMSLogController@view'));

// Content Notification - Cau hinh noi dung thong bao
Route::match(['GET','POST'], 'content_notify', array('as' => 'admin.contentNotifyView', 'uses' => Admin.'\AdminContentNotifyController@view'));
Route::get('content_notify/edit/{id?}', array('as' => 'admin.contentNotifyEdit', 'uses' => Admin.'\AdminContentNotifyController@getItem'));
Route::post('content_notify/edit/{id?}', array('as' => 'admin.contentNotifyEdit', 'uses' => Admin.'\AdminContentNotifyController@postItem'));
Route::post('content_notify/deleteContentNotify', array('as' => 'admin.contentNotifyDelete', 'uses' => Admin.'\AdminContentNotifyController@deleteContentNotifications'));
Route::post('content_notify/ajax_lock_or_active_content_notify', array('as' => 'admin.ajaxLockOrActiveContentNotify', 'uses' => Admin.'\AdminContentNotifyController@ajaxlockOrActiveContentNotifications'));
Route::post('content_notify/ajaxSend', array('as' => 'admin.ajaxContentNotify','uses' => Admin.'\AdminContentNotifyController@ajaxSendNotificationMultiLoaner'));

# Route for config using provider sms
Route::any('config-provider',           array('as' => 'admin.configProvider',   'uses' => Admin.'\AdminConfigProviderController@view'));
Route::post('config-provider/store',    array('as' => 'admin.providerStore',    'uses' => Admin.'\AdminConfigProviderController@postItem'));
Route::post('config-provider/put',      array('as' => 'admin.providerAjax',     'uses' => Admin.'\AdminConfigProviderController@postAjax'));

//*thông tin reminder debt */
Route::match(['GET','POST'],'reminder_debt',array('as' => 'admin.reminderDebtView','uses' => Admin.'\AdminReminderDebtController@view'));
Route::get('reminder_debt/edit/{id?}', array('as' => 'admin.reminderDebtEdit','uses' => Admin.'\AdminReminderDebtController@getItem'));
Route::post('reminder_debt/edit/{id?}', array('as' => 'admin.reminderDebtEdit','uses' => Admin.'\AdminReminderDebtController@postItem'));
Route::post('reminder_debt/deleteBanner', array('as' => 'admin.deleteReminderDebt','uses' => Admin.'\AdminReminderDebtController@deleteBanner'));//ajax

// User phone stringee call
Route::match(['GET','POST'],'user_phone_stringee_call', array('as' => 'admin.userPhoneStringeeCallView','uses' => Admin.'\AdminUserPhoneStringeeCallController@view'));
Route::post('user_phone_stringee_call/post/{id?}', array('as' => 'admin.userPhoneStringeeCallEdit','uses' => Admin.'\AdminUserPhoneStringeeCallController@postItem'))->where('id', '[0-9]+');
Route::get('user_phone_stringee_call/delete',array('as' => 'admin.deleteuserPhoneStringeeCall','uses' => Admin.'\AdminUserPhoneStringeeCallController@deleteItem'));
Route::post('user_phone_stringee_call/ajaxLoad', array('as' => 'admin.ajaxUserPhoneStringeeCall','uses' => Admin.'\AdminUserPhoneStringeeCallController@ajaxLoadForm'));

/** Log Call Stringee by danghung111 */
Route::any('log/call',array('as' => 'logCallView','uses' => Admin.'\LogCallController@view'));
Route::get('log/call/searchStringee',array('as' => 'logCallSearchStringee','uses' => LogCall.'\LogCallController@view'));
Route::get('log/callRecordsFile',array('as' => 'logCallCallRecordsFile','uses' => Admin.'\LogCallController@callRecordsFile'));
Route::get('log/callRecordsFile/{id?}',array('as' => 'logCallCallRecordsFileItem','uses' => Admin.'\LogCallController@callRecordsFileItem'));

Route::post('log/ajaxLogsCall',array('as' => 'ajaxLogsCall','uses' => Admin.'\LogCallController@ajaxLogsCall'));
Route::post('log/ajaxLogsCallTime',array('as' => 'ajaxLogsCallTime','uses' => Admin.'\LogCallController@ajaxLogsCallTime'));
Route::post('log/ajaxLogsCallAnswer',array('as' => 'ajaxLogsCallAnswer','uses' => Admin.'\LogCallController@ajaxLogsCallAnswer'));

Route::group(['prefix' => 'stringee'], function () {
    Route::get('getGroupList', array('as' => 'stringee.getGroupList','uses' => Admin.'\StringeeCenterApiController@getGroupList'));
    Route::get('getGroupList/{groupId}', array('as' => 'stringee.getGroupListID','uses' => Admin.'\StringeeCenterApiController@getGroupList'));
    Route::post('updateNameGroup', array('as' => 'stringee.updateNameGroup','uses' => Admin.'\StringeeCenterApiController@updateNameGroup'));
    Route::post('createNameGroup', array('as' => 'stringee.createNameGroup','uses' => Admin.'\StringeeCenterApiController@createNameGroup'));
    Route::post('deleteGroup', array('as' => 'stringee.deleteGroup','uses' => Admin.'\StringeeCenterApiController@deleteGroup'));
    Route::post('ajaxChangeStatusAgent', array('as' => 'stringee.ajaxChangeStatusAgent','uses' => Admin.'\StringeeCenterApiController@ajaxChangeStatusAgent'));
    Route::post('ajaxCreateAgent', array('as' => 'stringee.ajaxCreateAgent','uses' => Admin.'\StringeeCenterApiController@ajaxCreateAgent'));
    Route::post('ajaxAddAgentToGroup', array('as' => 'stringee.ajaxAddAgentToGroup','uses' => Admin.'\StringeeCenterApiController@ajaxAddAgentToGroup'));
    Route::post('deleteAgent', array('as' => 'stringee.deleteAgent','uses' => Admin.'\StringeeCenterApiController@deleteAgent'));
    Route::post('agentDeleteInGroup', array('as' => 'stringee.agentDeleteInGroup','uses' => Admin.'\StringeeCenterApiController@agentDeleteInGroup'));
    Route::get('popupAnswerAgent', array('as' => 'stringee.popupAnswerAgent','uses' => Admin.'\StringeeCenterApiController@popupAnswerAgent'));

    Route::get('permissionStringeeCall', array('as' => 'stringee.permissionStringeeCall','uses' => Admin.'\UsersPermissionStringeeCallController@view'));
    Route::post('permissionStringeeCall', array('as' => 'stringee.permissionStringeeCall','uses' => Admin.'\UsersPermissionStringeeCallController@doEdit'));
});
