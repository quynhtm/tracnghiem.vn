<?php
use Carbon\Carbon;
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
                                    <div class="col-lg-4">
                                        <div class="col-md-12">
                                            <label for="group">Group</label>
                                            <select name="groupId" id="groupId" class="form-control">
                                                <option value="all" data-name="">--Tất cả--</option>
                                                {!! $optionGroup !!}
                                            </select>
                                        </div>
                                        <div class="col-md-12 mgt10">
                                            <label for="userId">Tài khoản Stringee</label>
                                            <input name="from_user_id" type="text"
                                                   @if(isset($search['from_user_id']))value="{{$search['from_user_id']}}"
                                                   @endif class="form-control"
                                                   placeholder="Tài khoản Stringee">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="col-md-12">
                                            <label for="fromPhone">Gọi từ SĐT</label>
                                            <input name="from_number" type="text"
                                                   @if(isset($search['from_number']))value="{{$search['from_number']}}"
                                                   @endif
                                                   class="form-control" placeholder="84988889998">
                                        </div>
                                        <div class="col-md-12 mgt10">
                                            <label for="toPhone">Tới SĐT</label>
                                            <input name="to_number" type="text"
                                                   @if(isset($search['to_number']))value="{{$search['to_number']}}"
                                                   @endif class="form-control"
                                                   placeholder="84122339998">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="col-md-12">
                                            <label for="dateFrom">Từ ngày</label>
                                            <input name="dateFrom" type="date"
                                                   @if(isset($search['dateFrom']))value="{{$search['dateFrom']}}"
                                                   @endif class="form-control"
                                                   placeholder="Date From">
                                        </div>
                                        <div class="col-md-12 mgt10">
                                            <label for="dateTo">Tới ngày</label>
                                            <input name="dateTo" type="date"
                                                   @if(isset($search['dateFrom']))value="{{$search['dateTo']}}"
                                                   @endif class="form-control"
                                                   placeholder="Date To">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="wrap-panel">
                                <div class="inline pull-right">
                                    <a class="btn btn-default btn-sm" id="reset" href="{{route('logCallView')}}"><i class="fa fa-recycle"></i> {{viewLanguage('Bỏ lọc')}}</a>
                                    <button class="btn btn-info btn-sm" type="submit"><i class="fa fa-search"></i> Tìm Kiếm</button>
                                    <button class="btn btn-success btn-sm" type="submit" value="2" name="exportExcel"><i class="fa fa-file-excel-o"></i> ExportExcel</button>
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
                                        <img src="{{URL::to('/')}}/assets/admin/img/sigma-2.png" alt="icon tổng bản ghi"> <strong>Tổng cuộc gọi: {{$total}}</strong>
                                    </td>
                                    <td>
                                        <img src="{{URL::to('/')}}/assets/admin/img/sigma-2.png" alt="icon tổng bản ghi"> <strong>Gọi thành công: {{ $totalCallSuccess }}</strong></td>
                                    <td>
                                        <img src="{{URL::to('/')}}/assets/admin/img/sigma-2.png" alt="icon tổng bản ghi"> <strong>Gọi thất bại: {{ $totalCallFail }}</strong>
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
                            <th>ID cuộc gọi</th>
                            <th>Dự án</th>
                            <th>Tài khoản Stringee</th>
                            <th>Từ số</th>
                            <th>Tới số</th>
                            <th>Thời gian gọi</th>
                            <th>Thời gian trả lời</th>
                            <th>Thời gian dừng</th>
                            <th>Tổng thời gian gọi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data) && !empty($data))
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ isset($item['callId']) ? $item['callId'] : ''  }}</td>
                                    <td>{{ 'Vay mượn'  }}</td>
                                    <td>{{ isset($item['from_user_id']) ? $item['from_user_id'] : '' }}</td>
                                    <td> {{ isset($item['from_number']) ? $item['from_number'] : ''  }}</td>
                                    <td> {{ isset($item['to_number']) ? $item['to_number'] : ''  }}</td>
                                    <td> {{ isset($item['time_created']) ? Carbon::createFromTimestamp($item['time_created']) : ''  }}</td>
                                    <td> {{ isset($item['time_answer']) ? Carbon::createFromTimestamp($item['time_answer']) : ''  }}</td>
                                    <td> {{ isset($item['time_stop']) ? Carbon::createFromTimestamp($item['time_stop']) : ''  }}</td>
                                    <td class="text-center"> {{ isset($item['time_stop']) && isset($item['time_answer']) ? gmdate("i:s", $item['time_stop'] - $item['time_answer']) : 0  }}</td>
                                </tr>
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