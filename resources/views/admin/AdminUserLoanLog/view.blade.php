<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\CGlobal; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/css/bootstrap-datepicker.css')}}"/>
<script type="text/javascript" language="JavaScript" src="{{URL::asset('assets/admin/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#reset').click(function(){
            $(this).parents('form#frmSearch').find('.form-control').each(function(){
                if ($(this).is('select')){
                    $(this).find('option').prop('selected', false).attr('selected', false);
                } else {
                    $(this).val('');
                }
            });
        });
    });
</script>
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
                                <label for="code"><i>{{viewLanguage('Mã yêu cầu vay')}}</i></label>
                                <input type="text" class="form-control input-sm" id="loan_name" name="loan_name" placeholder="Mã YCV" @if(isset($search['loan_name']))value="{{$search['loan_name']}}"@endif>
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
                            <button class="btn btn-default btn-sm" id="reset" type="reset">{{viewLanguage('Bỏ lọc')}}</button>
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
                                <th width="25%">{{viewLanguage('Intro text')}}</th>
                                <th width="20%">{{viewLanguage('Mã yêu cầu vay')}}</th>
                                <th width="20%" class="text-center">{{viewLanguage('Nhân viên vận hành')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Ngày tạo')}}</th>
                                {{--<th width="15%" class="text-center">{{viewLanguage('Hành động')}}</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td class="text-center middle">{{ $stt+$key+1 }}</td>
                                    <td>{!! $item['introtext'] !!}</td>
                                    <td>{!! $item['loan_name'] !!}</td>
                                    <td>{!! $item['user_name'] !!}</td>
                                    <td>{{ date('H:i d/m/Y', strtotime($item['created_at'])) }}</td>
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