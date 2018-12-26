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
            <li><a href="{{URL::route('admin.menuView')}}"> Danh sách menu</a></li>
            <li class="active">@if($id > 0)Cập nhật menu @else Tạo mới menu @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div style="float: left; width: 50%">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên menu Viet Nam<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Tên menu" id="menu_name" name="menu_name"  class="form-control input-sm" value="@if(isset($data['menu_name'])){{$data['menu_name']}}@endif">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Router menu<span class="red"> (*) </span></label>
                            <input type="text" placeholder="link menu" id="menu_url" name="menu_url"  class="form-control input-sm" value="@if(isset($data['menu_url'])){{$data['menu_url']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    {{--<div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên menu English<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Tên menu" id="menu_name_en" name="menu_name_en"  class="form-control input-sm" value="@if(isset($data['menu_name_en'])){{$data['menu_name_en']}}@endif">
                        </div>
                    </div>--}}
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Thuộc menu Top</label>
                            <select name="menu_tab_top_id" id="menu_tab_top_id" class="form-control input-sm" onchange="Admin.getAjaxOptionRelation(this,'parent_id','menu/ajaxGetOptionParent')">
                                <option value="0">--- Tất cả ---</option>
                                {!! $optionMenuTabTop !!}}
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Thuộc menu cha</label>
                            <select name="parent_id" id="parent_id" class="form-control input-sm">
                                <option value="0">--- Chọn menu cha ---</option>
                                {!! $optionMenuParent !!}}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Loại menu</label>
                            <select name="menu_type" id="menu_type" class="form-control input-sm">
                                {!! $optionMenuType !!}
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Icons menu</label>
                            <input type="text" placeholder="Icons menu" id="menu_icons" name="menu_icons"  class="form-control input-sm" value="@if(isset($data['menu_icons'])){{$data['menu_icons']}}@else fa fa-cog icon-4x @endif">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Thứ tự hiển thị</label>
                            <input type="text" placeholder="Thứ tự hiển thị" id="ordering" name="ordering"  class="form-control input-sm" value="@if(isset($data['ordering'])){{$data['ordering']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái</label>
                            <select name="active" id="active" class="form-control input-sm">
                                {!! $optionStatus !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Menu</label>
                            <select name="show_menu" id="show_menu" class="form-control input-sm">
                                {!! $optionShowMenu !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Phân quyền</label>
                            <select name="show_permission" id="show_permission" class="form-control input-sm">
                                {!! $optionShowPermission !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Nội dung</label>
                            <select name="showcontent" id="showcontent" class="form-control input-sm">
                                {!! $optionShowContent !!}
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    {!! csrf_field() !!}
                    <div class="form-group col-sm-12 text-left">
                        <a class="btn btn-warning" href="{{URL::route('admin.menuView')}}"><i class="fa fa-reply"></i> {{FunctionLib::viewLanguage('back')}}</a>
                        <button  class="btn btn-primary"><i class="fa fa-floppy-o"></i> {{FunctionLib::viewLanguage('save')}}</button>
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
@stop
