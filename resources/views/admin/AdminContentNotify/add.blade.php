<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\CGlobal; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/bootstrap-datetimepicker.min.css')}}"/>
<script type="text/javascript" language="JavaScript" src="{{URL::asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
<script>
    $(function () {

        if ($('#type_send').val() == 1) {
            $('.time_to_send').hide();
        }

        $('#type_send').on('change', function (e) {
            e.preventDefault();
            console.log($(this).val());
            if ($(this).val() == 0 || $(this).val() == -2) {
                $('.time_to_send').show('slow');
            } else {
                $('.time_to_send').hide('slow');
            }
        });
        
        $('#timeToSend').on('focus', (e) => {
            e.preventDefault();
            $('#datepicker').datetimepicker({
                format: 'DD/MM/YYYY HH:mm',
                setDate: new Date(),
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            });
        });
        

        $('.change-status').on('click', (e) => {
            e.preventDefault();
            var object = $('#object_receive option:selected').text();
            var career = $('#product_receive option:selected').text();
            Admin.activeContentNotify($('#id_hiden').val(), $('#status').val() == 1 ? 2 : 1, object, career);
        });
        
    })
</script>

<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">{{viewLanguage('Trang chủ')}}</a>
            </li>
            <li><a href="{{URL::route('admin.contentNotifyView')}}">{{viewLanguage('Danh sách nội dung thông báo')}}</a></li>
            <li class="active">@if($id > 0){{viewLanguage('Cập nhật')}}@else {{viewLanguage('Tạo mới')}} @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        {{Form::open(array('method' => 'POST','role'=>'form','files' => true, 'class' => 'form-horizontal'))}}
        <div class="row line">
            <div class="col-md-6">
                <div class="">
                    <a href="{{route('admin.contentNotifyView')}}" class="btn btn-warning"><i class="fa fa-reply">&nbsp;&nbsp;</i>{{viewLanguage('Trở lại')}}</a>
                    @if ($is_root || $permission_full || $permission_create)
                    <button type="submit" class="btn btn-primary" ><i class="fa fa-save">&nbsp;&nbsp;</i>{{viewLanguage('Lưu')}}</button>
                    @endif
                    @if(isset($data['status']) && $data['status'] == STATUS_SHOW)
                        @if ($is_root || $permission_full || $permission_lock)
                            <button type="submit" class="btn btn-danger" name ="status_lock" value="0"><i class="fa fa-lock">&nbsp;&nbsp;</i>{{viewLanguage('Khoá')}}</button>
                        @endif
                    @endif
                    @if(isset($data['status']) && $data['status'] == STATUS_HIDE)
                        @if ($is_root || $permission_full || $permission_active)
                            <button type="submit" class="btn btn-success" name ="status_active" value="1"><i class="fa fa-save">&nbsp;&nbsp;</i>{{viewLanguage('Kích hoạt')}}</button>
                        @endif
                    @endif
                    {{--@if ($id > 0)--}}
                    {{--<a href="javascript:void(0)" class="btn change-status @if(isset($data['status'])){{$data['status'] == 1 ? 'btn-danger' : 'btn-success'}}@endif">@if($data['status'] == 1){{viewLanguage('Khóa')}}@else{{viewLanguage('Kích hoạt')}}@endif</a>--}}
                    {{--@endif--}}
                </div>
            </div>
        </div>
        <div class="row line">
            <div class="col-md-12">
                <!-- PAGE CONTENT BEGINS -->
                @if(isset($error) && !empty($error))
                    <div class="alert alert-danger alert-dismissable" data-dismiss="alert" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        {{Form::open(array('method' => 'POST','role'=>'form','files' => false))}}
                        <table class="table table-bordered fs14">
                            <tbody>
                            @if ($id > 0)
                            <tr>
                                <td width="30%">{{viewLanguage('Mã thông báo')}}</td>
                                <td><input type="text" name="code" readonly class="input-required" style="border:none" @if(isset($data['code']))value="{{stripcslashes($data['code'])}}"@endif></td>
                            </tr>
                            @endif
                            <tr>
                                <td>{{viewLanguage('Tên thông báo')}}</td>
                                <td>
                                    <input type="text" name="name" class="input-required" placeholder="{{viewLanguage('Tên thông báo')}}" value="@if(isset($data['name'])){{stripcslashes($data['name'])}}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td>{{viewLanguage('Đối tượng')}}</td>
                                <td>
                                    <select class="form-control" name="object_receive" id="object_receive">
                                        <option value="-2">---{{viewLanguage('Chọn đối tượng')}}---</option>
                                        {!! $optionObjectReceives !!}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>{{viewLanguage('Loại thông báo')}}</td>
                                <td class="">
                                    <input type="hidden" name="type_noti" id="type_noti" @if(isset($data['type_noti']))value="{{$data['type_noti']}}"@endif>
                                    <div class="checkbox col-xs-6">
                                        <label style="padding-left: 0">
                                            <input name="type_noti_arr[]" class="ace ace-checkbox-2" type="checkbox" @if(isset($data['type_noti'])){{($data['type_noti'] == 1 || $data['type_noti'] == 0) ? 'checked' : ''}}@endif value="1">
                                            <span class="lbl">&nbsp;&nbsp;{{viewLanguage('App Notification')}}</span>
                                        </label>
                                    </div>
                                    <div class="checkbox col-xs-6">
                                        <label style="padding-left: 0">
                                            <input name="type_noti_arr[]" class="ace ace-checkbox-2" type="checkbox" @if(isset($data['type_noti'])){{($data['type_noti'] == 2 || $data['type_noti'] == 0)? 'checked' : ''}}@endif value="2">
                                            <span class="lbl">&nbsp;&nbsp;{{viewLanguage('SMS')}}</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{viewLanguage('Nội dung thông báo')}}</td>
                                <td>
                                    <textarea type="text" name="content_send" rows="3">@if(isset($data['content_send'])){{stripcslashes($data['content_send'])}}@endif</textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered fs14">
                            <tbody>
                            <tr>
                                <td width="30%">{{viewLanguage('Trạng thái')}}</td>
                                <td>
                                    @if($id == 0)
                                        <select name="status" id="status" class="form-control input-sm">
                                            {!! $optionStatus !!}}
                                        </select>
                                    @else
                                        <select id="status" name="status" class="form-control input-sm disabled-selection">
                                            {!! $optionStatus !!}}
                                        </select>
                                    @endif
                                </td>
                            </tr>
                            @if ($id > 0)
                            <tr>
                                <td>{{viewLanguage('Ngày tạo')}}</td>
                                <td>
                                    <input type="text" readonly class="input-required" value="@if(isset($data['created_at'])){{date('H:i d/m/Y', strtotime($data['created_at']))}}@endif">
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td>{{viewLanguage('Sản phẩm vay')}}</td>
                                <td>
                                    <select class="form-control" name="product_receive" id="product_receive">
                                        <option value="Total">--{{viewLanguage('Sản phẩm vay')}}--</option>
                                        {!! $optionProducts !!}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>{{viewLanguage('Phương thức gửi')}}</td>
                                <td>
                                    <select class="form-control" name="type_send" id="type_send">
                                        <option value="-2">---{{viewLanguage('Chọn phương thức gửi')}}---</option>
                                        {!! $optionTypeSend !!}
                                    </select>
                                </td>
                            </tr>
                            <tr class="time_to_send">
                                <td>{{viewLanguage('Thời gian gửi')}}</td>
                                <td>
                                    <div class="date-picker" id="datepicker">
                                        <input type="text" name="time_to_send" id="timeToSend" class="input-required" value="@if(isset($data['time_to_send'])){{date('d/m/Y H:i', strtotime(str_replace('/','-',$data['time_to_send'])))}}@else{{date('d/m/Y H:i', strtotime(getCurrentDateTime()))}}@endif">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div><!-- /.page-content -->
</div>
@stop
