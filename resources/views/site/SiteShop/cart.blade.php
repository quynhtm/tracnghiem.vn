@extends('site.SiteLayouts.index')
@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home"><a href="https://bigboom.exdomain.net/"> <span><i class="fa fa-home"></i> Trang chủ</span>
                            </a> <span><i class="fa">/</i></span></li>
                        <li><strong>Giỏ hàng</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div id="content" class="col-sm-12 col-xs-12 col-md-12">
                <div class="page-information margin-bottom-50"><h1 class="title-section-page">Giỏ hàng</h1>
                    <form action="https://bigboom.exdomain.net/checkout/cart/edit" method="post"
                          enctype="multipart/form-data">
                        <div class="table-responsive table-cart-content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td class="text-center"><strong>Ảnh</strong></td>
                                    <td class="text-center"><strong>Sản phẩm</strong></td>
                                    <td class="text-center"><strong>Đơn giá</strong></td>
                                    <td class="text-center"><strong>Số lượng</strong></td>
                                    <td class="text-center"><strong>Tổng</strong></td>
                                    <td class="text-center"><strong>Xóa</strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-center"><img
                                                src="Gi%E1%BB%8F%20h%C3%A0ng_files/dong-ho-bruno-sohnle-100x100.png"
                                                alt="Đồng hồ bruno-sohnle" title="Đồng hồ bruno-sohnle" width="100"></td>
                                    <td class="text-left"><a href="https://bigboom.exdomain.net/dong-ho-bruno-sohnle">Đồng
                                            hồ bruno-sohnle</a></td>
                                    <td class="text-right"> 12,500,000đ</td>
                                    <td class="text-left">
                                        <div class="input-group btn-block"><span class="input-group-btn"> <button
                                                        onclick="var result = document.getElementById('qtyItem1654'); var qtyItem = result.value; if(!isNaN(qtyItem) &amp;&amp; qtyItem > 1) result.value--; return false;"
                                                        class="btn items-count btn-minus" type="button">– </button> </span> <input
                                                    type="text" name="quantity[1654]" value="1" size="4" id="qtyItem1654"
                                                    class="form-control input-text text-center number-sidebar input_pop input_pop"
                                                    style="padding: 0; min-width: 90px"> <span class="input-group-btn"> <button
                                                        onclick="var result = document.getElementById('qtyItem1654'); var qtyItem = result.value; if(!isNaN(qtyItem)) result.value++; return false;"
                                                        class="btn items-count btn-plus" type="button">+ </button> </span></div>
                                    </td>
                                    <td class="text-right"> 12,500,000đ</td>
                                    <td class="text-center">
                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-danger"
                                                onclick="cart.remove('1654');" data-original-title="Xóa"><i
                                                    class="fa fa-times-circle"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><img src="Gi%E1%BB%8F%20h%C3%A0ng_files/gs217003-100x100.jpg"
                                                                 alt="Kính Mát Nam GOLDSUN GS217003 S1 "
                                                                 title="Kính Mát Nam GOLDSUN GS217003 S1 " width="100"></td>
                                    <td class="text-left"><a
                                                href="https://bigboom.exdomain.net/kinh-mat-nam-goldsun-gs217003-s1">Kính Mát
                                            Nam GOLDSUN GS217003 S1 </a></td>
                                    <td class="text-right"> 660,000đ</td>
                                    <td class="text-left">
                                        <div class="input-group btn-block"><span class="input-group-btn"> <button
                                                        onclick="var result = document.getElementById('qtyItem1655'); var qtyItem = result.value; if(!isNaN(qtyItem) &amp;&amp; qtyItem > 1) result.value--; return false;"
                                                        class="btn items-count btn-minus" type="button">– </button> </span> <input
                                                    type="text" name="quantity[1655]" value="1" size="4" id="qtyItem1655"
                                                    class="form-control input-text text-center number-sidebar input_pop input_pop"
                                                    style="padding: 0; min-width: 90px"> <span class="input-group-btn"> <button
                                                        onclick="var result = document.getElementById('qtyItem1655'); var qtyItem = result.value; if(!isNaN(qtyItem)) result.value++; return false;"
                                                        class="btn items-count btn-plus" type="button">+ </button> </span></div>
                                    </td>
                                    <td class="text-right"> 660,000đ</td>
                                    <td class="text-center">
                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-danger"
                                                onclick="cart.remove('1655');" data-original-title="Xóa"><i
                                                    class="fa fa-times-circle"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" data-toggle="tooltip" title="" class="btn btn-primary pull-right"
                                style="margin-bottom: 20px;" data-original-title="Cập nhật"><i class="fa fa-refresh"></i>
                            Update
                        </button>
                    </form>
                    <div class="row">
                        <div class="col-sm-12"></div>
                        <div class="col-sm-4 col-sm-offset-8">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td class="text-right">Thành tiền:</td>
                                    <td class="text-right"><strong>13,160,000đ</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Phí vận chuyển được tính khi xử lý đơn hàng:</td>
                                    <td class="text-right"><strong>0đ</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Tổng số:</td>
                                    <td class="text-right"><strong>13,160,000đ</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6 col-xs-6 col_button_shopping"><a href="https://bigboom.exdomain.net/"
                                                                                      class="btn btn-default pull-left button_shopping">Tiếp
                                        tục mua hàng</a></div>
                                <div class="col-sm-6 col-xs-6 col_button_checkout"><a
                                            href="https://bigboom.exdomain.net/checkout/state"
                                            class="btn btn-primary pull-right button_checkout">Tiến hành thanh toán</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop