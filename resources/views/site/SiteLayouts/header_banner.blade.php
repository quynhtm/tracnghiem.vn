@section('headerBanner')
    <div class="container">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $('.slider0').bxSlider({
                            /* Tu dong chuyen anh */
                            auto: true,
                            /* Hieu ung chuyen anh: 'horizontal', 'vertical', 'fade' */
                            mode: 'fade',
                            /* Toc do chuyen giua cac anh: (ms) */
                            speed: 400,
                            /* Ho tro hien thi da man hinh */
                            responsive: true,
                            /* Thoi gian hien thi 1 anh (ms) */
                            pause: 5000,
                            /* Cac cham dai dien anh: o o o */
                            pager: true,
                            /* Mui ten next va prev */
                            controls: true
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
@stop