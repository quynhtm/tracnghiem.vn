/*=========================================*/
/* fix .live menthor in jquery 1.9 and above */
jQuery.fn.extend({
    live: function (event, callback) {
        if (this.selector) {
            jQuery(document).on(event, this.selector, callback);
        }
        return this;
    }
});
/*=========================================*/
/*check empty content element*/
function isEmpty(el) {
    return !$.trim(el.html()).length;
}
/*Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position*/
function sticky_menu(menu, sticky) {
    if (typeof sticky === 'undefined' || !jQuery.isNumeric(sticky)) sticky = 0;
    if ($(window).scrollTop() >= sticky) {
        if ($('#just-for-height').length === 0) {
            menu.after('<div id="just-for-height" style="height:' + menu.height() + 'px"></div>')
        }
        menu.addClass("sticky");
    } else {
        menu.removeClass("sticky");
        $('#just-for-height').remove();
    }
}
/*change position of submenu to left*/
function submenu_left() {
    var ww = $(window).width();
    $('.has-submenu .level1').each(function () {
        var offsetLv1 = $(this).offset().left;
        var offsetLv2 = offsetLv1 + $(this).width();
        if (offsetLv1 > (ww * 0.7)) {
            $(this).addClass('menu-float-left');
        }
        $(this).find('.level2').each(function () {
            if (offsetLv2 > (ww * 0.7)) {
                $(this).addClass('menu-float-left');
            }
        });
    });
}
/*=========================================*/
/* check current page in menu header */
var curren_page = $('.menu-sidebar .menusanpham a[href="' + window.location.href + '"]');
/* curren_page.parent().addClass('current-menu-item current_page_item'); */
/* curren_page.closest('.menusanpham > li').addClass('current-menu-item current_page_item'); */
/**/
$(document).ready(function () {
    /* change position left-right of sub-menu */
    /*submenu_left();*/
    $(window).resize(function () {
        /*submenu_left();*/
    });
    /**/
    /*Get the navbar*/
    var menu = $("#header .bottom-header");
    /*Get the offset position of the navbar*/
    if (menu.length) {
        var sticky = menu.offset().top + 1;
        /*When the user scrolls the page, execute myFunction*/
        if ($(window).width() > 767) {
            /*sticky_menu(menu, sticky);*/
            $(window).on('scroll', function () {
                /*sticky_menu(menu, sticky);*/
            });
        }
    }
});