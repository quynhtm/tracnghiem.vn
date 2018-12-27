<?php
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\FunctionLib;
use Illuminate\Support\Facades\Session;
use App\Stringee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>{!! CGlobal::$pageAdminTitle !!}</title>

    <meta name="description" content="overview &amp; stats"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- bootstrap & fontawesome -->
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.min.css')}}"/>
    <link media="all" type="text/css" rel="stylesheet"
          href="{{URL::asset('assets/lib/font-awesome/4.2.0/css/font-awesome.min.css')}}"/>

    <!-- page specific plugin styles -->

    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/jquery-ui.min.css')}}"/>
    <!-- text fonts -->
    {{--<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/fonts/fonts.googleapis.com.css')}}" />--}}

    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/chosen.min.css')}}"/>
    <!-- ace styles -->
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/ace.min.css')}}"/>
    <!--[if lte IE 9]>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/ace-part2.min.css')}}"/>
    <![endif]-->

    <!--[if lte IE 9]>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/ace-ie.min.css')}}"/>
    <![endif]-->

    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/css/admin_css.css')}}"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/css/vaymuon.min.css')}}"/>
    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="{{URL::asset('assets/js/ace-extra.min.js')}}"></script>

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <link media="all" type="text/css" rel="stylesheet"
          href="{{URL::asset('assets/lib/datetimepicker/datetimepicker.css')}}"/>

    <!--[if lte IE 8]>
    <script src="{{URL::asset('assets/js/html5shiv.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/respond.min.js')}}"></script>
    <![endif]-->
    <script type="text/javascript">
        var WEB_ROOT = "{{URL::to('/')}}";
    </script>
    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="{{URL::asset('assets/js/jquery.2.1.1.min.js')}}"></script>
    <!--[if IE]>
    <script src="{{URL::asset('assets/js/jquery.1.11.1.min.js')}}"></script>
    <![endif]-->

    <script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/ace-elements.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/chosen.jquery.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.ui.touch-punch.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/ace.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/ace-elements.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/moment.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/bootbox.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/admin.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/jquery.elevatezoom.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/number.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/format.js')}}"></script>
    <script src="{{URL::asset('assets/lib/datetimepicker/jquery.datetimepicker.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/hr.js')}}"></script>

    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/lib/upload/cssUpload.css')}}"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/lib/jAlert/jquery.alerts.css')}}"/>

    <script src="{{URL::asset('assets/lib/upload/jquery.uploadfile.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/baseUpload.js')}}"></script>
    <script src="{{URL::asset('assets/lib/jAlert/jquery.alerts.js')}}"></script>


    {!!CGlobal::$extraHeaderCSS!!}
    {!!CGlobal::$extraHeaderJS!!}

    <script type="text/javascript" src="{{URL::asset('assets/lib/ckeditor/ckeditor.js')}}"></script>
</head>

<body class="no-skin" @if($languageSite == VIETNAM_LANGUAGE) lang="vi"
      @else lang="en" @endif>
<div id="navbar" class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-container" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-header pull-left">
            <a href="{{URL::route('admin.dashboard')}}" class="navbar-brand">
                <small class="rlt3" style="text-transform: uppercase;font-size: 14px;">
                    <i class="fa fa-usd fa-2x"></i>
                    {{CGlobal::web_name}}
                </small>
            </a>
        </div>
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a class="dropdown-toggle" href="#" title="Góp ý - Thắc mắc về hệ thống">
                        <i class="fa fa-clipboard fa-2x marginTop5" aria-hidden="true">

                        </i>
                    </a>
                </li>
                <li class="light-blue">
                    <a class="dropdown-toggle" href="#">
                        <i class="fa fa-envelope-o fa-2x marginTop5" aria-hidden="true">
                            @if(isset($newMailInbox) && $newMailInbox > 0)<span class="msg_notify">{{$newMailInbox}}</span>@endif
                        </i>
                    </a>
                </li>
                <li class="light-blue" style="display: none">
                    <a class="dropdown-toggle" href="#">
                        <i class="fa fa-bell-o fa-2x marginTop5" aria-hidden="true">
                            <span class="msg_notify">13</span>
                        </i>
                    </a>
                </li>
                <li class="light-blue" style="display: none">
                    <a class="dropdown-toggle" href="#">
                        <i class="fa fa-bell-o fa-2x marginTop5" aria-hidden="true">
                            <span class="msg_notify">13</span>
                        </i>
                    </a>
                </li>
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/vi.png"/>
                        @else
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/en.png"/>
                        @endif
                    </a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close" style="display: none">
                        @if(isset($languageSite) && $languageSite == ENGLISH_LANGUAGE)
                            <li>
                                <a href="{{URL::route('admin.dashboard',array('lang'=>VIETNAM_LANGUAGE))}}">
                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/vi.png"/>
                                    Viet Nam
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{URL::route('admin.dashboard',array('lang'=>ENGLISH_LANGUAGE))}}">
                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/en.png"/>
                                    English
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @if(isset($user) && isset($user['user_id']))
                <li class="light-blue">

                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <span class="user-info" style="top: 10px!important;">
                            <small>{{viewLanguage('hello')}},</small>
                            @if(isset($user) && isset($user['user_full_name']))
                                {{$user['user_full_name']}}
                            @endif
                            @if(isset($user) && isset($user['user_image']) && trim($user['user_image']) != '')
                                <img src="{{env('APP_URL').env('APP_PATH_UPLOAD_MIDDLE').$user['user_image']}}" height="40" width="40" style="border-radius: 20px; overflow: hidden;"/>
                            @endif
                        </span>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="{{URL::route('admin.user_change',array('id' => setStrVar($user['user_id'])))}}">
                                <i class="ace-icon fa fa-unlock"></i>
                                {{viewLanguage('changePass')}}
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{URL::route('admin.logout')}}">
                                <i class="ace-icon fa fa-power-off"></i>
                                {{viewLanguage('logout')}}
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="main-container" id="main-container">
    <div id="sidebar" class="sidebar sidebar-fixed sidebar-scroll responsive">
        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <a href="{{URL::route('admin.dashboard')}}" title="CMS Admin"><img width="100%" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/img/logoCustomer.png" alt="CMS Admin"/></a>
            </div>
            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>
                <span class="btn btn-info"></span>
                <span class="btn btn-warning"></span>
                <span class="btn btn-danger"></span>
            </div>
        </div>
        <ul class="nav nav-list">
            @if(!empty($menu))
                @foreach($menu as $key => $item)
                    @if($is_boss || $item['show_menu'] == STATUS_SHOW)
                        @if($item['parent_id'] == STATUS_HIDE && $item['menu_type'] == STATUS_SHOW)
                            <li class="@if(trim($item['RouteName']) !='' && Route::currentRouteName()==$item['RouteName'])active @endif">
                                <a href="@if(trim($item['RouteName']) !== '#'){{URL::route($item['RouteName'])}}@endif" class="">
                                    <i class="menu-icon {{$item['icon']}}"></i>
                                    <span class="menu-text">
                                        @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                            {{ $item['name'] }}
                                        @else
                                            {{ $item['name_en'] }}
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @else
                            <li class="@if(!empty($item['arr_link_sub']) && in_array(Route::currentRouteName(),$item['arr_link_sub']))active @endif">
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon {{$item['icon']}}"></i>
                                    <span class="menu-text">
                                    @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                        {{ $item['name'] }}
                                    @else
                                        {{ $item['name_en'] }}
                                    @endif
                                </span>
                                    <b class="arrow fa fa-angle-down"></b>
                                </a>
                                <b class="arrow"></b>
                                <ul class="submenu">
                                    @if(isset($item['sub']) && !empty($item['sub']))
                                        @foreach($item['sub'] as $sub)
                                            @if($is_boss || (!empty($aryPermissionMenu) && in_array($sub['menu_id'],$aryPermissionMenu)))
                                                <li class="@if(strcmp(Route::currentRouteName(),$sub['RouteName']) == 0) active @endif">
                                                    <a href="{{URL::route($sub['RouteName'])}}">
                                                        <i class="menu-icon fa fa-caret-right"></i>
                                                        @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                                            {{ $sub['name'] }}
                                                        @else
                                                            {{ $sub['name_en'] }}
                                                        @endif
                                                    </a>
                                                    <b class="arrow"></b>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif
        </ul>
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
               data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
        <script type="text/javascript">
            try {
                ace.settings.check('sidebar', 'collapsed')
            } catch (e) {
            }
        </script>
        {!! csrf_field() !!}
    </div>

    <div class="main-content" style="position: relative">
        {{---Menu tab top--}}
        <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs" style="top: auto!important;">
            <ul class="breadcrumb">
                @foreach($arrMenuTabTop as $key_tab => $name_tab)
                    <li class="li-nav-top @if(isset($tab_top) && $tab_top == $key_tab) active @endif" >
                        <a href="{{URL::route('admin.dashboard',['tab_top'=> $key_tab])}}">{{$name_tab}}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="content-new">
            @if (Session::has('status') && Session::get('status') != '')
                <div class="alert alert-success">
                    {!! Session::get('status') !!} @php Session::forget('status'); @endphp
                </div>
            @endif
                @if (Session::has('status_error') && Session::get('status_error') != '')
                <div class="alert alert-danger">
                    {!! Session::get('status_error') !!} @php Session::forget('status_error'); @endphp
                </div>
            @endif
            @yield('content')
        </div>

    </div>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-info">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-300"></i>
    </a>
</div>
{{--MODAL UPLOAD/DOWNLOAD EXCEL--}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="modal fade" id="modal-csv-upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" name="url-ajax" id="url-ajax">
            <input type="hidden" name="element" id="element">
            <div class="modal-header">
                <button type="button" class="close bt_close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"
                    id="myModalLabel">{{viewLanguage('csv_download_upload')}}</h4>
            </div>
            <div class="modal-body" id="ajax-csv-upload">
                <form method="post" id="form-csv-upload" class="form-inline" enctype="multipart/form-data">
                    <div class="alert alert-info mg-b30 center">
                        {{viewLanguage('lg_txt_member_modal_csv_upload01')}}
                        {{viewLanguage('lg_txt_member_modal_csv_upload02')}}
                    </div>

                    <div class="alert alert-warning center">
                        <div class="mg-t30">
                            <input type="file" id="csv_file" name="csv" style="display: none;" onchange="upload_csv();"
                                   accept="text/csv">
                            <button type="button" class="btn btn-lg btn-warning" onClick="$('#csv_file').click();"><i
                                        class="fa fa-cloud-upload"></i>{{viewLanguage('csv_upload')}}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default bt_close" data-dismiss="modal">close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{---Popup common--}}
<div class="modal fade" id="sys_showPopupCommon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width: 850px">
        <div class="modal-content" id="sys_show_infor">

        </div>
    </div>
</div>

<!--Popup Upload File-->
<div class="modal fade" id="sys_PopupUploadFileCommon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tải tệp đính kèm</h4>
            </div>
            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                    <div class="form_group">
                        <div id="sys_show_button_upload_file">
                            <div id="sys_mulitplefileuploaderFile" class="btn btn-primary">Tải tệp đính kèm</div>
                        </div>
                        <div id="status_file"></div>

                        <div class="clearfix"></div>
                        <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                            <div id="div_image_file"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Popup Upload File-->

<script>
    $(document).ready(function() {
        // document is loaded and DOM is ready
        @if(!$is_tech)
        $('.phpdebugbar-restore-btn').css('display','none');
        @endif
    });
    function showModal(event) {
        var url = event.getAttribute('ajax_url');
        var element = event.getAttribute('element');
        $("#url-ajax").val(url);
        $("#element").val(element);
    }

    function upload_csv() {
        if (confirm(lng['lg_txt_member_modal_csv_upload03'])) {
            var form_data = new FormData($("#form-csv-upload").get()[0]);
            var url = $("#url-ajax").val();
            var element = $("#element").val();

            $.ajax({
                url: WEB_ROOT+url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: form_data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'html',
                xhr: function () {
                    XHR = $.ajaxSettings.xhr();
                    if (XHR.upload) {
                        XHR.upload.addEventListener('progress', function (e) {
                            $("#overlay").fadeIn();
                            progress = parseInt(e.loaded / e.total * 10000) / 100;
                            $('#overlay_progress').css('width', progress + '%');
                        }, false);
                    }
                    return XHR;
                }
            })
                .done(function (data) {
//                    debugger
                    if (data != "") {
                        $(element).html(data)
                        $("#modal-csv-upload").hide()
                        $("#overlay").fadeOut(function () {
                            $("#csv_file").val("");
                        });
                    }
                })
                .fail(function (data) {
                    alert("Something error");
                })
                .always(function (data) {
                    $("#overlay").fadeOut();
                });
        }
    }
</script>
<script>
    $(function () {
        $(".zoom_07").on('click',function () {
            $('.zoom_07').elevateZoom({
                zoomType: "lens",
                lensShape : "round",
                lensSize    : 400
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Set up the number formatting.
        $('.format_money').number( true, 0);

        //click view detail
        $( ".detailView" ).dblclick(function() {
            var url = $(this).attr( "data-action" );
            window.open(url);
            //window.location.href = url;
        });
    })
</script>
{!!CGlobal::$extraFooterCSS!!}
{!!CGlobal::$extraFooterJS!!}
<div id="loading"><div class="sts"></div></div>
</body>
</html>
