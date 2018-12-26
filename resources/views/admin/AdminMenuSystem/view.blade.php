<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </li>
            <li class="active">Quản lý Menu System</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="banner_name">Tên</label>
                            <input type="text" class="form-control input-sm" id="banner_name" name="banner_name" placeholder="Tiêu đề banner" @if(isset($search['banner_name']) && $search['banner_name'] != '')value="{{$search['banner_name']}}"@endif>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="active">Trạng thái</label>
                            <select name="active" id="active" class="form-control input-sm">
                                {!! $optionStatus !!}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="menu_tab_top_id">Menu top</label>
                            <select name="menu_tab_top_id" id="menu_tab_top_id" class="form-control input-sm">
                                {!! $optionMenuTabTop !!}
                            </select>
                        </div>

                        <div class="form-group col-lg-12 text-right">
                            @if($is_root || $permission_full ==1 || $permission_create == 1)
                                <a class="btn btn-danger btn-sm" href="{{URL::route('admin.menuEdit',array('id' => FunctionLib::inputId(0)))}}">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                    {{viewLanguage('add')}}
                                </a>
                            @endif
                                {{--<button class="btn btn-warning btn-sm" type="submit" name="submit" value="2"><i class="fa fa-file-excel-o"></i> Xuất Excel</button>--}}
                                <button class="btn btn-primary btn-sm" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('search')}}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                @if($data && sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                    <br>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="2%" class="text-center">TT</th>
                            <th width="30%">Menu name</th>
                            <th width="8%" class="text-center">Icons</th>
                            <th width="8%" class="text-center">Tab Top</th>
                            <th width="15%" class="text-center">Router name</th>
                            <th width="6%" class="text-center">Order</th>
                            <th width="6%" class="text-center">Status</th>
                            <th width="6%" class="text-center">Menu</th>
                            <th width="6%" class="text-center">Permis</th>
                            <th width="6%" class="text-center">Content</th>
                            <th width="8%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr @if($item['parent_id'] == 0)style="background-color:#d6f6f6"@endif>
                                <td class="text-center text-middle">{!! $stt + $key+1 !!}</td>
                                <td>
                                    @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                        {!! $item['padding_left'].$item['padding_left'].$item['menu_name']!!}
                                    @else
                                        {!! $item['padding_left'].$item['padding_left'].$item['menu_name_en']!!}
                                    @endif
                                </td>
                                <td class="text-center text-middle">
                                    <i class="{!! $item['menu_icons'] !!} fa-3x "></i>
                                </td>
                                <td class="text-center text-middle">
                                    @if(isset($menuTabTop[$item['menu_tab_top_id']]))
                                        {{$menuTabTop[$item['menu_tab_top_id']]}}
                                    @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if(in_array($item['menu_url'],$arrRouter))
                                        <a href="{{URL::route($item['menu_url'])}}" target="_blank">{!! $item['menu_url'] !!}</a>
                                    @else
                                        {!! $item['menu_url'] !!}
                                    @endif
                                </td>
                                <td class="text-center text-middle">{!! $item['ordering'] !!}</td>
                                <td class="text-center text-middle">
                                    @if($item['active'] == 1)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if($item['show_menu'] == 1)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if($item['show_permission'] == 1)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if($item['showcontent'] == 1)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>

                                <td class="text-center text-middle">
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        <a href="{{URL::route('admin.menuEdit',array('id' => FunctionLib::inputId($item['menu_id'])))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_boss)
                                        <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['menu_id']}},4)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['menu_id']}}"></span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="text-right">
                        {{$paging}}
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop