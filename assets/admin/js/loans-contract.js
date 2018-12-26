$(document).ready(function () {
    var lng;
    Admin.setLang();
    LOANS_CONTRACT.ajaxIndexLoadTab('.listTabsLoansContract .tab-toggle');
});

LOANS_CONTRACT = {
    ajaxIndexLoadTab:function(element_click){
        $(element_click).click(function(){
            var _token = $('input[name="_token"]').val();
            var loan_id = $('#loan_id').val();
            var contract_id = $('#id_hidden').val();
            var function_action = $(this).attr('data-function-action');
            var tab = $(this).attr('data-tab');
            var url = WEB_ROOT + '/manager/loanContracts/ajaxIndexLoadTab';
            var check_content_tab =  $('#'+tab).html();
            //if(check_content_tab == '') {
                $('#loadingAjax').show();
                if (loan_id > 0 && _token != '') {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {loan_id: loan_id, contract_id:contract_id, function_action: function_action, _token: _token},
                        dataType: 'json',
                        success: function (res) {
                            $('#loadingAjax').hide();
                            if (res != '') {
                                $('#' + tab).html(res.html);
                                LOANS_CONTRACT.clickPagingAjax('#'+tab, function_action);
                                if(function_action == '_ajaxGetLoansDocument'){
                                    LOANS_CONTRACT.openLoanPopupLoadTab();
                                }
                            }
                        }
                    });
                }
            //}
        });
    },
    clickPagingAjax:function(data_tab, function_action){
        $('.pagination a').click(function(e){
            var loan_id = $('#loan_id').val();
            var contract_id = $('#id_hidden').val();
            var page_no = $(this).attr('href').split('page_no=')[1];
            LOANS_CONTRACT.getPagingAjax(page_no, loan_id, contract_id, data_tab, function_action);
            e.preventDefault();
            return false;
        });
    },
    getPagingAjax:function(page, loan_id, contract_id, data_tab, function_action){
        $('#loadingAjax').show();
        $.ajax({
            type: "GET",
            url:WEB_ROOT + '/manager/loanContracts/ajaxIndexLoadTab',
            data: {page_no: page, loan_id: loan_id, contract_id:contract_id, function_action: function_action},
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
            $('#viewDocumentType .modal-title').html(title);
            if(id > 0){
                $('#loadingAjax').show();
                var url = WEB_ROOT + '/manager/loanContracts/get-document-entity-attribute-value';
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