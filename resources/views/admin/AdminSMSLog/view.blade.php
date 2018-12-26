<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\CGlobal; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/css/bootstrap-datepicker.css')}}"/>
<script type="text/javascript" language="JavaScript" src="{{URL::asset('assets/admin/js/bootstrap-datepicker.js')}}"></script>
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </li>
            <li class="active">{{CGlobal::$pageAdminTitle}}</li>
        </ul>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <form method="Post" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-3">
                                <label for="loaner_name"><i>{{viewLanguage('Tên người vay')}}</i></label>
                                <input type="text" class="form-control input-sm" id="loaner_name" name="loaner_name" placeholder="Tên người vay" @if(isset($search['loaner_name']))value="{{$search['loaner_name']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="loaner_phone"><i>{{viewLanguage('Số điện thoại')}}</i></label>
                                <input type="text" class="form-control input-sm" id="loaner_phone" name="loaner_phone" placeholder="Số điện thoại" @if(isset($search['loaner_phone']))value="{{$search['loaner_phone']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="loaner_code"><i>{{viewLanguage('Mã người vay')}}</i></label>
                                <input type="text" class="form-control input-sm" id="loaner_code" name="loaner_code" placeholder="Mã người vay" @if(isset($search['loaner_code']))value="{{$search['loaner_code']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="loaner_id""><i>{{viewLanguage('ID Người vay')}}</i></label>
                                <input type="text" class="form-control input-sm" id="loaner_id" name="loaner_id" placeholder="Id người vay" @if(isset($search['loaner_id']))value="{{$search['loaner_id']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="send_mo" class="control-label">{{viewLanguage('Trạng thái MO')}}</label>
                                <select name="send_mo" id="send_mo" class="form-control input-sm">
                                    {!! $optionStatusSendMO !!}}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="send_mt" class="control-label">{{viewLanguage('Trạng thái MT')}}</label>
                                <select name="send_mt" id="send_mt" class="form-control input-sm">
                                    {!! $optionStatusSendMT !!}}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>{{viewLanguage('Từ Ngày Tạo')}}</label>
                                <input type="date" class="form-control input-sm" name="s_date" placeholder="{{viewLanguage('Từ Ngày Tạo')}}" @if(isset($search['s_date']) && $search['s_date'] != '')value="{{$search['s_date']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>{{viewLanguage('Đến Ngày Tạo')}}</label>
                                <input type="date" class="form-control input-sm" name="e_date" placeholder="{{viewLanguage('Đến Ngày Tạo')}}" @if(isset($search['e_date']) && $search['e_date'] != '')value="{{$search['e_date']}}"@endif>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                        <a class="btn btn-default btn-sm" id="reset" href="{{route('admin.smsLogsView')}}"><i class="fa fa-recycle"></i> {{viewLanguage('Bỏ lọc')}}</a>
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('search')}}</button>
                        </div>
                    </form>
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="">
                                <th width="3%" class="text-center">{{viewLanguage('STT')}}</th>
                                <th width="15%" class="text-center">{{viewLanguage('Số điện thoại gửi')}}</th>
                                <th width="15%" class="text-center">{{viewLanguage('Thời gian gửi')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('SMS MO')}}</th>
                                <th width="25%" class="text-center">{{viewLanguage('SMS MT')}}</th>
                                <th width="7%" class="text-center">{{viewLanguage('Gửi MO')}}</th>
                                <th width="7%" class="text-center">{{viewLanguage('Gửi MT')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $item)
                                <tr class="detail-blank-1" data-container="body" data-toggle="popover" data-placement="top" data-title="{{viewLanguage('Thông tin người vay')}}" data-html-content="#popover{{$item->id}}">
                                    <td class="text-center middle">
                                        {{ $stt+$key+1 }}
                                        @if ($item['loaner_id'])
                                        <div class="hidden popover-html" id="popover{{$item->id}}">
                                            <div class="title">
                                                {{viewLanguage("ID người vay")}}: {{$item->loaner_id}}
                                            </div>
                                            <div class="content">
                                                <table>
                                                    <tr>
                                                        <td><strong>{{viewLanguage("Mã người vay")}}:</strong></td>
                                                        <td><a target="_blank" href="{{route('loan.getLoaner',['id'=>$item->loaner_id])}}">{{$item['loaner_code']}}</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{viewLanguage("Họ Tên Người Vay")}}:</strong></td>
                                                        <td>{{$item['loaner_name']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{viewLanguage("Điện thoại người vay")}}:</strong></td>
                                                        <td>{{$item['loaner_phone']}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td class="text-center middle">{{ $item['loaner_phone'] }}</td>
                                    <td class="text-center middle">{{ $item['created_at'] }}</td>
                                    <td class="text-center middle">{{ $item['message_mo'] }}</td>
                                    <td>{{ $item['message_mt'] }}</td>
                                    @if($item['send_mo'] == STATUS_SHOW)
                                        <td class="text-center middle @if(isset(CGlobal::$array_color_status[STATUS_SHOW] )) {{CGlobal::$array_color_status[STATUS_SHOW]['background']}}@endif">
                                            <a href="javascript:void(0);" title="Thành công" class="@if(isset(CGlobal::$array_color_status[STATUS_SHOW] )) {{CGlobal::$array_color_status[STATUS_SHOW]['text']}}@endif" ><span>{{viewLanguage('Thành công')}}</span></a>
                                        </td>
                                    @elseif ($item['send_mo'] == STATUS_INT_AM_MOT)
                                        <td class="text-center middle @if(isset(CGlobal::$array_color_status[STATUS_HIDE] )) {{CGlobal::$array_color_status[STATUS_HIDE]['background']}}@endif">
                                            <a href="javascript:void(0);" title="Thất bại" class="@if(isset(CGlobal::$array_color_status[STATUS_HIDE] )) {{CGlobal::$array_color_status[STATUS_HIDE]['text']}}@endif" ><span>{{viewLanguage('Thất bại')}}</span></a>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif 

                                     @if($item['send_mt'] == STATUS_SHOW)
                                        <td class="text-center middle @if(isset(CGlobal::$array_color_status[STATUS_SHOW] )) {{CGlobal::$array_color_status[STATUS_SHOW]['background']}}@endif">
                                            <a href="javascript:void(0);" title="Thành công" class="@if(isset(CGlobal::$array_color_status[STATUS_SHOW] )) {{CGlobal::$array_color_status[STATUS_SHOW]['text']}}@endif" ><span>{{viewLanguage('Thành công')}}</span></a>
                                        </td>
                                    @elseif ($item['send_mt'] == STATUS_INT_AM_MOT)
                                        <td class="text-center middle @if(isset(CGlobal::$array_color_status[STATUS_HIDE] )) {{CGlobal::$array_color_status[STATUS_HIDE]['background']}}@endif">
                                            <a href="javascript:void(0);" title="Thất bại" class="@if(isset(CGlobal::$array_color_status[STATUS_HIDE] )) {{CGlobal::$array_color_status[STATUS_HIDE]['text']}}@endif" ><span>{{viewLanguage('Thất bại')}}</span></a>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        {!! $paging !!}
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