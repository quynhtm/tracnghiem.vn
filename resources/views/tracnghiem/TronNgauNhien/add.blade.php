<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
@extends('admin.AdminLayouts.index')
@section('content')
    <div class="main-content-inner">
        <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="{{URL::route('admin.dashboard')}}">{{viewLanguage('Trang chủ')}}</a>
                </li>
                <li>Trộn đề từ file</li>

            </ul>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
                    @if(isset($error) && !empty($error))
                        <div class="alert alert-danger" role="alert">
                            @foreach($error as $itmError)
                                <p>{{ $itmError }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div style="float: left; width: 100%">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Câu hỏi')}}<span class="red"> (*) </span></label>
                                <textarea id="question_name" name="question_name" class="form-control input-sm" cols="30" rows="5">@if(isset($data['question_name'])){{$data['question_name']}}@endif</textarea>
                            </div>
                        </div>
                        <div class="cleafix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Câu hỏi trả lời 1')}}</label>
                                <textarea id="answer_1" name="answer_1" class="form-control input-sm" cols="30" rows="2">@if(isset($data['answer_1'])){{$data['answer_1']}}@endif</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Câu hỏi trả lời 2')}}</label>
                                <textarea id="answer_1" name="answer_2" class="form-control input-sm" cols="30" rows="2">@if(isset($data['answer_2'])){{$data['answer_2']}}@endif</textarea>
                            </div>
                        </div>
                        <div class="cleafix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Câu hỏi trả lời 3')}}</label>
                                <textarea id="answer_3" name="answer_3" class="form-control input-sm" cols="30" rows="2">@if(isset($data['answer_3'])){{$data['answer_3']}}@endif</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Câu hỏi trả lời 4')}}</label>
                                <textarea id="answer_4" name="answer_4" class="form-control input-sm" cols="30" rows="2">@if(isset($data['answer_4'])){{$data['answer_4']}}@endif</textarea>
                            </div>
                        </div>
                        <div class="cleafix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Câu hỏi trả lời 5')}}</label>
                                <textarea id="answer_5" name="answer_5" class="form-control input-sm" cols="30" rows="2">@if(isset($data['answer_5'])){{$data['answer_5']}}@endif</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Câu hỏi trả lời 6')}}</label>
                                <textarea id="answer_6" name="answer_6" class="form-control input-sm" cols="30" rows="2">@if(isset($data['answer_6'])){{$data['answer_6']}}@endif</textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Loại câu hỏi')}}</label>
                                <select name="question_type" id="question_type" class="form-control input-sm">
                                    {!! $optionType !!}}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Duyệt')}}</label>
                                <select name="question_approved" id="question_approved" class="form-control input-sm">
                                    {!! $optionApprove !!}}
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12 text-left">
                            <a class="btn btn-warning" href="{{URL::route('tracnghiem.questionView')}}"><i class="fa fa-reply"></i> {{viewLanguage('back')}}</a>
                            @if($is_root || $permission_full || $permission_create)
                                <button  class="btn btn-primary"><i class="fa fa-floppy-o"></i> {{viewLanguage('save')}}</button>
                            @endif
                        </div>
                        <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div><!-- /.page-content -->
    </div>
@stop
