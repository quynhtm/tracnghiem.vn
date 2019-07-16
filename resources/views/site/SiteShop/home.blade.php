@extends('site.SiteLayouts.index')
@section('content')
    <div class="container">
        <div class="row">
            <div id="content" class="col-sm-12 col-xs-12 col-md-12">
                <div class="row">

                    <!--List danh sách sản phẩm--->
                    @if($arrProductHome != null)
                        @foreach($arrProductHome as $depart_id=>$val_depart)
                            @if(!empty($val_depart['product']))
                                <section class="awe-section-3 " id="category_custom-1">
                                    <section class="section_like_product">
                                        <div class="container">
                                            <div class="row row-noGutter-2">
                                                <div class="heading tab_link_module">
                                                    <h2 class="title-head pull-left">
                                                        <span>
                                                            <a href="{{buildLinkProductWithDepart($depart_id,$val_depart['depart_name'])}}" title="{{$val_depart['depart_name']}}" style="background:none">
                                                                {{$val_depart['depart_name']}}
                                                            </a>
                                                        </span>
                                                    </h2>
                                                    {{--
                                                    Option danh muc con
                                                    <div class="tabs-container tab_border pull-right">
                                                        <span class="hidden-md hidden-lg button_show_tab">
                                                            <i class="fa fa-caret-down"></i>
                                                        </span>
                                                        <span class="hidden-md hidden-lg title_check_tabs">Kính mắt thời trang</span>
                                                        <div class="clearfix">
                                                            <ul class="ul_link link_tab_check_click">
                                                                <li class="li_tab">
                                                                    <a href="#content-tabb10" class="head-tabs head-tab10 active"
                                                                       data-src=".head-tab10">Kính mắt thời trang</a>
                                                                </li>
                                                                <li class="li_tab">
                                                                    <a href="#content-tabb11" class="head-tabs head-tab11"
                                                                       data-src=".head-tab11">Thời trang nam</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>--}}

                                                    <div class="tabs-content tabs-content-featured col-md-12 col-sm-12 col-xs-12 no-padding">
                                                        <div id="content-tabb10" class="content-tab content-tab-proindex" style="">
                                                            <div class="row">
                                                                @foreach($val_depart['product'] as $key=>$item)
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
                            @endif
                        @endforeach
                    @endif


                    <!---Quảng cáo-->
                    <section class="awe-section-2">
                        <div class="sec_banner hidden-sm hidden-xs">
                            <div class="container">
                                <div class="row vc_row-flex">
                                    <div class="vc_column_container col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="vc_column-inner">
                                            <div class="wpb_wrapper">
                                                <div class="row vc_row-flex">
                                                    <div class="banner-item banner-right col-md-6 col-sm-6 col-xs-12 "
                                                         id="banner_default-440372316">
                                                        <a href="javascript:void(0)" title="">
                                                            <img class="img-responsive" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/bg-top1-570x230.jpg" alt="">
                                                            <div class="hover_collection"></div>
                                                        </a></div>
                                                    <div class="banner-item banner-right col-md-6 col-sm-6 col-xs-12 "
                                                         id="banner_default-750409766">
                                                        <a href="javascript:void(0)" title="">
                                                            <img class="img-responsive" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/bg-top2-570x230.jpg" alt="">
                                                            <div class="hover_collection"></div>
                                                        </a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
@stop