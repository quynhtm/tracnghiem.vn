@section('header')
<div id="mySidenav" class="sidenav menu_mobile hidden-md hidden-lg ">
    <div class="top_menu_mobile">
        <span class="close_menu">
            <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/logo.png" alt="Bigboom">
        </span>
    </div>
    <div class="content_memu_mb">
        <div class="link_list_mobile">
            <ul class="ct-mobile hidden"></ul>
            <ul class="ct-mobile">
                <li class="level0 level-top parent level_ico">
                    <a href="{{buildLinkHome()}}">Trang chủ</a>
                </li>
                <li class="level0 level-top parent level_ico">
                    <a href="https://bigboom.exdomain.net/gioi-thieu">Giới thiệu</a>
                </li>
                <li class="level0 level-top parent level_ico">
                    <a href="https://bigboom.exdomain.net/san-pham">Sản phẩm mới</a>
                </li>
                <li class="level0 level-top parent level_ico">
                    <a href="https://bigboom.exdomain.net/lien-he">Liên hệ</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<header class="header">
    <div class="mid-header">
        <div class="container">
            <div class="row">
                <div class="content_header">
                    <div class="header-main">
                        <div class="menu-bar-h nav-mobile-button hidden-md hidden-lg">
                            <a href="#nav-mobile">
                                <i class="fa fa-bars"></i>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="logo">
                                <a href="{{buildLinkHome()}}" class="logo-wrapper ">
                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/logo.png" alt="Bigboom">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 no-padding col-sm-12 col-xs-12">
                            <div class="header-left">
                                <div class="header_search header_searchs">
                                    <form class="input-group search-bar" role="search" id="search">
                                        <div class="collection-selector">
                                            <select name="category_id" class="search_text">
                                                <option class="item-cate search_item" value="0" selected="selected">
                                                    Tất cả
                                                </option>
                                                <option class="item-cate search_item" value="171">
                                                    Balo và túi xách&nbsp;&nbsp;
                                                </option>
                                                <option class="item-cate search_item" value="173">
                                                    Giày dép &nbsp;&nbsp;
                                                </option>
                                                <option class="item-cate search_item" value="174">
                                                    Hot Deal&nbsp;&nbsp;
                                                </option>
                                            </select>
                                        </div>
                                        <input type="search" name="search" placeholder="Tìm kiếm nhanh"
                                               class="input-group-field st-default-search-input search-text"
                                               autocomplete="off" style="padding-left: 201.433px;">
                                        <span class="input-group-btn">
                                            <button class="btn icon-fallback-text">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </span>
                                    </form>
                                    <div class="hidden-lg hidden-md visible-xs visible-sm" style="text-align: center!important;">
                                        <a style="color: #ffffff!important;font-weight:bold " href="javascript:void(0);"> Ms Giang: 0985.1010.26 - Ms Bình: 0903.187.988</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="header-right">
                                <div class="header-acount hidden-lg-down">
                                    <div class="wishlist_header hidden-xs hidden-sm">
                                        <div class="img_hotline"><i class="fa fa-phone"></i></div>
                                        <span class="text_hotline">Điện thoại</span>
                                        <a class="phone-order" href="tel:0985101026">0985.1010.26</a>
                                        <a class="phone-order" href="tel:0903187988">0903.187.988</a>
                                    </div>

                                    <div class="top-cart-contain f-right hidden-xs hidden-sm visible-md visible-lg">
                                        <div class="mini-cart text-xs-center" id="cart">
                                            <div class="heading-cart">
                                                <a class="bg_cart" href="https://bigboom.exdomain.net/index.php?route=checkout/cart" title="Giỏ hàng">
                                                    <input type="hidden" name="totalItemCartValue" id="totalItemCartValue" @if($totalItemCart == STATUS_INT_KHONG)value="0" @else value="{{$totalItemCart}}"@endif>
                                                    <span class="absolute count_item count_item_pr" id="totalItemCart">{{$totalItemCart}}</span>
                                                    <img alt="Giỏ hàng" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/icon-bag.png">
                                                    <span class="block-small-cart">
                                                        <span class="text-giohang hidden-xs">Giỏ hàng</span>
                                                        <span class="block-count-pr">
                                                            <span class="count_item count_item_pr price_cart">{{numberFormat($totalMoneyCart)}}đ</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="top-cart-content">
                                                @if($totalItemCart == STATUS_INT_KHONG)
                                                    <ul id="cart-sidebar" class="mini-products-list count_li">
                                                        <li>
                                                            <div class="no-item"><p>Giỏ hàng của bạn trống!</p></div>
                                                        </li>
                                                    </ul>
                                                @else
                                                    @if(isset($dataCart) && !empty($dataCart))
                                                    <ul id="cart-sidebar" class="mini-products-list count_li">
                                                        <li>
                                                            <ul class="list-item-cart">
                                                                <?php $tong_tien = 0; ?>
                                                                @foreach($dataCart as $k_c => $cart)
                                                                    <li class="item productid-1686">
                                                                        <div class="border_list">
                                                                            <a class="product-image" href="{{buildLinkDetailProduct($cart['product_id'], $cart['product_name'], $cart['category_name'])}}" title="{{$cart['product_name']}}">
                                                                                <img alt="{{$cart['product_name']}}" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/sid65351-400x300.jpg" width="100">
                                                                            </a>
                                                                            <div class="detail-item">
                                                                                <div class="product-details">
                                                                                    <p class="product-name">
                                                                                        <a class="text2line"  href="{{buildLinkDetailProduct($cart['product_id'], $cart['product_name'], $cart['category_name'])}}"  title="{{$cart['product_name']}}">
                                                                                            {{$cart['product_name']}}
                                                                                        </a>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="product-details-bottom">
                                                                                    <?php $tong_tien = ($cart['product_price_sell']*$cart['number']); ?>
                                                                                    <span class="price">{{numberFormat($cart['product_price_sell'])}}đ</span>
                                                                                    <span class="quantity">X {{$cart['number']}}</span>
                                                                                    <div class="total">= {{numberFormat($tong_tien)}}đ</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <div class="pd">
                                                                <div class="top-subtotal">Thành tiền: <span class="price">{{numberFormat($totalMoneyCart)}}đ</span>
                                                                </div>
                                                                <div class="top-subtotal">
                                                                    Phí vận chuyển được tính khi xử lý đơn hàng
                                                                </div>
                                                                <div class="top-subtotal">Tổng số: <span class="price">{{numberFormat($totalMoneyCart)}}đ</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="pd right_ct">
                                                                <a  href="https://bigboom.exdomain.net/checkout/cart"  class="btn btn-primary">
                                                                    <span>Giỏ hàng</span>
                                                                </a>
                                                                <a href="https://bigboom.exdomain.net/checkout/state" class="btn btn-white">
                                                                    <span>Thanh toán</span>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="top-cart-contain f-right hidden-lg hidden-md visible-xs visible-sm">
                                        <div class="mini-cart text-xs-center">
                                            <div class="heading-cart">
                                                <a class="bg_cart" href="https://bigboom.exdomain.net/index.php?route=checkout/cart" title="Giỏ hàng">
                                                    <span class="absolute count_item count_item_pr" id="totalItemCart">{{$totalItemCart}}</span>
                                                    <img alt="Giỏ hàng" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/icon-bag.png">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-nav">
        <div class="container ">
            <div class="row">

                <!--danh mục trang chủ-->
                <div class="col-md-3 col-sm-12 col-xs-12 vertical-menu-home">
                    <div id="section-verticalmenu" class="block block-verticalmenu float-vertical float-vertical-left">
                        <div class="bg-vertical">
                            <img alt="Giỏ hàng" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/icon/menu-icon.png">
                        </div>

                        <h4 class="block-title float-vertical-button">
                            <span class="verticalMenu-toggle"></span>
                            <span class="verticalMenu-text">Danh mục</span>
                        </h4>
                        <div class="block_content">
                            <div id="verticalmenu" class="verticalmenu" role="navigation">
                                <ul class="nav navbar-nav nav-verticalmenu">
                                    @if(isset($arrDepart) && !empty($arrDepart))
                                        <?php $i = 0;?>
                                        @foreach ($arrDepart as $depart_id =>$depart_name)
                                            @if($i < 7)
                                            <li class="vermenu-option-11">
                                                <a class="link-lv1" href="{{buildLinkProductWithDepart($depart_id,$depart_name)}}" title="{{$depart_name}}">
                                                    <span class="menu-icon">
                                                        <span class="menu-title">{{$depart_name}}</span>
                                                    </span>
                                                </a>
                                            </li>
                                                <?php $i++;?>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                <!--Menu ngang-->
                <div class="col-md-9 bg-header-nav hidden-xs hidden-sm">
                    <div class="relative">
                        <div class="row row-noGutter-2">
                            <nav class="header-nav">
                                <ul class="item_big">
                                    <li class="nav-item ">
                                        <a class="a-img" href="{{buildLinkHome()}}">
                                            <span>Trang chủ</span>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="a-img" href="https://bigboom.exdomain.net/gioi-thieu">
                                            <span>Giới thiệu</span>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="a-img" href="https://bigboom.exdomain.net/san-pham">
                                            <span>Sản phẩm</span>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="a-img" href="https://bigboom.exdomain.net/lien-he">
                                            <span>Liên hệ ngang</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>


<!---benner center-->
@if(isset($action) && $action == STATUS_INT_MOT)
    <div class="container" @if(isset($action) && $action == STATUS_INT_KHONG) style="display: none" @endif>
        <div class="row">
            <div class="section-ss-banner col-md-push-3 col-md-9 col-sm-12 col-xs-12 no-padding">
                <div class="section-ss col-md-8 col-sm-8 col-xs-12" >
                    <link rel="stylesheet"href="{{URL::asset('assets/frontend/shop/a_data/jquery.css')}}">
                    <script src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/jquery_003.js"></script>
                    <div class="home-slider" id="gallery-0">
                        <div class="bx-wrapper" style="max-width: 100%;">
                            <div class="bx-viewport" aria-live="polite" style="width: 100%; overflow: hidden; position: relative;">
                                <div class="slider0" style="width: auto; position: relative;">
                                    <div style="float: none; list-style: outside none none; position: absolute; width: 570px; z-index: 50; display: block;" aria-hidden="false">
                                        <a href="#"><img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/slider-1-593x321.png" alt="" class="img-responsive" style="width: 100%;"></a>
                                    </div>
                                    <div style="float: none; list-style: outside none none; position: absolute; width: 570px; z-index: 50; display: block;" aria-hidden="false">
                                        <a href="#"><img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/bg-top2-570x230.jpg" alt="" class="img-responsive" style="width: 100%;"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        jQuery(document).ready(function () {
                            jQuery('.slider0').bxSlider({
                                auto: true,
                                mode: 'fade',
                                speed: 400,
                                responsive: true,
                                pause: 5000,
                                pager: false,
                                controls: false
                            });
                        });
                    </script>
                </div>
                <div class="banner-right-one banner-item banner-right col-md-4 col-sm-4 hidden-xs" style="max-height: 350px; overflow: hidden">
                    <div class=" " id="banner_default-1837408231" style="height: 310px; overflow: hidden">
                        <a href="javascript:void(0)" title="">
                            <img class="img-responsive" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/ss-banner-img-1-287x485.jpg" alt="" >
                            <div class="hover_collection"></div>
                        </a></div>
                </div>
            </div>
        </div>
    </div>
@endif
@stop

