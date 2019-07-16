@section('footer')
    <div class="col-xs-12">
        <div class="row">
            <!--Sologan--->
            <section class="awe-section-10 " id="service-1940976339">
                <section class="section_service_end">
                    <div class="container">
                        <div class="row row-noGutter-2">
                            <div class="col-item-srv col-md-4 col-sm-12 col-xs-12">
                                <div class="service_item_ed">
                                    <span class="iconx"><img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/srv-1-0x0.png" alt="Giao hàng toàn quốc" class="fa"></span>
                                    <div class="content_srv">
                                        <span class="title_service">Giao hàng toàn quốc</span>
                                        <span class="content_service">Miễn phí với đơn hàng trị giá trên 800.000đ</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-item-srv col-md-4 col-sm-12 col-xs-12">
                                <div class="service_item_ed">
                                    <span class="iconx"><img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/srv-2-0x0.png"alt="Hoàn tiền 100%" class="fa"></span>
                                    <div class="content_srv">
                                        <span class="title_service">Hoàn tiền 100%</span>
                                        <span class="content_service">Hoàn tiền 100% đối với sản phẩm bị lỗi</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-item-srv col-md-4 col-sm-12 col-xs-12">
                                <div class="service_item_ed">
                                    <span class="iconx"><img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/a_data/srv-3-0x0.png" alt="Sản phẩm chính hãng 100%" class="fa"></span>
                                    <div class="content_srv">
                                        <span class="title_service">Sản phẩm chính hãng 100%</span>
                                        <span class="content_service">Sản phẩm được nhập khẩu chính hãng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </div>
        <script>
            $(document).ready(function () {
                if ($(window).width() > 991) {
                    @if(isset($action) && $action == STATUS_INT_MOT)
                        $('#section-verticalmenu').addClass('active');
                    @endif
                    $('#column-left').css('padding-top', $('.float-vertical.active .block_content').height() - $('.section-ss-banner').height() + 20);
                }
                $(window).resize(function () {
                    if ($(window).width() > 991) {
                        @if(isset($action) && $action == STATUS_INT_MOT)
                            $('#section-verticalmenu').addClass('active');
                        @endif
                        $('#column-left').css('padding-top', $('.float-vertical.active .block_content').height() - $('.section-ss-banner').height() + 20);
                    } else {
                        $('#section-verticalmenu').removeClass('active');
                        $('#column-left').css('padding-top', 0);
                    }
                });
            });
        </script>
    </div>

    <footer class="footer">
        <div class="site-footer">
            <div class="top-footer mid-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-7 col-md-4 width-320">
                            <h4 class="title-menu"
                                style="font-family: Roboto, HelveticaNeue, 'Helvetica Neue', sans-serif; font-weight: bold; line-height: normal; color: #363636; margin: 40px 0px 30px; font-size: 16px; letter-spacing: 0.5px; cursor: default; position: relative; background-color: #f5f5f5;">
                                Hệ thống cửa hàng</h4>
                            <h4 class="title-menu4 icon_none_first"
                                style="font-family: Roboto, HelveticaNeue, 'Helvetica Neue', sans-serif; line-height: normal; color: #ffffff; margin: 10px 0px 5px; font-size: 1.28571em; letter-spacing: 0.5px; position: relative;">
                                <a style="background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: #707070; transition: all 150ms ease-in-out; font-weight: bold; cursor: default; font-size: 14px; position: relative;">Tại
                                    Hà Nội</a></h4>
                            <div id="collapseListMenu01" class="collapse1"
                                 style="color: #555555; font-family: Roboto, HelveticaNeue, 'Helvetica Neue', sans-serif; font-size: 14px; text-transform: none; background-color: #f5f5f5;">
                                <div class="list-menu" style="line-height: 30px;">
                                    <div class="widget-ft wg-logo" style="margin-bottom: 20px;">
                                        <div class="item">
                                            <ul class="contact contact_x"
                                                style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; list-style: none outside;">
                                                <li style="font-family: Arial, sans-serif; position: relative; color: #707070; margin-bottom: 20px; line-height: 20px;">
                                                    <span class="txt_content_child" style="display: inherit;">A12 Đinh Tiên Hoàng, Quận Hoàn Kiếm, Hà Nội</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="title-menu4 icon_none_first"
                                style="font-family: Roboto, HelveticaNeue, 'Helvetica Neue', sans-serif; line-height: normal; color: #ffffff; margin: 10px 0px 5px; font-size: 1.28571em; letter-spacing: 0.5px; position: relative;">
                                <a style="background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: #707070; transition: all 150ms ease-in-out; font-weight: bold; cursor: default; font-size: 14px; position: relative;">Tại
                                    Hồ Chí Minh</a></h4>
                            <div class="collapse1"
                                 style="color: #555555; font-family: Roboto, HelveticaNeue, 'Helvetica Neue', sans-serif; font-size: 14px; text-transform: none; background-color: #f5f5f5;">
                                <div class="list-menu" style="line-height: 30px;">
                                    <div class="widget-ft wg-logo" style="margin-bottom: 20px;">
                                        <div class="item">
                                            <ul class="contact contact_x"
                                                style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; list-style: none outside;">
                                                <li style="font-family: Arial, sans-serif; position: relative; color: #707070; margin-bottom: 20px; line-height: 20px;">
                                                    <span class="txt_content_child" style="display: inherit;">Số 123, KP2, Quận 1, Tp.Hồ Chí Minh</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-3">
                            <div class="widget-ft">
                                <h4 class="title-menu tittle_time">Điện thoại:</h4>
                                <div class="time_work">
                                    <ul class="list-menu">
                                        <li class="li_menu li_menu_xxx">
                                            <a class="rc yeloww" href="tel:0123456789">0123456789</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix visible-sm"></div>
                        <div class="col-xs-12 col-sm-5 col-md-2 width-320">
                            <div class="widget-ft">
                                <h4 class="title-menu">Thông tin</h4>
                                <div class="collapse1" id="collapseListMenu02">
                                    <ul class="list-menu list-menu22">
                                        <li class="li_menu">
                                            <a href="https://bigboom.exdomain.net/gioi-thieu">Giới thiệu</a>
                                        </li>
                                        <li class="li_menu">
                                            <a href="https://bigboom.exdomain.net/van-chuyen">Chính sách vận chuyển</a>
                                        </li>
                                        <li class="li_menu">
                                            <a href="https://bigboom.exdomain.net/quy-dinh">Quy định &amp; Chính sách</a>
                                        </li>
                                        <li class="li_menu">
                                            <a href="https://bigboom.exdomain.net/chinh-sach-bao-mat">Chính sách bảo mật</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-7 col-md-3">
                            chua co gi
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <a href="#" id="back-to-top" class="backtop show" title="TOP"><i class="fa fa-angle-up"
                                                                             aria-hidden="true"></i></a>
        </div>
    </footer>
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/social_login_button.css')}}">
    <!-- Show Popup Cart -->
    <button id="btn_show_cart" type="button" class="btn btn-primary" data-toggle="modal"
            data-target=".bs-popupcart-modal-lg" style="display: none;"></button>
    <div class="modal fade bs-popupcart-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×
                        </span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Giỏ
                        hàng </h4>
                </div>
                <div class="modal-body" id="load_info_cart"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tiếp tục mua hàng</button>
                    <a href="https://bigboom.exdomain.net/index.php?route=checkout/checkout" class="btn btn-primary">Tiến
                        hành thanh toán</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        /* Sau khi tat khung popup cart, cap nhat lai gio hang tren header */
        $('.bs-popupcart-modal-lg').on('hidden.bs.modal', function (e) {
            $.ajax({
                url: 'index.php?route=checkout/cart/getTotalProductInCart',
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (json) {
                    var out = json['total'].substr(0, json['total'].indexOf(' '));
                    $('#cart-total').html(out);
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            });
        });
    </script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/sdk_002.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/jquery_004.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/option-selectors.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/api.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/owl.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/cs.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/appear.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/main.js')}}"></script>

    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/jquery_002.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/jquery_006.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/jquery_005.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/common.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/custom.js')}}"></script>
@stop