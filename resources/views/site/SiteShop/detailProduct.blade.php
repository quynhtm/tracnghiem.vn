@extends('site.SiteLayouts.index')
@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home">
                            <a href="{{buildLinkHome()}}">
                                <span><i class="fa fa-home"></i> Trang chủ</span>
                            </a>
                            <span><i class="fa">/</i></span>
                        </li>
                        @if(isset($product->category_id))
                            <li>
                                <a href="{{buildLinkProductWithCategory($product->category_id,$product->category_name)}}">
                                    <span>{{$product->category_name}}</span>
                                </a>
                                <span><i class="fa">/</i></span>
                            </li>
                        @endif
                        @if(isset($product->product_name))
                            <li><strong>{{$product->product_name}}</strong></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="main-product-page">
            <div class="row">
                <div class="details-product">
                    <div id="content" class="col-sm-12 col-xs-12 col-md-12">
                        <div class="rows">
                            <!---image product-->
                            <div class="product-detail-left product-images col-xs-12 col-sm-6 col-md-5 col-lg-5">
                                <div class="row"> <!-- product images -->
                                    <div class="col_large_default large-image">
                                        <a href="javascript:void();" class="large_image_url checkurl" data-rel="prettyPhoto[product-gallery]">
                                            <div style="height:460.5px;width:460.5px;" class="zoomWrapper">
                                                <img id="img_01" class="img-responsive" alt="Áo T.shirt cá tính Can De Blanc T1069 SID54612" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data//sid54612-500x500.jpg" data-zoom-image="https://bigboom.exdomain.net/image/catalog/san-pham/sid54612.jpg" style="position: absolute; width: 460.5px; height: 460.5px;">
                                            </div>
                                        </a>
                                        <div class="hidden"></div>
                                    </div>

                                    <div class="product-detail-thumb" style="display: none">
                                        <div id="gallery_02"
                                             class="owl-carousel owl-theme thumbnail-product thumb_product_details not-dqowl owl-loaded owl-drag"
                                             data-loop="false" data-lg-items="4" data-md-items="4" data-sm-items="3"
                                             data-xs-items="3" data-xxs-items="3">
                                            <div class="owl-stage-outer">
                                                <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 116px;">
                                                    <div class="owl-item active" style="width: 115.625px;">
                                                        <div class="item">
                                                            <a href="#" data-image="https://bigboom.exdomain.net/image/cache/catalog/san-pham/sid54612-500x500.jpg" data-zoom-image="https://bigboom.exdomain.net/image/catalog/san-pham/sid54612.jpg" class="active">
                                                                <img data-img="https://bigboom.exdomain.net/image/cache/catalog/san-pham/sid54612-74x74.jpg" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data//sid54612-500x500.jpg" alt="Áo T.shirt cá tính Can De Blanc T1069 SID54612">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="owl-nav disabled">
                                                <div class="owl-prev disabled">prev</div>
                                                <div class="owl-next disabled">next</div>
                                            </div>
                                            <div class="owl-dots disabled"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7 details-pro">
                                <h1 class="title-product">Áo T.shirt cá tính Can De Blanc T1069 SID54612</h1>
                                <div class="social-buttons">
                                    <a rel="nofollow" target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u={{buildLinkDetailProduct($product->product_id, $product->product_name, $product->category_name)}}" title="Chia sẻ lên Facebook">
                                        <img alt="Chia sẻ lên Facebook" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/icon/facebook.png" width="25">
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a rel="nofollow" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&amp;fs=1&amp;to&amp;su=&amp;body={{$product->product_sort_desc}}" title="Chia sẻ lên Gmail">
                                        <img alt="Chia sẻ lên Gmail" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/icon/gmail.png" width="25">
                                    </a>
                                </div>
                                <style type="text/css"> .social-buttons {
                                        display: block;
                                        width: 100%;
                                    }
                                    .social-buttons a {
                                        display: inline-block;
                                        border-radius: 5px;
                                    } </style>
                                <div class="group-status">
                                    <span class="first_status">
                                        <a href="{{buildLinkProductWithCategory($product->category_id,$product->category_name)}}" title="{{$product->category_name}}">{{$product->category_name}}</a>
                                    </span>
                                </div>

                                <div class="price-box"><span class="special-price"> <span class="price product-price">{{numberFormat($product->product_price_sell)}}đ</span> </span>
                                </div>
                                <div class="product-summary product_description margin-bottom-0">
                                    <p>{!! $product->product_sort_desc !!}</p>
                                </div>

                                <div id="product" class="form-product col-sm-12">
                                    <div class="form-group form_button_details">
                                        <div class="form_hai ">
                                            <div class="custom input_number_product custom-btn-number form-control">
                                                <button class="btn_num num_1 button button_qty" type="button"
                                                        onclick="var result = document.getElementById('input-quantity');var qtypro = result.value;if(!isNaN(qtypro) &amp;&amp; qtypro > 1) result.value--;return false;">
                                                    -
                                                </button>
                                                <input type="text" name="quantity" value="1" id="input-quantity"
                                                       class="form-control prd_quantity">
                                                <button class="btn_num num_2 button button_qty" type="button"
                                                        onclick="var result = document.getElementById('input-quantity');var qtypro = result.value;if(!isNaN(qtypro)) result.value++;return false;">
                                                    +
                                                </button>
                                            </div>
                                            <div class="button_actions">
                                                <input type="hidden" name="product_id" value="213">
                                                <button type="button" id="button-cart" data-loading-text="Đang tải..." class="btn btn-lg btn-block btn-cart button_cart_buy_enable add_to_cart btn_buy">
                                                    <span class="btn-content">Thêm vào giỏ</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Thông tin người bán hàng--->
                                <div id="block-tab-infor" class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12 no-padding">
                                            <div class="product-tab e-tabs">
                                                <ul class="tabs tabs-title clearfix">
                                                    <li class="tab-link current" data-tab="tab-description">
                                                        <h3>
                                                            <span>Thông tin mua hàng</span>
                                                        </h3>
                                                    </li>
                                                </ul>
                                                <div class="tab-content current" id="tab-description">
                                                    <div class="rte2">
                                                        <p><b>Thông tin liên hệ: </b></p>
                                                        <p>Ms Giang: 0985101026</p>
                                                        <p>Ms Bình: 0903187988</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="block-tab-infor" class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                            <div class="row margin-top-20 xs-margin-top-15">
                                <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12 no-padding">
                                    <div class="product-tab e-tabs">
                                        <ul class="tabs tabs-title clearfix">
                                            <li class="tab-link current" data-tab="tab-description">
                                                <h3>
                                                    <span>Mô tả</span>
                                                </h3>
                                            </li>
                                        </ul>
                                        <div class="tab-content current" id="tab-description">
                                            <div class="rte">
                                                {!! $product->product_content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <!--Sản phẩm liên quan--->
        @if(isset($arrRelatedProducts) && !empty($arrRelatedProducts))
        <div class="row">
            <section class="awe-section-3 " id="category_custom-1">
                <section class="section_like_product">
                    <div class="container">
                        <div class="row row-noGutter-2">
                            <div class="heading tab_link_module">
                                <h2 class="title-head pull-left">
                                    <span>Sản phẩm liên quan</span>
                                </h2>

                                <div class="tabs-content tabs-content-featured col-md-12 col-sm-12 col-xs-12 no-padding">
                                    <div id="content-tabb10" class="content-tab content-tab-proindex" style="">
                                        <div class="row">
                                            @foreach($arrRelatedProducts as $key=>$item)
                                                <?php $number = $key+1;?>
                                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-20 custom-mobile">
                                                    <div class="wrp_item_small product-col">
                                                        <div class="product-box">
                                                            <div class="product-thumbnail">
                                                                @if($item->product_price_market > 0 && $item->product_price_market > $item->product_price_sell)
                                                                    <span class="sale-off">-51%</span>
                                                                @endif
                                                                <a class="image_link display_flex" href="{{buildLinkDetailProduct($item->product_id, $item->product_name, $item->category_name)}}" title="{{$item->product_name}}">
                                                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/sid53235-228x228.jpg" data-lazyload="https://bigboom.exdomain.net/image/cache/catalog/san-pham/sid53235-228x228.jpg" alt="{{$item->product_name}}">
                                                                </a>
                                                                <div class="product-action-grid clearfix">
                                                                    <form class="variants form-nut-grid">
                                                                        <div>
                                                                            <button class="btn-cart button_wh_40 left-to" title="Mua ngay" type="button" onclick="Shopcuatui.addOneProductToCart('{{setStrVar($item->product_id)}}',1);">
                                                                                Mua ngay
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="product-info effect a-left">
                                                                <div class="info_hhh">
                                                                    <h3 class="product-name ">
                                                                        <a href="{{buildLinkDetailProduct($item->product_id, $item->product_name, $item->category_name)}}" title="{{$item->product_name}}">{{$item->product_name}}</a>
                                                                    </h3>
                                                                    <div class="price-box clearfix">
                                                                        <span class="price product-price">{{numberFormat($item->product_price_sell)}}đ</span>
                                                                        @if($item->product_price_market > 0 && $item->product_price_market > $item->product_price_sell)
                                                                            <span class="price product-price-old">{{numberFormat($item->product_price_market)}}đ</span>
                                                                        @endif
                                                                    </div>
                                                                    <span class="product-category">
                                                                        <a href="{{buildLinkProductWithCategory($item->category_id, $item->category_name)}}" title="Danh sách sản phẩm {{$item->category_name}}">{{$item->category_name}}</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(($number%2)==0)
                                                    <div class="clearfix hidden-sm hidden-md hidden-lg"></div>
                                                @else
                                                    <div class="clearfix hidden-xs hidden-lg"></div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </div>
        @endif
    </div>

    <script type="text/javascript"> $('select[name=\'recurring_id\'], input[name="quantity"]').change(function () {
            $.ajax({
                url: '/product/product/getRecurringDescription',
                type: 'post',
                data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
                dataType: 'json',
                beforeSend: function () {
                    $('#recurring-description').html('');
                },
                success: function (json) {
                    $('.alert, .text-danger').remove();
                    if (json['success']) {
                        $('#recurring-description').html(json['success']);
                    }
                }
            });
        }); </script>
    <script type="text/javascript"> $('#button-cart').on('click', function () {
            $.ajax({
                url: '/checkout/cart/add',
                type: 'post',
                data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
                dataType: 'json',
                beforeSend: function () {
                    $('#button-cart').button('loading');
                },
                complete: function () {
                    $('#button-cart').button('reset');
                },
                success: function (json) {
                    $('.alert, .text-danger').remove();
                    $('.form-group').removeClass('has-error');
                    if (json['error']) {
                        if (json['error']['option']) {
                            for (i in json['error']['option']) {
                                var element = $('#input-option' + i.replace('_', '-'));
                                if (element.parent().hasClass('input-group')) {
                                    element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                                } else {
                                    element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                                }
                            }
                        }
                        if (json['error']['recurring']) {
                            $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                        }
                        /* Highlight any found errors */
                        $('.text-danger').parent().addClass('has-error');
                    }
                    if (json['success']) {
                        $('.bread-crumb').after('<div class="container"><div class="row" style="position:relative"><div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div></div></div>');
                        var item = json['total'].split(' - ');
                        setTimeout(function () {
                            $('.absolute.count_item.count_item_pr').html(item[0].split(' ')[0]);
                            $('.price_cart.count_item.count_item_pr').html(item[1]);
                        }, 100);
                        $('html, body').animate({scrollTop: 0}, 'fast');
                        $('#cart #cart-sidebar').load('/common/cart/info #cart-sidebar > li');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }); </script>
    <script type="text/javascript"> $('.date').datetimepicker({pickTime: false});
        $('.datetime').datetimepicker({pickDate: true, pickTime: true});
        $('.time').datetimepicker({pickDate: false});
        $('button[id^=\'button-upload\']').on('click', function () {
            var node = this;
            $('#form-upload').remove();
            $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
            $('#form-upload input[name=\'file\']').trigger('click');
            if (typeof timer != 'undefined') {
                clearInterval(timer);
            }
            timer = setInterval(function () {
                if ($('#form-upload input[name=\'file\']').val() != '') {
                    clearInterval(timer);
                    $.ajax({
                        url: '/tool/upload',
                        type: 'post',
                        dataType: 'json',
                        data: new FormData($('#form-upload')[0]),
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $(node).button('loading');
                        },
                        complete: function () {
                            $(node).button('reset');
                        },
                        success: function (json) {
                            $('.text-danger').remove();
                            if (json['error']) {
                                $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                            }
                            if (json['success']) {
                                alert(json['success']);
                                $(node).parent().find('input').val(json['code']);
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            }, 500);
        }); </script>
    <script type="text/javascript"> $('#review').delegate('.pagination a', 'click', function (e) {
            e.preventDefault();
            $('#review').fadeOut('slow');
            $('#review').load(this.href);
            $('#review').fadeIn('slow');
        });
        $('#button-review').on('click', function () {
            $.ajax({
                url: '/product/product/write?product_id=213',
                type: 'post',
                dataType: 'json',
                data: $("#form-review").serialize(),
                beforeSend: function () {
                    $('#button-review').button('loading');
                },
                complete: function () {
                    $('#button-review').button('reset');
                },
                success: function (json) {
                    $('.alert-success, .alert-danger').remove();
                    if (json['error']) {
                        $('#form-review .valid').html('<i class="fa fa-exclamation-circle"></i> ' + json['error']);
                    }
                    if (json['success']) {
                        $('#form-review .valid').html('<i class="fa fa-check-circle"></i> ' + json['success']);
                        $('input[name=\'name\']').val('');
                        $('input[name=\'email\']').val('');
                        $('textarea[name=\'text\']').val('');
                        $('input[name=\'rating\']:checked').prop('checked', false);
                    }
                }
            });
        });
        $(document).ready(function () {
            $('.thumbnails').magnificPopup({type: 'image', delegate: 'a', gallery: {enabled: true}});
        });
        $('.see-detail').click(function (e) {
            e.preventDefault();
            $('html,body').animate({scrollTop: $("#block-tab-infor").offset().top,}, 700);
            return false;
        }); </script>
    <script type="text/javascript"> var ww = $(window).width();
        $(document).ready(function () {
            if (ww >= 1200) {
                setTimeout(function () {
                    $('#img_01').elevateZoom({
                        gallery: 'gallery_02', /*zoomWindowWidth : 420, zoomWindowHeight : 500,*/
                        zoomWindowOffetx: 10,
                        easing: true,
                        scrollZoom: true,
                        cursor: 'pointer',
                        galleryActiveClass: 'active',
                        imageCrossfade: true
                    });
                });
            }
            $("#img_02").click(function (e) {
                e.preventDefault();
                var hr = $(this).attr('src');
                $('#img_01').attr('src', hr);
                $('.large_image_url').attr('href', hr);
                $('#img_01').attr('data-zoom-image', hr);
            });
            $('#gallery_00 img, .swatch-element label').click(function (e) {
                $('.checkurl').attr('href', $(this).attr('src'));
                if (ww >= 1200) {
                    setTimeout(function () {
                        $('.zoomContainer').remove();
                        $('#zoom_01').elevateZoom({
                            gallery: 'gallery_02',
                            zoomWindowWidth: 420,
                            zoomWindowHeight: 500,
                            zoomWindowOffetx: 10,
                            easing: true,
                            scrollZoom: true,
                            cursor: 'pointer',
                            galleryActiveClass: 'active',
                            imageCrossfade: true
                        });
                    }, 300);
                }
            });
            $("#gallery_02").owlCarousel({
                nav: true,
                dots: false,
                margin: 0,
                autoplay: false,
                autoplayHoverPause: true,
                loop: false,
                responsive: {
                    0: {items: 3},
                    543: {items: 4},
                    768: {items: 4},
                    991: {items: 4},
                    992: {items: 4},
                    1200: {items: 4}
                }
            });
            $('#gallery_02 img, .swatch-element label').click(function (e) {
                e.preventDefault();
                var ths = $(this).attr('data-img');
                $('.large-image .checkurl').attr('href', ths);
                $('.large-image .checkurl img').attr('src', ths);
                /*** xử lý active thumb -- ko variant ***/ var thumbLargeimg = $('.details-product .large-image a').attr('href').split('?')[0];
                var thumMedium = $('#gallery_02 .owl-item .item a').find('img').attr('src');
                var url = [];
                $('#gallery_02 .owl-item .item').each(function () {
                    var srcImg = '';
                    $(this).find('a img').each(function () {
                        var current = $(this);
                        if (current.children().length > 0) {
                            return true;
                        }
                        srcImg += $(this).attr('src');
                    });
                    url.push(srcImg);
                    var srcimage = $(this).find('a img').attr('src').split('?')[0];
                    if (srcimage == thumbLargeimg) {
                        $(this).find('a').addClass('active');
                    } else {
                        $(this).find('a').removeClass('active');
                    }
                });
            });
        }); </script>
@stop