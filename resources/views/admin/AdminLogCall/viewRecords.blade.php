<?php
use Carbon\Carbon;
use App\Stringee;
?>
@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">{{viewLanguage('Trang chủ')}}</a>
            </li>
            <li class="active">{{$pageAdminTitle}}</li>
        </ul>
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <form id="frmSearch" method="get" action="" role="form">
                        <div class="panel-body">
                            <div class="row">
                                <div class="input-group">
                                    <div class="col-lg-3">
                                        <label for="userId">Tài khoản Stringee</label>
                                        <input name="from_user_id" type="text"
                                               @if(isset($search['from_user_id']))value="{{$search['from_user_id']}}"
                                               @endif class="form-control"
                                               placeholder="Tài khoản Stringee">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="fromPhone">Gọi từ SĐT</label>
                                        <input name="from_number" type="text"
                                               @if(isset($search['from_number']))value="{{$search['from_number']}}"
                                               @endif
                                               class="form-control" placeholder="84988889998">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="toPhone">Tới SĐT</label>
                                        <input name="to_number" type="text"
                                               @if(isset($search['to_number']))value="{{$search['to_number']}}"
                                               @endif class="form-control"
                                               placeholder="84122339998">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="dateFrom">Từ ngày</label>
                                        <input name="dateFrom" type="date"
                                               @if(isset($search['dateFrom']))value="{{$search['dateFrom']}}"
                                               @endif class="form-control"
                                               placeholder="Date From">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="dateTo">Tới ngày</label>
                                        <input name="dateTo" type="date"
                                               @if(isset($search['dateFrom']))value="{{$search['dateTo']}}"
                                               @endif class="form-control"
                                               placeholder="Date To">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="wrap-panel">
                                <div class="inline pull-right">
                                    <a class="btn btn-default btn-sm" id="reset" href="{{route('logCallCallRecordsFile')}}"><i class="fa fa-recycle"></i> {{viewLanguage('Bỏ lọc')}}</a>
                                    <button class="btn btn-info btn-sm" type="submit"><i class="fa fa-search"></i> Tìm Kiếm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mgt25">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped table-condensed">
                                <tbody>
                                <tr>
                                    <td>
                                        <img src="{{URL::to('/')}}/assets/admin/img/sigma-2.png" alt="icon tổng bản ghi"> <strong>Tổng cuộc gọi: {{$totalCalls}}</strong>
                                    </td>
                                    <td>
                                        <img src="{{URL::to('/')}}/assets/admin/img/sigma-2.png" alt="icon gọi thành công"> <strong>Gọi thành công : {{$totalCallCount['success']}}</strong>
                                    </td>
                                    <td>
                                        <img src="{{URL::to('/')}}/assets/admin/img/sigma-2.png" alt="icon gọi thất bại"> <strong>Gọi thất bại : {{$totalCallCount['miss']}}</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bodyInput">
                    <table class="table table-bordered bg-head-table">
                        <thead>
                        <tr>
                            <th width="10%">{{viewLanguage('ID cuộc gọi')}}</th>
                            <th>{{viewLanguage('Dự án')}}</th>
                            <th>{{viewLanguage('Tài khoản Stringee')}}</th>
                            <th>{{viewLanguage('Từ số')}}</th>
                            <th>{{viewLanguage('Tới số')}}</th>
                            <th width="10%">{{viewLanguage('Thời gian gọi')}}</th>
                            <th width="10%">{{viewLanguage('Thời gian trả lời')}}</th>
                            <th width="10%">{{viewLanguage('Thời gian dừng')}}</th>
                            <th width="10%">{{viewLanguage('Tổng thời gian gọi')}}</th>
                            <th>{{viewLanguage('Tải về')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data) && !empty($data))
                            @foreach($data as $item)
                                @if($item->answer_time > 0)
                                <tr>
                                    <td>{{ isset($item->id) ? $item->id : ''  }}</td>
                                    <td>{{ 'Vay mượn'  }}</td>
                                    <td>
                                        @if(isset($arrMailRel[$item->from_user_id])) {{$arrMailRel[$item->from_user_id]}} @endif
                                        @if(isset($arrMailCall[$item->id])) {{$arrMailCall[$item->id]}} @endif
                                    </td>
                                    <td class="text-red">{{$item->from_number}}</td>
                                    <td>{{$item->to_number}}</td>
                                    <td>
                                        <?php $start_time = 0; ?>
                                        @if($item->start_time != 0)
                                            <?php $start_time = substr($item->start_time, 0, -3); ?>
                                            {{date('d/m/Y H:i:s', $start_time)}}
                                        @endif
                                    </td>
                                    <td>
                                        <?php $answer_time = 0; ?>
                                        @if($item->answer_time != 0)
                                            <?php $answer_time = substr($item->answer_time, 0, -3); ?>
                                            {{date('d/m/Y H:i:s', $answer_time)}}
                                        @endif
                                    </td>
                                    <td>
                                        <?php $stop_time = 0; ?>
                                        @if($item->stop_time != 0)
                                            <?php $stop_time = substr($item->stop_time, 0, -3); ?>
                                            {{date('d/m/Y H:i:s', $stop_time)}}
                                        @endif
                                    </td>
                                    <td>{{app(Stringee::class)->totalCallTime($answer_time, $stop_time)}}</td>
                                    <td class="text-center">
                                        @if($item->answer_time > 0)
                                            <a class="linkCall" href="{{URL::route('logCallCallRecordsFileItem')}}/{{$item->id}}">{{viewLanguage('Tải về')}}</a>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="text-right">
                        {!! $paging !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop