$(document).ready(function () {
    $('label.tree-toggler').click(function () {
        $(this).parent().children('ul.tree').toggle(300);
    });

    $('.tree-menu ul li a').click(function () {
        $(this).closest('.tree-menu').find('.active').each(function () {
            $(this).removeClass('active');
        });

        $(this).closest('ul.nav').find('a').each(function () {
            $(this).removeClass('active');
        });
        $(this).toggleClass('active');
        if (!$(this).closest('.li').hasClass('active')) {
            $(this).closest('.li').addClass('active');
        }
    });

    $('.theme-demo-page .demo-icon').click(function () {
        $('.theme-demo-page .demo-icon').each(function () {
            $(this).removeClass('active');
        });
        $(this).addClass('active');
        if ($(this).hasClass('demo-desktop')) {
            $('.demo-screen').removeClass('mobile-screen').removeClass('tablet-screen').addClass('desktop-screen');
        } else if ($(this).hasClass('demo-mobile')) {
            $('.demo-screen').removeClass('desktop-screen').removeClass('tablet-screen').addClass('mobile-screen');
        } else if ($(this).hasClass('demo-tablet')) {
            $('.demo-screen').removeClass('mobile-screen').removeClass('desktop-screen').addClass('tablet-screen');
        }
    });

    $('.successful-page .go-setting').mouseover(function () {
        $(this).find('img').attr('src', '/public/theme/circle/images/go-setting-hover.png');
    });

    $('.successful-page .go-setting').mouseleave(function () {
        $(this).find('img').attr('src', '/public/theme/circle/images/go-setting.png');
    });

    $('.successful-page .go-shop').mouseover(function () {
        $(this).find('img').attr('src', '/public/theme/circle/images/go-shop-hover.png');
    });

    $('.successful-page .go-shop').mouseleave(function () {
        $(this).find('img').attr('src', '/public/theme/circle/images/go-shop.png');
    });

    $('.choose-theme-page .themes-item .check label').click(function () {
        $('.choose-theme-page .themes-item').each(function () {
            $(this).removeClass('active');
            $(this).find('.check input').prop('checked', false);
        });
        $(this).closest('.themes-item').addClass('active');
    });

    $("a[href='#top']").click(function () {
        $("html, body").animate({scrollTop: 0}, "slow");
        return false;
    });

    if ($('.features-page').length > 0) {
        $.fn.calculateWidth = function () {
            if ($(window).width() > 767) {
                var container_width = $('.features-menu .container').width();
                var col_width = Math.round((container_width / 7) - 1);
                $('.features-menu li').each(function () {
                    $(this).width(col_width);
                });
            } else {
                $('.features-menu li').css({'width': '100%'});
            }
        };

        $.fn.calculateWidth();
        $(window).resize(function () {
            $.fn.calculateWidth();
        });
    }

    $('.sub-app').height($('.sub-apps').width() / 100 * 20);

    if ($('.step-item').length > 0) {
        var stepIndex;
        $('.step-item').click(function () {
            stepIndex = $('.step-item').index($(this));
            $('.step-item').each(function () {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            $('.step-detail').each(function () {
                $(this).removeClass('active');
            });
            $('.step-detail').eq(stepIndex).addClass('active');
        });
    }

    if ($('.features-carousel').length > 0) {
        $('.content-slide').each(function () {
            $(this).height($('.image-slide').eq(0).height());
        });
    }

    $.fn.setContactWidth = function () {
        if ($('.contact-address').length > 0 && $(window).width() > 767) {
            $('.contact-address').height($('.contact-image').height());
        }
    };

    $.fn.setPackagesHeight = function () {
        if ($('.packages-page .packages-item').length > 0 && $(window).width() > 992) {
            var packageHeight = 0;
            packageHeight = $('.packages-item').eq(2).height();
            if ($('.packages-item').eq(3).length > 0) {
                packageHeight = $('.packages-item').eq(3).height();
            }
            $('.packages-item').each(function () {
                $(this).height(packageHeight);
            });
        }
    };

    $.fn.setThemedetailHeight = function () {
        if ($('.theme-maininfo').length > 0 && $(window).width() > 767) {
            if ($('.image-full').height() < $('.theme-maininfo').height()) {
                $('.image-full').height($('.theme-maininfo').height());
                $('.image-full img').css({'position': 'absolute', 'bottom': '0'});
            }
        }
    };

    $.fn.setLandingSlidelHeight = function () {
        if ($('.landing-features').length > 0 && $(window).width() > 767) {
            $('.landing-features .content-slide').each(function () {
                if ($(this).height() < $(this).next().height()) {
                    $(this).height($(this).next().height());
                }
            });
        }
    };

    $('#itemslider').carousel({interval: 3000});

    $('.carousel-showmanymoveone .item').each(function () {
        var itemToClone = $(this);

        for (var i = 1; i < 6; i++) {
            itemToClone = itemToClone.next();

            if (!itemToClone.length) {
                itemToClone = $(this).siblings(':first');
            }

            itemToClone.children(':first-child').clone()
                    .addClass("cloneditem-" + (i))
                    .appendTo($(this));
        }
    });

    $(window).scroll(function () {
        var browserTop = $(window).scrollTop();
        if ($('.packages-table table').length > 0) {
            var tableTop = $('.packages-table table').offset().top;
            var tableBottom = tableTop + $('.packages-table table').outerHeight(true);
        }

        if (browserTop > tableTop && browserTop < tableBottom) {
            if (!$('.header-fixed').hasClass('active')) {
                $('.header-fixed').addClass('active');
            }
        } else {
            if ($('.header-fixed').hasClass('active')) {
                $('.header-fixed').removeClass('active');
            }
        }
    });

    $('.themes-menu-xs .dropdown-menu a').click(function () {
        $('.themes-menu-xs button').html($(this).html() + '<span class="caret"></span>');
    });

    $('.features-title').click(function () {
        $('.block-info').each(function () {
            $(this).removeClass('active');
            $(this).find('.content').addClass('hidden');
            $(this).find('.fa-angle-down').addClass('hidden');
            $(this).find('.fa-angle-right').removeClass('hidden');
        });
        $(this).parent().addClass('active');
        $(this).next().removeClass('hidden');
        $(this).find('.fa-angle-right').addClass('hidden');
        $(this).find('.fa-angle-down').removeClass('hidden');
    });

    $.fn.customizePackagesTable = function () {
        if ($('.packages-page').length > 0) {
            $('.packages-page .table-category').click(function () {
                $(this).toggleClass('active');
            });

            $('.packages-page .show-more').click(function () {
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).find('a').html('Thu gọn');
                } else {
                    $(this).find('a').html('Xem thêm');
                }
            });

            var tableTopPos = $('.table-category').eq(0).offset().top;
            $(window).scroll(function () {
                var screenTopPos = $(document).scrollTop();
                var notiTopPos = $('.packages-noti').offset().top;
                if (screenTopPos > tableTopPos && screenTopPos < notiTopPos) {
                    $('.pạckages-scroll').show();
                } else {
                    $('.pạckages-scroll').hide();
                }
            });
        }

        if ($('.packages-content').length > 0) {
            if ($('.package-header-row').length > 0) {
                $('.package-header-row').height($('.packages-content .package-header').eq(0).height());
            }
        }
    };



    $.fn.setSliderSameHeight = function () {
        var maxLength = 0;
        $('.why-zozo .thumbnail').each(function () {
            if ($(this).height() > maxLength) {
                maxLength = $(this).height();
            }
            $(this).height(maxLength);
        });
    };

    $.fn.drawTriangle = function () {
        var heightRatio = 7 / 26;
        var bgColor = '#fff';
        var screenWidth = $(window).width();
        if (screenWidth >= 1600) {
            heightRatio = 4 / 26;
        }
        $('.triangle-bottomright').each(function () {
            if ($(this).hasClass('triangle-violet')) {
                bgColor = '#435493';
            } else if ($(this).hasClass('triangle-grey')) {
                bgColor = '#eeeff1';
            } else {
                bgColor = '#fff';
            }
            $(this).css({'border-bottom': screenWidth * heightRatio + 'px solid ' + bgColor, 'border-left': screenWidth + 'px solid transparent'});
        });

        $('.triangle-topleft').each(function () {
            if ($(this).hasClass('triangle-violet')) {
                bgColor = '#435493';
            } else if ($(this).hasClass('triangle-grey')) {
                bgColor = '#eeeff1';
            } else {
                bgColor = '#fff';
            }
            $(this).css({'border-top': screenWidth * heightRatio + 'px solid ' + bgColor, 'border-right': screenWidth + 'px solid transparent'});
        });
    };

    $.fn.drawSquare = function () {
        var widthRatio = 5 / 13;
        var screenWidth = $(window).width();
        if (screenWidth < 992) {
            widthRatio = 1;
        }

        $('.square').each(function () {
            $(this).css({'height': '100%', 'width': screenWidth * widthRatio, 'position': 'absolute', 'top': '0', 'left': '0'});
        });
    };

    $.fn.generatePopover = function () {
        /*if ($('.themes-page').length > 0) {
            $('[data-toggle="popover"]').popover();

            $(".search-input").popover({
                trigger: 'click',
                placement: 'bottom',
                html: 'true',
                content: '<div class="career-list">' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Công nghệ</a>' +
                        '<a class="career-item">Ẩm thực</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<a class="career-item">Thời trang</a>' +
                        '<div class="clearfix"></div>' +
                        '</div>',
                template: '<div class="popover">' +
                        '<div class="career-category bg-white">' +
                        '<h3 class="carreer-list-title text-blue uppercase">Lĩnh vực kinh doanh của bạn</h3><div class="popover-content">' +
                        '</div>' +
                        '</div>' +
                        '</div>'
            }).on('shown', function () {

            });

            $(document).on('click', '.career-item', function () {     
                $('.category-field span').html($(this).html());
                if($(window).width() <= 767){
                    $('.search-input').trigger('click');
                    $(window).scrollTop(0, 0);
                }
            });
        }*/
    };

    $.fn.generatePopover();
    $.fn.drawSquare();
    $.fn.customizePackagesTable();
    $.fn.drawTriangle();
    $.fn.setSliderSameHeight();
    $.fn.setLandingSlidelHeight();
    $.fn.setContactWidth();
    $.fn.setPackagesHeight();
    $.fn.setThemedetailHeight();
    $(window).resize(function () {
        $.fn.generatePopover();
        $.fn.drawSquare();
        $.fn.customizePackagesTable();
        $.fn.setSliderSameHeight();
        $.fn.setLandingSlidelHeight();
        $.fn.setContactWidth();
        $.fn.setPackagesHeight();
        $.fn.setThemedetailHeight();
        $.fn.drawTriangle();
    });

    if ($('.why-zozo-slider').length > 0) {
        $('.why-zozo-slider').slick({
            dots: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false
                    }
                }
            ]
        });
    }

    if ($('.shop-theme-page .tesimonial-slider').length > 0) {
        $('.tesimonial-slider').slick({
            dots: true,
            centerMode: true,
            slidesToShow: 1,
            centerPadding: '250px',
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });
    }

    if ($('.theme-free-page .tesimonial-slider').length > 0) {
        $('.tesimonial-slider').slick({
            dots: true,
            slidesToShow: 2,
            centerPadding: '250px',
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        centerPadding: '40px',
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });
    }

    if ($('.features-carousel .carousel-inner').length > 0) {
        $('.features-carousel .carousel-inner').slick({
            dots: true
        });
    }

    $('.demo-icon').click(function () {
        $('.demo-icon').each(function () {
            $(this).removeClass('active');
        });
        $(this).addClass('active');
    });

    $(window).bind('scroll', function () {
        if ($(window).width() < 767) {
            if ($('.themes .theme-overlay').length > 0) {
                $('.themes .theme-overlay').each(function () {
                    if (withinviewport($(this))) {
                        $(this).closest('.themes-item').addClass('active');
                    } else {
                        $(this).closest('.themes-item').removeClass('active');
                    }
                });
            }
        }
    });
});