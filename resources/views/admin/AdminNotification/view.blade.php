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
            <li class="active">Quản lí lịch sử thông báo</li>
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
                                <label for="name"><b>{{viewLanguage('Từ ngày')}}</b></label>
                                <input type="date" class="form-control input-sm datePicker" name="created_at_from" value="@if(isset($search['created_at_from'])){{$search['created_at_from']}}@endif">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="name"><b>{{viewLanguage('Đến ngày')}}</b></label>
                                <input type="date" class="form-control input-sm" name="created_at_to" value="@if(isset($search['created_at_to'])){{$search['created_at_to']}}@endif">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="name"><b>{{viewLanguage('ID người vay')}}</b></label>
                                <input type="number" class="form-control input-sm" name="loaner_id" value="@if(isset($search['loaner_id'])){{$search['loaner_id']}}@endif">
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('search')}}</button>
                        </div>
                    </form>
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> item @endif </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="">
                                <th width="5%" class="text-center">{{viewLanguage('STT')}}</th>
                                <th width="15%" class="text-center">{{viewLanguage('Tên người vay')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Tiêu đề')}}</th>
                                <th width="50%" class="text-center">{{viewLanguage('Nội dung')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                                <th width="15%" class="text-center">{{viewLanguage('Ngày gửi')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td class="text-center middle">{{ $stt+$key+1 }}</td>
                                    <td>@if(isset($infor_loaner[$item['loaner_id']])){{ $infor_loaner[$item['loaner_id']]}}@endif</td>
                                    <td class="text-center middle">{{ $item['title'] }}</td>
                                    <td >
                                        {{$item['body']}}
                                    </td>
                                    <td class="text-center middle">
                                        {{$item->status_option[$item['status']]}}
                                    </td>
                                    <td class="text-center middle">
                                        {{$item['created_at']}}
                                    </td>
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