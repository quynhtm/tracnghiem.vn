$(document).ready(function () {
    var lng;
    Admin.setLang();

    LOANS.ajaxIndexLoadTab('.listTabsLoans .tab-toggle');
    LOANS.actionHuy();
    LOANS.actionSendNotiLoan();
    LOANS.actionDuyetLoan();
    LOANS.btnLoanSave();
    LOANS.btnActionNotify();
    LOANS.calculateFromTotal();
    LOANS.loadTabLoanList('.listTabsLoanAtView .tab-toggle');

    LOANS.btnApproveTransRefuseList();
    LOANS.selectAsignLoan();
    LOANS.btnNhanYCV();
});

LOANS = {
    ajaxIndexLoadTab:function(element_click){
        $(element_click).click(function(){
            var _token = $('input[name="_token"]').val();
            var loan_id = $('#id_hiden').val();
            var function_action = $(this).attr('data-function-action');
            var tab = $(this).attr('data-tab');
            var url = WEB_ROOT + '/manager/loans/ajaxIndexLoadTab';
            var check_content_tab =  $('#'+tab).html();
            //if(check_content_tab == '') {
                $('#loadingAjax').show();
                if (loan_id > 0 && _token != '') {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {loan_id: loan_id, function_action: function_action, _token: _token},
                        dataType: 'json',
                        success: function (res) {
                            $('#loadingAjax').hide();
                            if (res != '') {
                                $('#' + tab).html(res.html);
                                LOANS.clickPagingAjax('#'+tab, function_action);
                                LOANS.openLoanPopupLoadTab();
                            }
                        }
                    });
                }
            //}
        });
    },
    loadTabLoanList:function(element_click){
        $(element_click).click(function(){
            $('#loadingAjax').show();
            var function_action = $(this).attr('data-function-action');
            window.location.href = function_action;
        });
    },
    clickPagingAjax:function(data_tab, function_action){
        $('.pagination a').click(function(e){
            var loan_id = $('#id_hiden').val();
            var page_no = $(this).attr('href').split('page_no=')[1];
            LOANS.getPagingAjax(page_no, loan_id, data_tab, function_action);
            e.preventDefault();
            return false;
        });
    },
    getPagingAjax:function(page, loan_id, data_tab, function_action){
        $('#loadingAjax').show();
        $.ajax({
            type: "GET",
            url:WEB_ROOT + '/manager/loans/ajaxIndexLoadTab',
            data: {page_no: page, loan_id: loan_id,  function_action: function_action},
            dataType: 'json',
            success: function (res) {
                $('#loadingAjax').hide();
                $(data_tab).html(res.html);
            }
        });
    },
    openLoanPopupLoadTab:function(){
        $('.viewDocumentType').click(function(){
            var _token = $('input[name="_token"]').val();
            var title = $(this).attr('data-title');
            var id = $(this).attr('data-id');
            var loan_id = $('#id_hiden').val();
            var loaner_id = $('#id_hiden_loaner').val();
            $('#viewDocumentType .modal-title').html(title);
            if(id > 0){
                $('#loadingAjax').show();
                var url = WEB_ROOT + '/manager/document-entity/get-document-entity-attribute-value';
                $('.viewDocumentTypeContent').html('');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {id: id, loan_id:loan_id, loaner_id:loaner_id, _token: _token},
                    dataType: 'json',
                    success: function (res) {
                        $('#loadingAjax').hide();
                        if (res != '') {
                            $('.viewDocumentTypeContent').html(res.html);
                        }
                    }
                });
            }
        });
    },
    actionHuy:function(){
        $('.actionHuy').click(function(){
            var title = $(this).attr('data-title');
            $('#actionHuy .modal-title').text(title);
        });
    },
    actionSendNotiLoan:function(){
        $('#actionSendNotiLoan').click(function(){
            var mess = $('#sendNotiHandMade .message').val();
            if(mess == ''){
                $('#sendNotiHandMade .message').addClass('error');
                return false;
            }
        });
    },
    actionDuyetLoan:function(){
        $('.actionDuyetLoan').click(function(){
            var title = $(this).attr('title');
            var r = confirm(lng['alert_gui_duyet_loan']+title);
            if(r){
                $(this).parents('form').submit();
            }
        });
    },
    actionEditDocumentSave:function(){
        $('#actionEditDocumentSave').click(function(){
            var r = confirm("Bạn chắc chắn muốn lưu hồ sơ!");
            if(r){
                if(r){
                    var arrItem = {};
                    $('.oneSelectStatus').each(function(){
                        var _this = $(this);
                        var _id = _this.attr('data-id');
                        var _status = _this.val();
                        arrItem[_id] = _status;
                    });
                    var len = LOANS.checkLeng(arrItem);
                    if(len > 0){
                        arrItem['_token'] = $('input[name="_token"]').val();
                        arrItem['loan_id'] = $('#id_hiden').val();
                        var strQuery = jQuery.param(arrItem);
                        $('#loadingAjax').show();
                        $.ajax({
                            type: "POST",
                            url: WEB_ROOT+"/manager/loan/documentUpdateStatus",
                            data: strQuery,
                            success: function(data){
                                $('#loadingAjax').hide();
                                window.location.reload();
                            }
                        });
                    }else{
                        alert('Vui lòng chọn ít nhất 1 mã hồ sơ để sửa!');
                    }
                }
            }
        });
    },
    checkLeng:function(obj){
        var L=0;
        $.each(obj, function(i, elem) {
            L++;
        });
        return L;
    },
    btnLoanSave:function(){
        $('.actionSave').click(function(){
            var _this = $(this);
            if(_this.hasClass('act')){
                _this.removeClass('act');
                $('.toggleSaveShow').removeClass('act');
                $('.saveLoanerFromLoan').submit();
                $('.actionCancel').hide();
            }else{
                _this.addClass('act');
                $('.toggleSaveShow').addClass('act');
                _this.text(lng['text_update']);
                $('.actionCancel').show();
            }
        });
        $('.actionCancel').click(function(){
            $('.toggleSaveShow').removeClass('act');
            $('.actionSave').removeClass('act').text(lng['text_sua']);
            $(this).hide();
        });
    },
    btnActionNotify:function(){
        $('.btnActionNotify').click(function(){
            var loan_id = $(this).attr('data-id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: "POST",
                url: WEB_ROOT+"/manager/loan/getMessageNotify",
                data: {loan_id:loan_id, _token:_token},
                success: function(data){
                    if(data != ''){
                        $('#messageNotify').val(JSON.parse(data));
                    };
                }
            });
        });
    },

    ntnToRate:function(val){
        var normal_rate = val / 1000000 * 360 * 100;
        return parseFloat(normal_rate).toFixed(0);
    },
    rateToNTN:function(val){
        var rate_ntn = val * 1000000 / 360 / 100;
        return parseFloat(rate_ntn).toFixed(0);
    },
    calculateFromTotal:function(){
        var fee_rate = $('#fee_rate').val();
        var ensure_rate = $('#ensure_rate').val();
        var interest_rate = $('#interest_rate').val();
        $('#total_rate').val(LOANS.rateToNTN(parseFloat(fee_rate) + parseFloat(ensure_rate)));
        $('#total_rate').bind("change keyup", function () {
            var total_rate = $('#total_rate').val();
            var rate = LOANS.ntnToRate(total_rate);
            total_rate = parseFloat(rate).toFixed(3);
            ensure_rate = total_rate - fee_rate;
            $('#ensure_rate').val(ensure_rate)
        });
    },

    btnApproveTransRefuseList:function(){
        $('.btnApproveTransRefuseList').click(function(){
            var total = jQuery(".userApproveRefuseLoanList input.check:checked" ).length;
            var title = $(this).text();
            var type = $(this).attr('data');
            if(total==0){
                jAlert('Vui lòng chọn ít nhất 1 YCV!', 'Thông báo');
                return false;
            }else{
                jConfirm('Bạn muốn '+title+' [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
                    if(r){
                        $('.type').val(type);
                        $('form.userApproveRefuseLoanList').submit();
                        return true;
                    }
                });
            }
        });
    },
    selectAsignLoan:function(){
        $('.btnApproveTransRefuseListAssign').click(function(){
            var type = $(this).attr('data');
            $('.type').val(type);
        });

        $('#btnAgreeApproveTransRefuseListAssign').click(function(){
            var assign = $('#popupApproveTransRefuseListAssign .assign').val();
            if(assign != undefined && assign > 0){
                $('.userAssign').val(assign);
                var total = $('.userApproveRefuseLoanList .check:checked').length;
                if(total != undefined && total > 0){
                    $('form.userApproveRefuseLoanList').submit();
                    return true;
                }else{
                    $('.userAssign').val(0);
                    jAlert('Vui lòng chọn ít nhất 1 YCV để chuyển!', 'Thông báo');
                    return false;
                }
            }else{
                $('.userAssign').val(0);
                jAlert('Vui lòng chọn nhân viên để chuyển YCV!', 'Thông báo');
                return false;
            }
        });
    },
    btnNhanYCV:function(){
      $('.btnNhanYCV').click(function(){
          var total = jQuery(".userNhanYCVLoanList table tbody input.check:checked" ).length;
          if(total==0){
              jAlert('Vui lòng chọn ít nhất 1 YCV để nhận!', 'Thông báo');
              return false;
          }else{
              jConfirm('Bạn muốn nhận YCV [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
                  if(r){
                      $('form.userNhanYCVLoanList').submit();
                      return true;
                  }
              });
          }
      });
    },
    /**
     *QuynhTM add: check tài khoản NH
     * @param loan_id
     * @param verification
     * @param update_tknh
     */
    checkBankVimo: function (loan_id,verification,update_tknh) {
        if(loan_id > 0){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: "POST",
                url: WEB_ROOT+"/manager/loan/checkbankvimo",
                data: {loan_id:loan_id, _token:_token, verification:verification, update_tknh:update_tknh},
                success: function(res){
                    alert(res.msg);
                    window.location.reload();
                }
            });
        }
    }
}