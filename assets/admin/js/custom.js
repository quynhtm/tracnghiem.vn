jQuery.xhrPool = [];
jQuery.xhrPool.abortAll = function() {
    var requests = [];
    for (var index in this) {
        if (isFinite(index) === true) {
            requests.push(this[index]);
        }
    }
    for (index in requests) {
        requests[index].abort();
    }
};
jQuery.xhrPool.remove = function(jqXHR) {
    for (var index in this) {
        if (this[index] === jqXHR) {
            jQuery.xhrPool.splice(index, 1);
            break;
        }
    }
};
jQuery(document).ready(function(){
    jQuery(document).ajaxSend(function(event, jqXHR, options) {
        jQuery.xhrPool.push(jqXHR);
    });
    jQuery(document).ajaxComplete(function(event, jqXHR, options) {
        jQuery.xhrPool.remove(jqXHR);
    });
    jQuery.xhrPool.abortAll();
});
var AdminCustom = {
    init: function(options) {
        this.paging_ajax();
        this.search_ajax();
        this.tab_ajax();
    },
    /**
     * QuynhTM: trả nợ Nhà đầu tư
     * @param _itme
     */
    payDebtLender: function(lender_id,lender_contract_id){
        jQuery.xhrPool.abortAll();
        jQuery('div#payment-lender .lds-css.ng-scope').show();
        jQuery.ajax({
            type: "post",
            url: WEB_ROOT + '/manager/lender-contracts/payDebtLender',
            data: {_token: jQuery('[name="_token"]').val(), _ajax: 1, lender_id: lender_id, lender_contract_id: lender_contract_id},
            dataType: 'json',
            success: function (result) {
                jQuery('div#payment-lender .lds-css.ng-scope').hide();
                if (typeof result.status_text != 'undefined'){
                    jQuery('div#payment-lender').remove();
                    jQuery('div#lender-contract-status')
                        .removeAttr('class')
                        .addClass('col-sm-8')
                        .addClass(result.status_color)
                        .html(result.status_text);
                }
                alert(result.message);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                jQuery('div#payment-lender .lds-css.ng-scope').hide();
                alert('Error: ' + xhr.status + ' - ' + thrownError);
            }
        });
    },
    statusItem: function(_itme){
        if (typeof _itme.data('link') != 'undefined' && jQuery.trim(_itme.data('link')) != ''){
            jQuery.xhrPool.abortAll();
            _itme.parent().find('a').hide();
            _itme.parent().find('.img_loading').show();
            _itme.parents('tr').load(_itme.data('link'), {_token: jQuery('[name="_token"]').val(), _ajax: 1}, function(response, statusTxt, xhr){
                if(statusTxt != "success"){
                    _itme.parent().find('a').show();
                    _itme.parent().find('.img_loading').hide();
                    alert('Error: ' + xhr.status + ' - ' + statusTxt);
                }
            });
        }
    },
    deleteItem: function (_itme) {
        var _name = typeof _itme.data('name') != 'undefined' ? ': '+_itme.data('name') : ' ?';
        if (confirm('Bạn có muốn xóa bản ghi này không' + _name)) {
            if (typeof _itme.data('link') != 'undefined' && _itme.data('link') != '') {
                jQuery.xhrPool.abortAll();
                _itme.parent().find('a').hide();
                _itme.parent().find('.img_loading').show();
                jQuery.ajax({
                    type: "post",
                    url: _itme.data('link'),
                    data: {_token: jQuery('[name="_token"]').val()},
                    dataType: 'json',
                    success: function (response) {
                        alert(response.message);
                        if (response.success == 1){
                            _itme.parents('tr').remove();
                            AdminCustom.reload_ajax();
                        } else {
                            _itme.parent().find('a').show();
                            _itme.parent().find('.img_loading').hide();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        _itme.parent().find('a').show();
                        _itme.parent().find('.img_loading').hide();
                        alert('Error: ' + xhr.status + ' - ' + thrownError);
                    }
                });
            }
        }
    },
    reload_ajax: function(){
        jQuery.xhrPool.abortAll();
        jQuery('.lds-css.ng-scope').show();
        jQuery('html,body').animate({scrollTop: 0});
        jQuery('.load-content').load(jQuery(location).attr('href'), {_token: jQuery('[name="_token"]').val(), _ajax: 1}, function(response, statusTxt, xhr){
            jQuery('.lds-css.ng-scope').hide();

            if(statusTxt == "success"){
                AdminCustom.paging_ajax();
                AdminCustom.open_item();
            } else {
                alert('Error: ' + xhr.status + ' - ' + statusTxt);
            }
        });
    },
    paging_ajax: function() {
        jQuery('.paging-ajax').each(function(){
            var itme = jQuery(this);
            jQuery(this).find('ul.pagination li').not('.active').find('a').unbind('click').click(function(){
                jQuery.xhrPool.abortAll();
                itme.find('.lds-css.ng-scope').show();
                jQuery('html,body').animate({scrollTop: 0});
                itme.find('.load-content').load(jQuery(this).attr('href'), {_token: jQuery('[name="_token"]').val(), _ajax: 1}, function(response, statusTxt, xhr){
                    itme.find('.lds-css.ng-scope').hide();

                    if(statusTxt == "success"){
                        AdminCustom.paging_ajax();
                        AdminCustom.open_item();
                    } else {
                        alert('Error: ' + xhr.status + ' - ' + statusTxt);
                    }
                });

                return false;
            })
        });
    },
    search_ajax: function() {
        jQuery('.search-ajax').each(function(){
            var itme = jQuery(this);
            itme.find('button#reset').prop('disabled', true);
            itme.find('.form-control').keypress(function(event){
                var code = (event.keyCode ? event.keyCode : event.which);
                if(code == 13) {
                    itme.submit();
                    return false;
                }
            });

            itme.submit(function(){
                jQuery.xhrPool.abortAll();
                itme.parents('.page-content').find('.load-content').parent().find('.lds-css.ng-scope').show();
                jQuery('html,body').animate({scrollTop: 0});

                var serialize = itme.find('input, select, textarea').filter(function(index, element){return $(element).val() != ''}).serialize();
                if (serialize.replace(/&?[^=]+=&|&[^=]+=$/g, '') != '') itme.find('button#reset').prop('disabled', false);
                else itme.find('button#reset').prop('disabled', true);

                itme.parents('.page-content').find('.load-content').load(jQuery(this).attr('action'), itme.serialize() + '&_ajax=1', function(response, statusTxt, xhr){
                    itme.parents('.page-content').find('.load-content').parent().find('.lds-css.ng-scope').hide();
                    if(statusTxt == "success"){
                        AdminCustom.paging_ajax();
                        AdminCustom.open_item();
                    } else {
                        alert('Error: ' + xhr.status + ' - ' + statusTxt);
                    }
                });

                return false;
            });
        });
    },
    tab_ajax: function(first){
        jQuery('.tab-ajax a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var link = jQuery(this).data('link');
            var itme = jQuery(jQuery(this).attr('href'));
            if (typeof link != 'undefined' && jQuery.trim(link) != '' && itme.find('.load-content').is(':empty')){
                itme.find('.lds-css.ng-scope').show();
                itme.find('.load-content').load(link, {_token: jQuery('[name="_token"]').val(), _ajax: 1}, function(){
                    itme.find('.lds-css.ng-scope').hide();
                    AdminCustom.paging_ajax();
                });
            }
        });

        /** Load first tab **/
        if (typeof first != 'undefined' && first === 1) {
            jQuery('.tab-ajax a[data-toggle="tab"]').each(function(){
                if (jQuery(this).parent().hasClass('active')){
                    var link = jQuery(this).data('link');
                    var itme = jQuery(jQuery(this).attr('href'));
                    if (typeof link != 'undefined' && jQuery.trim(link) != '' && itme.find('.load-content').is(':empty')){
                        itme.find('.lds-css.ng-scope').show();
                        itme.find('.load-content').load(link, {_token: jQuery('[name="_token"]').val(), _ajax: 1}, function(){
                            itme.find('.lds-css.ng-scope').hide();
                            AdminCustom.paging_ajax();
                        });
                    }
                }
            });
        }
    },
    open_item: function () {
        jQuery('.detailView').unbind('dblclick').dblclick(function () {
            var url = jQuery(this).attr( "data-action" );
            window.open(url);
        });
    },
    auto_search: function(element) {
        element = jQuery(element);
        element.wrap('<div class="auto-search-wrap"></div>');
        element.after('<ul class="hidden"></ul>');
        element.after('<span class="fa fa-chevron-down"></span>');
        var parent = element.parent();

        jQuery(document).click(function(){
            parent.find('input').removeClass('show-list');
            parent.find('ul').addClass('hidden');
            parent.find('.fa').addClass('fa-chevron-down').removeClass('fa-chevron-up');
        });

        parent.find('.fa').click(function(){
            if (parent.find('ul').is(':visible')){
                parent.find('input').removeClass('show-list');
                parent.find('ul').addClass('hidden');
                jQuery(this).addClass('fa-chevron-down').removeClass('fa-chevron-up');
            } else {
                getResult(element);
            }
            return false;
        });

        parent.find('input.ajax-title').unbind('keyup').on('keyup', function(){setTimeout(function(){getResult(element)}, 100)});
        parent.find('ul').click(function(){return false;});
        parent.find('input.ajax-title').parent().find('.ajax-value').val('');

        function getResult(element){
            jQuery.xhrPool.abortAll();
            var parent = element.parent();
            parent.find('.fa').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            jQuery.ajax({
                url : element.data('link'),
                type : "get",
                data : {value : element.find('.ajax-title').val()},
                dataType:"json",
                success : function (result){
                    parent.find('ul').html('');
                    if (result.length > 0) {
                        var field1 = element.find('.ajax-title').data('field');
                        var field1 = jQuery.trim(field1) != '' ? field1.split(',') : [];
                        var field2 = element.find('.ajax-value').data('field');
                        var field2 = jQuery.trim(field2) != '' ? field2.split(',') : [];
                        var fields = field2.concat(field1);
                        var values = parent.find('.ajax-value').val();
                        var values = jQuery.trim(values) != '' ? values.split(',') : [];

                        jQuery.each(fields, function(key, val){fields[key] = jQuery.trim(val)});
                        jQuery.each(values, function(key, val){values[key] = jQuery.trim(val)});

                        for (var i = 0; i < result.length; i++){
                            var titles = [];
                            var selected = typeof result[i][fields[0]] != 'undefined' && in_array(parseInt(result[i][fields[0]]), values) ? 'selected' : '';
                            jQuery.each(fields, function (key, val) { if (key > 0 && typeof result[i][val] != 'undefined') titles.push(result[i][val]);});
                            parent.find('ul').append('<li data-id="'+(typeof result[i][fields[0]] != 'undefined' ? result[i][fields[0]] : '')+'" data-name="'+titles.join(' - ', titles)+'" class="'+selected+'">['+(typeof result[i][fields[0]] != 'undefined' ? result[i][fields[0]] : '')+'] - '+titles.join(' - ', titles)+'</li>');
                        }
                        parent.find('input.ajax-title').addClass('show-list');
                        parent.find('ul').removeClass('hidden');

                        parent.find('ul li').unbind('click').click(function(){
                            var itme = jQuery(this);
                            var del = jQuery(this).data('id');
                            if (values.length && in_array(parseInt(del), values)){
                                parent.find('input.ajax-title').val('');
                                values = jQuery.grep(values, function(value) { return value != del; });
                                jQuery(this).removeClass('selected');
                            } else {
                                values.push(jQuery(this).data('id'));
                                parent.find('input.ajax-title').val(jQuery(this).data('name'));
                                jQuery(this).addClass('selected');
                            }
                            parent.find('.ajax-value').val(values.join(','));
                            parent.find('input.ajax-title').removeClass('show-list');
                            parent.find('input.ajax-title').parent().find('ul').addClass('hidden');
                            jQuery('div.ajax-fill').append('<span data-id="'+itme.data('id')+'" class="label label-default">'+itme.text()+'<sup>x</sup></span>');

                            if (jQuery('div.ajax-fill span').length){
                                jQuery('div.ajax-fill span').each(function(){
                                    if (!in_array(parseInt(jQuery(this).data('id')), values)){
                                        jQuery(this).remove();
                                    }
                                });

                                jQuery('div.ajax-fill span sup').unbind('click').click(function(){
                                    var del = jQuery(this).parent().data('id');
                                    values = jQuery.grep(values, function(value) { return value != del; });
                                    jQuery(this).parent().remove();
                                    parent.find('.ajax-value').val(values.join(','));
                                    parent.find('input.ajax-title').val('');

                                    if (jQuery('div.ajax-fill span').length) jQuery('div.ajax-fill label').removeClass('hidden');
                                    else jQuery('div.ajax-fill label').addClass('hidden');
                                });
                            }

                            if (jQuery('div.ajax-fill span').length) jQuery('div.ajax-fill label').removeClass('hidden');
                            else jQuery('div.ajax-fill label').addClass('hidden');
                        });
                    } else {
                        parent.find('ul').addClass('hidden');
                    }
                }
            });
        }
    },
    export: function(callback){
        jQuery.validator.addMethod("checktime", function(value, element) {
            var s_date  =  jQuery("#s_date").val();
            var e_date  =  jQuery("#e_date").val();
            if(e_date){
                if(Date.parse(s_date) > Date.parse(e_date) ) {
                    return false;
                }
            }
            return true;
        }, "Thời gian nhập chưa đúng");

        jQuery.validator.addMethod("maxDate", function(value, element) {
            var curDate     = new Date();
            var inputDate   = new Date(value);
            if (inputDate < curDate)
                return true;
            return false;
        }, "Invalid Date!");

        jQuery("#frmExport").validate({
            rules: {
                s_date: {"required":true, checktime:true},
                e_date: {"required":true}
            },
            messages: {
                s_date: {
                    "required":     "Vui lòng nhập thời gian",
                    "maxDate":      "Thời gian bạn nhập phải nhỏ hơn thời gian hiện tại",
                    "checktime":    "Thời gian chưa nhập đúng, Từ ngày nhỏ hơn Đến ngày"
                },
                e_date: {"required": "Vui lòng nhập thời gian"}
            }
        });

        jQuery('button.btn-preview').click(function(){
            return AdminCustom._exportData(jQuery(this), 0, callback);
        });

        jQuery('button.btn-export').click(function() {
            return AdminCustom._exportData(jQuery(this), 1, callback);
        });
    },
    _exportData: function(element, excel, callback){
        if (jQuery('#frmExport').valid()) {
            jQuery('.lds-css.ng-scope').show();
            if (excel === 0) jQuery('.output-data').hide();

            jQuery.ajax({
                type: 'POST',
                url: jQuery("#frmExport").attr('action'),
                data: element.parents('form').serialize() + "&excel="+excel,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': jQuery('#token').val()},
                success: function (response) {
                    jQuery('.lds-css.ng-scope').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    jQuery('.lds-css.ng-scope').hide();
                    alert('Error: ' + xhr.status + ' - ' + thrownError);
                }
            }).done(function (data) {
                if (excel === 0){
                    jQuery('.output-data').html('<div>'+data.html+'</div>');
                    jQuery('.output-data tr[class*="row"]').each(function(){
                        var clazz = jQuery(this).attr('class');
                        clazz = clazz.split('row');
                        if (parseInt(clazz[1]) >= parseInt(data.rows)) jQuery(this).remove();
                    });
                    jQuery('.output-data td[class*="column"]').each(function(){
                        var clazz = jQuery(this).attr('class');
                        clazz = clazz.split('column');
                        if (parseInt(clazz[1]) >= parseInt(data.cols)) jQuery(this).remove();
                    });
                    jQuery('.output-data colgroup').remove();
                    jQuery('.output-data').show();

                    if (typeof callback === "function") {
                        callback(data);
                    }
                } else {
                    var $a = jQuery("<a>");
                    $a.attr("href", data.file);
                    jQuery("body").append($a);
                    $a.attr("download", data.name);
                    $a[0].click();
                    $a.remove();
                }

                jQuery('.lds-css.ng-scope').hide();
            });
        }

        return false;
    }
};

function in_array (needle, haystack, argStrict) {
    var key = '',
        strict = !! argStrict;

    if (strict) {
        for (key in haystack) {
            if (haystack[key] === needle) {
                return true;
            }
        }
    } else {
        for (key in haystack) {
            if (haystack[key] == needle) {
                return true;
            }
        }
    }
    return false;
}