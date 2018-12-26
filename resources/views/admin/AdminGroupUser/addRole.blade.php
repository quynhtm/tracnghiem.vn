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
            <li><a href="{{URL::route('admin.viewRole')}}"> Danh sách phân quyền theo role</a></li>
            <li class="active">@if($id > 0)Cập nhật @else Tạo mới @endif</li>
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
                <div style="float: left; width: 80%">
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                    <input type="hidden" id="action_copy" name="action_copy" value="{{$action_copy}}"/>
                    <div class="form-group col-sm-12 text-left">
                        <a class="btn btn-warning" href="{{URL::route('admin.viewRole')}}"><i class="fa fa-reply"></i> {{FunctionLib::viewLanguage('back')}}</a>
                        <button  class="btn btn-primary"><i class="fa fa-floppy-o"></i> {{FunctionLib::viewLanguage('save')}}</button>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="name" class="control-label">Phân quyền theo Role</label>
                            <select name="role_id" id="role_id" class="form-control input-sm" disabled>
                                {!! $optionRole !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Vị trí</label>
                            <input type="text" class="form-control input-sm" id="role_order" name="role_order" value="@if(isset($data['role_order'])){{$data['role_order']}}@endif" readonly>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <label for="name" class="control-label"><b>Danh sách nhóm quyền</b></label>
                    </div>
                    <div class="clearfix" style="border-bottom: 1px solid #ccc"></div>
                    <div style="float: left; width: 100%;min-height: 650px;max-height:650px;overflow-x: hidden;">
                        @foreach($arrGroupUser as $key => $val)
                            <div class="col-sm-2">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="ace ace-checkbox-2" name="user_group[]" id="user_group_{{$val['group_user_id']}}" value="{{$val['group_user_id']}}" @if(isset($data['role_group_permission']) && in_array($val['group_user_id'],$data['role_group_permission'])) checked="checked" @endif>
                                        <span class="lbl"> {{$val['group_user_name']}}</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="clearfix"></div>
                    {!! csrf_field() !!}

                </div>

                <div style="float: left; width: 20%">
                    <div id="show_category_sub_campaign" class="body">
                        <label for="name" class="control-label">Menu hiển thị</label>
                        @if(isset($menuAdmin) && !empty($menuAdmin))
                            <div style="float: left; width: 100%;min-height: 150px;max-height:650px;overflow-x: hidden;">
                                <table class="table table-bordered table-hover">
                                    @foreach ($menuAdmin as $tab_top_id => $arr_menu)
                                        <tr>
                                            <td colspan="2">Tab top: <b class="red">@if(isset($arrMenuTabTop[$tab_top_id])){{$arrMenuTabTop[$tab_top_id]}}@else Tất cả @endif</b></td>
                                        </tr>
                                        @foreach ($arr_menu as $menu_id => $menu_name)
                                            <tr>
                                                <td class="text-center text-middle">
                                                    <input type="checkbox" class="checkItem" name="user_group_menu[]"
                                                           @if(in_array($menu_id,$arrUserGroupMenu)) checked="checked" @endif
                                                           value="{{(int)$menu_id}}" />
                                                </td>
                                                <td class="text-left text-middle">
                                                    @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                                        <b>{{ $menu_name['menu_name'] }}</b>
                                                    @else
                                                        <b>{{ $menu_name['menu_name_en'] }}</b>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
@stop
