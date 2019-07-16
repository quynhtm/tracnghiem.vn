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
                        @if(isset($departName) && isset($departId))
                        <li>
                            <a href="{{buildLinkProductWithDepart($departId,$departName)}}">
                                <span>{{$departName}}</span>
                            </a>
                            <span><i class="fa">/</i></span>
                        </li>
                        @endif
                        @if(isset($titleSearchName))
                        <li><strong>{{$titleSearchName}}</strong></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="main-category-page col-md-12 col-sm-12 col-xs-12 no-padding">

                <!--List sản phẩm tìm kiếm-->
                @if(isset($dataSearch) && !empty($dataSearch))
                <div id="content" class="col-sm-12 col-xs-12 @if(isset($is_category) && $is_category == STATUS_INT_KHONG) col-md-9 col-md-push-3 @endif  section-main-products padding-small main_container collection margin-bottom-30">
                    <section class="awe-section-3 " id="category_custom-1" @if(isset($is_category) && $is_category == STATUS_INT_KHONG)style="border-left: 2px solid #FF5622" @endif>
                        <section class="section_like_product">
                            <div class="container">
                                <div class="row row-noGutter-2">
                                    <div class="heading tab_link_module">
                                        <h2 class="title-head pull-left">
                                            <span>@if(isset($titleSearchName)){{$titleSearchName}} ({{$total}})@endif</span>
                                        </h2>
                                        <!--item show-->
                                        <div class="tabs-content tabs-content-featured col-md-12 col-sm-12 col-xs-12 no-padding">
                                            <div id="content-tabb10" class="content-tab content-tab-proindex" style="">
                                                <div class="row">
                                                    @foreach($dataSearch as $key=>$item)
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
                                                                            @if(isset($is_category) && $is_category == STATUS_INT_KHONG)
                                                                                <span class="product-category">
                                                                                    <a href="{{buildLinkProductWithCategory($item->category_id, $item->category_name)}}" title="Danh sách sản phẩm {{$item->category_name}}">{{$item->category_name}}</a>
                                                                                </span>
                                                                            @endif
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
                                                <div style="clear: both">
                                                    {!! $paging !!}
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

                <!--List danh mục-->
                @if(isset($dataCateWithDepart) && !empty($dataCateWithDepart))
                <div class="col-sm-12 col-xs-12 col-md-3 sidebar section-main-sidebar padding-small margin-bottom-50 clearfix col-md-pull-9">
                    <aside id="column-left" class="left-column compliance dqdt-sidebar sidebar left-content article-sidebar left">
                        <aside class="aside-item sidebar-category collection-category " id="product_category-1">
                            <div class="aside-title">
                                <h2 class="title-head margin-top-0"><span>Danh mục</span></h2>
                            </div>
                            <div class="aside-content">
                                <nav class="nav-category navbar-toggleable-md">
                                    <ul class="nav navbar-pills">
                                        @foreach($dataCateWithDepart as $cat_id=>$val_cate)
                                        <li class="nav-item lv1">
                                            <a class="nav-link " href="{{buildLinkProductWithCategory($val_cate['category_id'],$val_cate['category_name'])}}">
                                                {{$val_cate['category_name']}} ({{$val_cate['total_cate']}})
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </aside>
                    </aside>
                    <div class="banner-right-one banner-item banner-right col-md-12 col-sm-12 hidden-xs">
                        <div class=" " id="banner_default-1837408231">
                            <a href="javascript:void(0)" title="">
                                <img class="img-responsive" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/ss-banner-img-1-287x485.jpg" alt="" >
                                <div class="hover_collection"></div>
                            </a>
                        </div>
                        <div style="margin-top: 10px" id="banner_default-18374082312">
                            <a href="javascript:void(0)" title="">
                                <img class="img-responsive" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/ss-banner-img-1-287x485.jpg" alt="" >
                                <div class="hover_collection"></div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@stop