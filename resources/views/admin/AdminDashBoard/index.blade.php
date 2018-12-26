<?php use App\Library\AdminFunction\CGlobal; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\FunctionLib; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-header">
                    <h3 class="box-title" style="text-align: center; color:#438eb9">{{CGlobal::web_title_dashboard}} </h3>
                </div>
                @if(isset($error) && !empty($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p><b>{{ $itmError }}</b></p>
                        @endforeach
                    </div>
                @endif
                <div class="box-body" style="margin-top: 35px">
                    @if($is_root)
                    {{--<div class="col-sm-6 col-md-3">
                        <a class="quick-btn a_control"  href="http://beta4.vaymuon.vn/QuynhtmMysql.php?user={{setStrVar($user['user_id'])}}&permit={{setStrVar(date('Ymd',time()))}}">
                            <div class="thumbnail text-center">
                                <i class="fa fa-database fa-5x"></i>
                                <br>
                                Database
                            </div>
                        </a>
                    </div>--}}
                    @endif

                    @if(!empty($menu))
                        @foreach($menu as $item)
                            @if(isset($item['sub']) && !empty($item['sub']))
                                <!-- menu sub-->
                                @foreach($item['sub'] as $sub)
                                    @if($is_boss || (!empty($aryPermissionMenu) && in_array($sub['menu_id'],$aryPermissionMenu) && $sub['show_menu'] == STATUS_SHOW))
                                        @if(isset($sub['showcontent']) && $sub['showcontent'] == STATUS_SHOW)
                                                <div class="col-sm-6 col-md-3">
                                                <a class="quick-btn a_control"  href="{{ URL::route($sub['RouteName']) }}">
                                                    <div class="thumbnail text-center">
                                                        <i class="{{ $sub['icon'] }} fa-5x"></i>
                                                        <br>
                                                        @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                                            {{ $sub['name'] }}
                                                        @else
                                                            {{ $sub['name_en'] }}
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                        @if(isset($sub['clear']) && $sub['clear'] == STATUS_SHOW)
                                            <div class="clear"></div>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                <!-- menu đơn-->
                                @if($is_boss || (!empty($aryPermissionMenu) && in_array($item['menu_id'],$aryPermissionMenu) && $item['show_menu'] == STATUS_SHOW))
                                    @if(isset($item['showcontent']) && $item['showcontent'] == STATUS_SHOW && $item['parent_id'] == STATUS_HIDE && $item['menu_type'] == STATUS_SHOW)
                                        <div class="col-sm-6 col-md-3">
                                            <a class="quick-btn a_control"  href="{{ URL::route($item['RouteName']) }}">
                                                <div class="thumbnail text-center">
                                                    <i class="{{ $item['icon'] }} fa-5x"></i>
                                                    <br>
                                                    @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                                        {{ $item['name'] }}
                                                    @else
                                                        {{ $item['name_en'] }}
                                                    @endif
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    @if(isset($sub['clear']) && $sub['clear'] == STATUS_SHOW)
                                        <div class="clear"></div>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    @endif
                 </div>
            </div>
        </div>
    </div>
</div>
@stop