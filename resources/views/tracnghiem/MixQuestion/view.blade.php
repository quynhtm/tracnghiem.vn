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
            <li class="active"><a href="{{URL::route('tracnghiem.questionView')}}">{{$pageAdminTitle}}</a></li>
        </ul>
    </div>

    <div class="page-content">
        <div class="row">
            {{Form::open(array('method' => 'POST', 'role'=>'form', 'class' =>'frmApproveQuestionList','files' => false, 'url'=>URL::route('tracnghiem.mixAutoQuestion')))}}
            <div class="col-xs-12">
                <div class="panel panel-info">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="name"><i>{{viewLanguage('Tên đề thi')}}</i></label>
                            <input type="text" class="form-control input-sm" id="exam_name" name="exam_name" placeholder="Tên đề thi" @if(isset($search['exam_name']))value="{{$search['exam_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="name"><i>{{viewLanguage('Số lượng đề xuất ra')}}</i></label>
                            <input type="text" class="form-control input-sm" id="number_exam" name="number_exam" placeholder="Số lượng đề xuất ra" @if(isset($search['number_exam']))value="{{$search['number_exam']}}" @else value="1" @endif>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="name"><i>{{viewLanguage('Thời gian làm bài (phút)')}}</i></label>
                            <input type="text" class="form-control input-sm" id="time_to_do" name="time_to_do" placeholder="'Thời gian làm bài (phút)" @if(isset($search['time_to_do']))value="{{$search['time_to_do']}}" @else value="30"@endif>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="name"><i>{{viewLanguage('Năm học')}}</i></label>
                            <input type="text" class="form-control input-sm" id="school_year" name="school_year" placeholder="Năm học" @if(isset($search['school_year']))value="{{$search['school_year']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="status" class="control-label">{{viewLanguage('Khối học')}}</label>
                            <select name="school_block_id" id="school_block_id" class="form-control input-sm">
                                {!! $optionKhoiHoc !!}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="status" class="control-label">{{viewLanguage('Môn học')}}</label>
                            <select name="subjects_id" id="subjects_id" class="form-control input-sm">
                                {!! $optionMonHoc !!}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="status" class="control-label">{{viewLanguage('Chuyên đề')}}</label>
                            <select name="thematic_id" id="thematic_id" class="form-control input-sm">
                                {!! $optionChuyenDe !!}}
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        @if(($is_root || $permission_full || $permission_approve))
                            <a class="btn btn-warning btn-sm btnMixQuestionExam" href="javascript:void(0);"><i class="fa fa-search"></i> {{viewLanguage('Tạo dề thi')}}</a>
                        @endif
                    </div>
                </div>
                @if(isset($data) && sizeof($data) > 0)
                    <div class="col-md-12">
                        <br/>
                        <div class="span pull-left"> @if($total >0) Có tổng số <b>{{$total}}</b> câu hỏi  @endif </div>
                        <div class="clearfix"></div><br/>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tableApproveQuestion">
                                <thead class="thin-border-bottom">
                                <tr class="">
                                    <th width="3%" class="text-center">STT <br/> <input type="checkbox" id="checkAll" checked></th>
                                    <th width="30%">Câu hỏi</th>
                                    <th width="12%" class="text-center">Câu TL 1</th>
                                    <th width="12%" class="text-center">Câu TL 2</th>
                                    <th width="12%" class="text-center">Câu TL 3</th>
                                    <th width="12%" class="text-center">Câu TL 4</th>

                                    <td width="15%">Thông tin khác</td>
                                    <th width="5%">Loại</th>
                                    <th width="5%" class="text-center">Trạng thái</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($data) && sizeof($data) > 0)
                                    @foreach($data as $k=>$item)
                                        <tr>
                                            <td class="text-center">{{$stt + $k + 1}} <br/> <input type="checkbox" class="check" name="checkItems[]" value="{{$item->id}}" checked></td>
                                            <td>{{$item->question_name}}</td>
                                            <td class="text-center @if($item->correct_answer == STATUS_INT_MOT) text-red @endif">{{$item->answer_1}}</td>
                                            <td class="text-center @if($item->correct_answer == STATUS_INT_HAI) text-red @endif">{{$item->answer_2}}</td>
                                            <td class="text-center @if($item->correct_answer == STATUS_INT_BA) text-red @endif">{{$item->answer_3}}</td>
                                            <td class="text-center @if($item->correct_answer == STATUS_INT_BON) text-red @endif">{{$item->answer_4}}</td>

                                            <td>
                                                <b>Khối học:</b> {{ isset($arrBlock[$item->question_school_block]) ? $arrBlock[$item->question_school_block] : ''}} <br/>
                                                <b>Môn học:</b> {{ isset($arrSubs[$item->question_subject]) ? $arrSubs[$item->question_subject] : ''}} <br/>
                                                <b>Chuyên đề:</b> {{ isset($arrThematic[$item->question_thematic]) ? $arrThematic[$item->question_thematic] : ''}}
                                            </td>

                                            <td class="text-center">
                                                {{isset($arrTypeQuestionText[$item->question_type]) ? $arrTypeQuestionText[$item->question_type] : ''}}
                                            </td>
                                            <td class="text-center">
                                                {{isset($arrApprove[$item->question_approved]) ? $arrApprove[$item->question_approved] : ''}}
                                                <br>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            {!! $paging !!}
                        </div>
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop