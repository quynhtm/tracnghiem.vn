$(document).ready(function () {
    var lng;
    Admin.setLang();

    LOANER.updateField('.selectUpdateField');
    LOANER.ajaxIndexLoadTab('.listTabsLoaners .tab-toggle','/manager/loaner/ajaxIndexLoadTab');
    LOANER.ajaxIndexLoadTab('.listTabsRepayments .tab-toggle','/manager/repayment/ajaxIndexLoadTab');
    LOANER.btnSaveLoanView();
    LOANER.btnLock();
    LOANER.btnUnlockLoaner();
});

LOANER = {
    updateField:function(element_click){
        var _token = $('input[name="_token"]').val();
        var loaner_id = $('#id_hiden').val();
        $(element_click).change(function(){
            var name_field = $(this).attr('name');
            var _data = $(this).val();
            var urlUpdateField = WEB_ROOT + '/manager/loaner/ajaxUpdateField';
            $('#loadingAjax').show();
            if(loaner_id > 0 && _token != ''){
                $.ajax({
                    type: "POST",
                    url: urlUpdateField,
                    data: {loaner_id:loaner_id, name_field:name_field, value_field:_data, _token:_token},
                    success: function(data){
                        $('#loadingAjax').hide();
                        if(data != ''){
                            console.log(data);
                        }
                    }
                });
            }
        });
    },
    ajaxIndexLoadTab:function(element_click,url_define){
        $(element_click).click(function(){
            var _token = $('input[name="_token"]').val();
            var loaner_id = $('#id_hiden').val();
            var function_action = $(this).attr('data-function-action');
            var tab = $(this).attr('data-tab');
            var url = WEB_ROOT + url_define;
            var check_content_tab =  $('#'+tab).html();
            if(check_content_tab == '') {
                $('#loadingAjax').show();
                if (loaner_id > 0 && _token != '') {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {loaner_id: loaner_id, function_action: function_action, _token: _token},
                        dataType: 'json',
                        success: function (res) {
                            $('#loadingAjax').hide();
                            if (res != '') {
                                $('#' + tab).html(res.html);
                                LOANER.clickPagingAjax('#'+tab, function_action);
                                if(function_action == '_ajaxGetLoanerDocument'){
                                    LOANER.openLoanPopupLoadTab();
                                }
                            }
                        }
                    });
                }
            }
        });
    },
    clickPagingAjax:function(data_tab, function_action){
        $('.pagination a').click(function(e){
            var loaner_id = $('#id_hiden').val();
            var page_no = $(this).attr('href').split('page_no=')[1];
            LOANER.getPagingAjax(page_no, loaner_id, data_tab, function_action);
            e.preventDefault();
            return false;
        });
    },
    getPagingAjax:function(page, loaner_id, data_tab, function_action){
        $('#loadingAjax').show();
        $.ajax({
            type: "GET",
            url:WEB_ROOT + '/manager/loaner/ajaxIndexLoadTab',
            data: {page_no: page, loaner_id: loaner_id,  function_action: function_action},
            dataType: 'json',
            success: function (res) {
                $('#loadingAjax').hide();
                $(data_tab).html(res.html);
            }
        });
    },
    btnSaveLoanView:function(){
        $('#btnSaveLoanView').click(function(){
            var _this = $(this);
            if(_this.hasClass('act')){
                _this.removeClass('act');
                $('.toggleSaveLoaner').find('input').attr('disabled');
                $('.toggleSaveLoaner').find('select').attr('disabled');
                $('.detailLoaners').find('input').attr('disabled');
                $('.detailLoaners').find('select').attr('disabled');

                $('.actionCancel').hide();
                $('.facebook').find('input').hide();
                $('.facebook').find('a').show();
                var valid = true;
                $('.btnSaveLoanView input').each(function () {
                    var _input = $(this);
                    if(_input.hasClass("input-required") && _input.val() == '') {
                        _input.addClass('error');
                        valid = false;
                    }
                });
                if(valid){
                    $('form.btnSaveLoanView').submit();
                }else{
                    $('.actionCancel').show();
                }
            }else{
                _this.addClass('act');
                $('.toggleSaveLoaner').find('input').removeAttr('disabled');
                $('.toggleSaveLoaner').find('select').removeAttr('disabled');
                $('.detailLoaners').find('input').removeAttr('disabled');
                $('.detailLoaners').find('select').removeAttr('disabled');

                $('.facebook').find('input').show();
                $('.facebook').find('a').hide();
                _this.find('span').text(lng['text_update']);
                $('.actionCancel').show();
            }
        });
        $('.actionCancel').click(function(){
            $('#btnSaveLoanView').removeClass('act');
            $('#btnSaveLoanView').find('span').text(lng['text_sua']);
            $('.toggleSaveLoaner').find('input').attr('disabled', 'disabled');
            $('.toggleSaveLoaner').find('select').attr('disabled', 'disabled');
            $('.detailLoaners').find('input').attr('disabled', 'disabled');
            $('.detailLoaners').find('select').attr('disabled', 'disabled');

            $('.facebook').find('input').hide();
            $('.facebook').find('a').show();

            $(this).hide();
        });
        return false;
    },
    btnLock:function(){
        $('#btnLock').click(function(){
            var loaner_reson = $('#loaner_reson').val();
            var valid=true;
            if(loaner_reson == ''){
                $('#loaner_reson').addClass('error');
                valid = false;
            }
            if(valid){
                $('#lockLoaner').submit();
            }else{
                return false;
            }
        });
    },
    btnUnlockLoaner:function(){
        $('#btnUnlock').click(function(){
            var r = confirm(lng['alert_unlock_loaner']);
            if(r){
                $('#formUnlock').submit();
            }
            return false;
        });
    },
    openLoanPopupLoadTab:function(){
        $('.viewDocumentType').click(function(){
            var _token = $('input[name="_token"]').val();
            var title = $(this).attr('data-title');
            var id = $(this).attr('data-id');
            $('#viewDocumentType .modal-title').html(title);
            if(id > 0){
                $('#loadingAjax').show();
                var url = WEB_ROOT + '/manager/loaner/get-document-entity-attribute-value';
                $('.viewDocumentTypeContent').html('');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {id: id, _token: _token},
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
}