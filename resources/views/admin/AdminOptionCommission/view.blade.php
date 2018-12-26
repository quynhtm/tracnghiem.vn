<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\CGlobal; ?>

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
            <div class="col-md-12 panel-content">
                <div class="panel panel-primary">
                    <div class="panel-heading paddingTop1 paddingBottom1">
                        <h4><i class="fa fa-list" aria-hidden="true"></i> {{$pageAdminTitle}}</h4>
                    </div>
                    <form method="post" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-3">
                                <label><b>{{viewLanguage('Tên cấu hình')}}</b></label>
                                <input type="text" class="form-control input-sm" name="name_options" placeholder="{{viewLanguage('Tên cấu hình')}}" @if(isset($search['name_options']))value="{{$search['name_options']}}"@endif>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="status" class="control-label col-lg-12">&nbsp;</label>
                                @if($is_root || $permission_full || $permission_create)
                                    <a class="btn btn-danger btn-sm" href="{{URL::route('admin.optionCommissionEdit',array('id' => 0))}}">
                                        <i class="ace-icon fa fa-plus-circle"></i>
                                        {{viewLanguage('Thêm mới')}}
                                    </a>
                                @endif
                                <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('Tìm kiếm')}}</button>
                            </div>
                        </div>
                    </form>
                    <div class="panel-body line" id="element">
                        <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                        <table class="table table-bordered bg-head-table">
                            <thead>
                            <tr >
                                {{--<th width="" class="text-center">{{viewLanguage('STT')}}</th>--}}
                                <th width="10%">{{viewLanguage('Tên Cấu Hình')}}</th>
                                <th width="8.75%" class="text-center">{{viewLanguage('Trả Trước')}}</th>
                                <th width="8.75%" class="text-center">{{viewLanguage('Người Vay Hưởng')}}</th>
                                <th width="8.75%" class="text-center">{{viewLanguage('Trả Sau cùng %')}}</th>
                                <th width="8.75%" class="text-center">{{viewLanguage('% Hoa Hồng')}}</th>
                                <th width="15%" class="text-center">{{viewLanguage('Ngày Bắt Đầu Áp Dụng')}}</th>
                                <th width="15%" class="text-center">{{viewLanguage('Ngày Kết Thúc Áp Dụng')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Trạng Thái')}}</th>
                                <th width="15%" class="text-center">{{viewLanguage('Ngày tạo')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($data) && sizeof($data))
                                @foreach($data as $k=>$item)
                                <tr class="detailView" data-action="{{route('admin.optionCommissionEdit',['id'=>$item['id']])}}">
                                    {{--<td class="text-center">{{$stt + $k + 1}}</td>--}}
                                    <td width="10%">{{$item->name_options}}</td>
                                    <td width="8.75%" class="text-center">{{numberFormat($item->fixed_amount_prepaid)}}</td>
                                    <td width="8.75%" class="text-center">{{numberFormat($item->fixed_amount_percent)}}</td>
                                    <td width="8.75%" class="text-center">{{$item->percent_commission}}</td>
                                    <td width="8.75%" class="text-center">{{numberFormat($item->loaner_deduct)}}</td>
                                    <td width="15%">{{$item->start_date}}</td>
                                    <td width="15%">{{$item->end_date}}</td>
                                    <td width="10%">{{$status_options[$item->status]}}</td>
                                    <td width="10%">{{$item->created_at}}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {!! $paging !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        VM.scrolleTop();
    });
</script>
@stop