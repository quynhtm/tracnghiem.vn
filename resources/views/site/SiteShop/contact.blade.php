@extends('site.SiteLayouts.index')
@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home"><a href="{{buildLinkHome()}}"> <span><i class="fa fa-home"></i> Trang chủ</span>
                            </a> <span><i class="fa">/</i></span></li>
                        <li><strong>Liên hệ với chúng tôi</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="margin-top-0">
        <div class="container contact-page">
            <div class="row">
                <div id="content" class="col-sm-12 col-xs-12 col-md-12">
                    <div class="row"><h1 class="title-section-page hidden">Liên hệ với chúng tôi</h1>
                        <div class="section_maps col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: none">
                            <div class="box-maps">
                                <div class="iFrameMap">
                                    <div class="google-map">
                                        <div id="contact_map" class="map">
                                            <style> .container_iframe_google_map iframe {
                                                    width: 100% !important;
                                                    height: 300px !important;
                                                } </style>
                                            <div class="container_iframe_google_map">
                                                <iframe src="Li%C3%AAn%20h%E1%BB%87_files/embed.html" style="border:0"
                                                        allowfullscreen="" width="600" height="450"
                                                        frameborder="0">

                                                </iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 margin-top-30">
                            <div class="page_cotact"><h2 class="title-head-contact a-left">
                            <span>Địa chỉ của chúng tôi</span></h2></div>
                            <div class="content">
                                <div class="intro"><span><strong>Shopcuatui.com.vn</strong></span></div>
                                <div class="item_contact">
                                    <div class="body_contact">
                                        <span class="contact_info">
                                            <span>
                                                <strong>Địa chỉ: </strong> 247 Cầu Giấy, Hà Nội
                                            </span>
                                        </span>
                                    </div>
                                    <div class="body_contact item_2_contact">
                                        <span class="contact_info">
                                            <strong>Điện thoại:</strong>
                                            <a href="tel:0123456789">0123456789</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 margin-top-30">
                            <div class="page-login page_cotact"><h2 class="title-head-contact a-left"><span>Thông tin liên hệ</span>
                                </h2>
                                <div id="pagelogin">
                                    <form action="{{URL::route('site.contactShop')}}" method="post" enctype="multipart/form-data" class="" id="contact">
                                        <div class="form-signup clearfix">
                                            <div class="row group_contact">
                                                <fieldset class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <input type="text" name="contact_user_name_send" id="contact_user_name_send" class="form-control form-control-lg" required="" placeholder="Tên của bạn">
                                                </fieldset>
                                                <fieldset class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <input type="text" name="contact_phone_send" class="form-control form-control-lg" placeholder="Số điện thoại" id="contact_phone_send" required="">
                                                </fieldset>
                                                <fieldset class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <input type="text" name="contact_email_send" class="form-control form-control-lg" placeholder="Địa chỉ Email" id="contact_email_send" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" data-validation="email" required="">
                                                </fieldset>
                                                <fieldset class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <input type="text" name="contact_title" class="form-control form-control-lg" placeholder="Tiêu đề liên hệ" id="contact_title" required="">
                                                </fieldset>
                                                <fieldset class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <textarea name="contact_content" rows="5" id="contact_content" placeholder="Nội dung" class="form-control content-area form-control-lg"  required=""></textarea>
                                                </fieldset>
                                                <fieldset class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"></fieldset>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-10">
                                                    <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop