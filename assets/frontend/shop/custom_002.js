//####################################################
// jQuery Custom Handle
//####################################################
(function ($)
{
    $(document).ready(function () {
        // Hide it
        $('.hideit').click(function () {
            $(this).fadeOut();
        });
        
        $('.js-tabs').each(function () {
            $(this).find('.js-tab-nav li:first').addClass('active').show();
            $(this).find('.js-tab-content').hide();
            $(this).find('.js-tab-content:first').show();
            $('.js-tab-nav li').click(function () {
                $(this).parent().parent().find('.js-tab-nav li').removeClass('active');
                $(this).addClass('active');
                
                $(this).parent().parent().find('.js-tab-content').hide();
                $(this).parent().parent().parent().find('.js-tab-content').hide();
                $(this).parent().parent().parent().parent().find('.js-tab-content').hide();
                $(this).parent().parent().parent().parent().parent().find('.js-tab-content').hide();
                
                var activeTab = $(this).find('a').attr('href');
                if(!activeTab || activeTab == 'javascript:void(0)') {
                    var activeTab = $(this).find('a').attr('id');
                }
                $(activeTab).show();
            });
        });

        // Form handle
        $('.form_action').each(function () {
            $(this).nstUI({
                method: 'formAction',
                formAction: {
                    field_load: $(this).attr('_field_load')
                }
            });
        });

        // Verify action
        $('.verify_action').nstUI({
            method: 'verifyAction'
        });

        // Tooltip
        $('[_tooltip]').nstUI({
            method: 'tooltip'
        });

        // Drop Down
        $('[_dropdown]').nstUI({
            method: 'dropdown'
        });

        // Placeholder
        $('input.placeholder').nstUI({
            method: 'placeholder'
        });

        // Accordion
        $('.accordion').each(function () {
            var _t = $(this);
            _t.nstUI({
                method: 'accordion',
                accordion: {type: _t.attr('_accordion_type')}
            });
        });

        // Auto check pages
        $('.auto_check_pages').each(function () {
            auto_check_pages($(this));
        });

        // Date picker
        $('.datepicker').each(function () {
            var config_default = {
                defaultDate: +7,
                autoSize: true,
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '1975'
            };

            var config_cur = $(this).attr('_config');
            config_cur = (config_cur) ? JSON.parse(config_cur) : {};

            var config = $.extend({}, config_default, config_cur);
            $(this).datepicker(config);
        });

        // Number format
        //$('.format_number').number(true);
        // Number format
        //$('.format_currency').number(true);

        // Autocomplete
        var cache = {}, lastXhr;
        $('.autocomplete').each(function () {
            var url_search = $(this).attr('_url');

            $(this).autocomplete({
                minLength: 2,
                source: function (request, response)
                {
                    var term = request.term;

                    if (term in cache)
                    {
                        response(cache[term]);
                        return;
                    }

                    lastXhr = $.getJSON(url_search, request, function (data, status, xhr)
                    {
                        cache[term] = data;
                        if (xhr === lastXhr)
                        {
                            response(data);
                        }
                    });
                }
            });
        });

        // go top
        $('.scroll-top').append('<a href="#top"><img alt="Back to top" src="' + public_url  + '/theme/circle/images/scroll-to-top.png" /></a>');
        $(window).scroll(function () {
            if ($(window).scrollTop() != 0) {
                $('.scroll-top > a').fadeIn();
            } else {
                $('.scroll-top > a').fadeOut();
            }
        });
        $('.scroll-top > a').click(function () {
            $('html, body').animate({scrollTop: 0}, 800);
        });

    });
})(jQuery);


//####################################################
// Main function
//####################################################
/**
 * Load ajax
 */
function load_ajax(_t)
{
    var field = jQuery(_t).attr('_field');
    var url = jQuery(_t).attr('_url');

    jQuery(_t).nstUI({
        method: 'loadAjax',
        loadAjax: {
            url: url,
            field: {load: field + '_load', show: field + '_show'},
            event_complete: function (data)
            {
                // Neu xu ly du lieu thanh cong
                if (data.complete)
                {
                    // Chuyen trang neu duoc khai bao
                    if (data.location != undefined)
                    {
                        if (data.location)
                        {
                            window.parent.location = data.location;
                        } else
                        {
                            window.location.reload();
                        }
                    }

                    // Thong bao sau khi hoan thanh theo kieu colorbox
                    else if (data.colorbox_url != undefined)
                    {
                        jQuery.colorbox({
                            href: data.colorbox_url, inline: true
                        });

                    }

                    // Thong bao sau khi hoan thanh
                    else if (data.msg != undefined)
                    {
                        if (data.msg)
                        {
                            alert(data.msg);
                        }
                        if (data.reset_form != undefined)
                        {
                            jQuery('.form_action').trigger('reset');
                        }

                    }
                }
                // Neu khong thanh cong
                else
                {
                    // Thong bao
                    if (data.msg != undefined)
                    {
                        if (data.msg)
                        {
                            alert(data.msg);
                        }
                    }
                }
            }
        }
    });

    return false;
}

/**
 * Gan gia tri cua cac bien vao html
 */
function temp_set_value(html, params)
{
    jQuery.each(params, function (param, value)
    {
        var regex = new RegExp('{' + param + '}', 'igm');
        html = html.replace(regex, value);
    });

    return html;
}

/**
 * Copy gia tri giua 2 field
 */
function copy_value(from, to)
{
    jQuery(this).nstUI({
        method: 'copyValue',
        copyValue: {
            from: from,
            to: to
        }
    });
}

/**
 * An pages khi ko co chia trang
 */
function auto_check_pages(t)
{
    if (t.find('a')[0] == undefined)
    {
        t.remove();
    }
}

/**
 * Tai thong tin gio hang
 */
function cart_load(url, scrollTo)
{
    var cart = jQuery('#cart_info');
    cart.attr('_url', url);
    load_ajax(cart);

    if (scrollTo) {
        jQuery.scrollTo(cart, 800);
    }
}

/**
 * Hien thi panel cua account
 */
function load_account_panel()
{
    jQuery(this).nstUI({
        method: 'loadAjax',
        loadAjax: {
            url: site_url + 'user/account_panel',
            field: {load: '_', show: 'account_panel'}
        }
    });
}

/**
 * Thay doi captcha
 */
function change_captcha(field)
{
    var t = jQuery('#' + field);
    var url = t.attr('_captcha') + '?id=' + Math.random();
    t.attr('src', url);

    return false;
}

function pushParam(val, dest) 
{
    if(jQuery(dest).val === undefined) {
        return false;
    }
    
    // Day du lieu vao doi tuong
    jQuery(dest).val(val);
}

function hideItem (dest) 
{
    jQuery(dest).hide();
}