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
            <li class="active">Thông tin nhân viên</li>
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

                    <div class="col-sm-7">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên nhân viên<span class="red"> (*) @if($id == 0)Mật khẩu: Vaymuon4@!2018 @endif</span></label>
                            <input type="text" placeholder="Tên nhân viên" id="user_full_name" name="user_full_name"  class="form-control input-sm" value="@if(isset($data['user_full_name'])){{$data['user_full_name']}}@endif">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái<span class="red"> (*) </span></label>
                            <select name="user_status" id="user_status" class="form-control input-sm">
                                {!! $optionStatus !!}
                            </select>
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
                            <label for="name" class="control-label">Quyền với YCV</label>
                            <select name="auto_loan" id="auto_loan" class="form-control input-sm">
                                {!! $optionAutoLoan !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Thuộc phòng ban</label>
                            <select name="user_depart_id" id="user_depart_id" class="form-control input-sm">
                                {!! $optionaDepartment !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Chức vụ<span class="red"> (*) </span></label>
                            <select name="position" id="position" class="form-control input-sm">
                                {!! $optionPosition !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Nhóm sale</label>
                            <select name="group_sale" id="group_sale" class="form-control input-sm">
                                {!! $optionGroupSale !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Nhận YCV của QL</label>
                            <select name="is_receive_loan" id="is_receive_loan" class="form-control input-sm">
                                {!! $optionaIsReceiveLoan !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Giới tính</label>
                            <select name="user_sex" id="user_sex" class="form-control input-sm">
                                {!! $optionSex !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-12 text-left">
                    {!! csrf_field() !!}
                    <a class="btn btn-warning" href="{{URL::route('admin.viewEmployee')}}"><i class="fa fa-reply"></i> Trở lại</a>
                    <button  class="btn btn-primary"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
@stop