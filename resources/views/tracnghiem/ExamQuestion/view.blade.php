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
            <li class="active"><a href="{{URL::route('tracnghiem.examQuestionView')}}">{{$pageAdminTitle}}</a></li>
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
                                <label for="name"><i>{{viewLanguage('Tên banner')}}</i></label>
                                <input type="text" class="form-control input-sm" id="name" name="name" placeholder="Tên banner" @if(isset($search['name']))value="{{$search['name']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                                <select name="status" id="status" class="form-control input-sm">
                                    {!! $optionStatus !!}}
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            @if($is_root || $permission_full || $permission_create)
                                 <a class="btn btn-danger btn-sm" href="{{URL::route('tracnghiem.questionEdit',array('id' => setStrVar(0)))}}">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                     {{viewLanguage('add')}}
                                 </a>
                            @endif
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
                                <th width="5%" class="text-center">{{viewLanguage('STT')}}</th>
                                <th width="15%">{{viewLanguage('Tên đề thi')}}</th>
                                <th width="10%"  class="text-center">{{viewLanguage('Năm học')}}</th>
                                <th width="8%"  class="text-center">{{viewLanguage('Số phút')}}</th>

                                <th width="14%">{{viewLanguage('Môn học')}}</th>
                                <th width="14%">{{viewLanguage('Khối học')}}</th>
                                <th width="14%">{{viewLanguage('Chuyên đề học')}}</th>

                                <th width="10%" class="text-center">{{viewLanguage('Thông tin khác')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Thao tác')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td class="text-center middle">{{ $stt+$key+1 }}</td>
                                    <td>{{$item->exam_name}}</td>
                                    <td class="text-center">{{$item->school_year}}</td>
                                    <td class="text-center">{{$item->time_to_do}}</td>

                                    <td>{{$item->subjects_name}}</td>
                                    <td>{{$item->school_block_name}}</td>
                                    <td>{{$item->thematic_name}}</td>

                                    <td class="text-center">
                                        {{$item->user_name_creater}}<br>
                                        <i>{{$item->created_at}}</i>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);">Tải về</a>
                                        <br>
                                        <a href="{{URL::route('tracnghiem.questionView',['list_question_id'=>$item->list_question_id])}}">DS câu hỏi</a>
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