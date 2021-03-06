<?php use App\Library\AdminFunction\CGlobal; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\FunctionLib; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </li>
            <li class="active">Thông tin cá nhân</li>
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
                            <p>{!! $itmError !!}</p>
                        @endforeach
                    </div>
                @endif

                <div style="float: left; width: 60%">
                    <div class="col-md-2" >
                        <div class="control-group">
                            <div class="controls">
                                <div id="sys_show_image_one" style="width:100%; height: 150px; overflow: hidden">
                                    @if(isset($data['user_image']) && trim($data['user_image']) != '')
                                        <img src="{{env('APP_URL').env('APP_PATH_UPLOAD_MIDDLE').$data['user_image']}}" height="150" width="100%"/>
                                    @else
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/no-profile-image.gif"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">
                                <input type="file" name="image" id="image">
                                <input type="hidden" name="user_image" id="user_image" value="@if(isset($data['user_image'])){{$data['user_image']}}@endif">
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">
                                Account đăng nhập <span class="red"> (*) </span>
                            </label>
                            <input type="text" placeholder="Tên đăng nhập" id="user_name" name="user_name"  class="form-control input-sm" value="@if(isset($data['user_name'])){{$data['user_name']}}@endif" readonly>
                        </div>
                    </div>

                    <div class="col-sm-7">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên nhân viên</label>
                            <input type="text" placeholder="Tên nhân viên" id="user_full_name" name="user_full_name"  class="form-control input-sm" value="@if(isset($data['user_full_name'])){{$data['user_full_name']}}@endif">
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Email<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Email" id="user_email" name="user_email"  class="form-control input-sm" value="@if(isset($data['user_email'])){{$data['user_email']}}@endif">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Phone</label>
                            <input type="text" placeholder="Phone" id="user_phone" name="user_phone"  class="form-control input-sm" value="@if(isset($data['user_phone'])){{$data['user_phone']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Loại quyền</label>
                            <input type="text" id="role_type" name="role_type"  class="form-control input-sm" value="@if(isset($arrRoleType[$data['role_type']])){{$arrRoleType[$data['role_type']]}}@endif" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái</label>
                            <input type="text" id="status" name="status"  class="form-control input-sm" value="@if(isset($arrStatus[$data['user_status']])){{$arrStatus[$data['user_status']]}}@endif" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Chức vụ</label>
                            <select name="position" id="position" class="form-control input-sm" disabled>
                                {!! $optionPosition !!}
                            </select>
                        </div>
                    </div>
                    <div style="display: none">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Quyền với YCV</label>
                            <select name="auto_loan" id="auto_loan" class="form-control input-sm" disabled>
                                {!! $optionAutoLoan !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Thuộc phòng ban</label>
                            <select name="user_depart_id" id="user_depart_id" class="form-control input-sm" disabled>
                                {!! $optionaDepartment !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Người quản lý trực tiếp</label>
                            <input type="text" id="manager_id" name="manager_id"  class="form-control input-sm" value="@if(isset($arrUserManager[$data['user_manager_id']])){{$arrUserManager[$data['user_manager_id']]}}@endif" readonly>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Nhóm sale</label>
                            <select name="group_sale" id="group_sale" class="form-control input-sm" disabled>
                                {!! $optionGroupSale !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Giới tính</label>
                            <select name="user_sex" id="user_sex" class="form-control input-sm">
                                {!! $optionSex !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Quản lý nhóm</label>
                            <input type="text" id="is_manager" name="is_manager"  class="form-control input-sm" value="@if(isset($arrIsManager[$data['user_is_manager']])){{$arrIsManager[$data['user_is_manager']]}}@endif" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Nhận YCV của QL</label>
                            <input type="text" id="receive_loan" name="receive_loan"  class="form-control input-sm" value="@if(isset($arrIsReceiveLoan[$data['is_receive_loan']])){{$arrIsReceiveLoan[$data['is_receive_loan']]}}@endif" readonly>
                        </div>
                    </div>
                    </div>

                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-12 text-left">
                    {!! csrf_field() !!}
                    <button  class="btn btn-primary"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
@stop