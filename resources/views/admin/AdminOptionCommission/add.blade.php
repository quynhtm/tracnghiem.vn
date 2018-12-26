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
                <li><a href="{{URL::route('admin.optionCommissionView')}}"> {{viewLanguage('DANH SÁCH CẤU HÌNH NGƯỜI GIỚI THIỆU')}}</a></li>
                <li class="active">@if($id > 0){{viewLanguage('Cập nhật')}}@else {{viewLanguage('Tạo mới')}} @endif</li>
            </ul><!-- /.breadcrumb -->
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
                    <div class="col-sm-6 marginLeft15">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label"><b>{{viewLanguage('Tên cấu hình')}}<span class="red"> (*) </span></b></label>
                                    <input type="text" id="name_options" name="name_options"  class="form-control input-sm" value="@if(isset($data['name_options'])){{$data['name_options']}}@endif">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label"><b>{{viewLanguage('Số Tiền Trả Trước Lần 1')}}<span class="red"> (*) </span></b></label>
                                    <input type="number" id="fixed_amount_prepaid" name="fixed_amount_prepaid"  class="form-control input-sm" value="@if(isset($data['fixed_amount_prepaid'])){{$data['fixed_amount_prepaid']}}@endif">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label"><b>{{viewLanguage('Số Tiền Trả Sau Kèm Hoa Hồng')}}<span class="red"> (*) </span></b></label>
                                    <input type="number" id="loaner_deduct" name="loaner_deduct"  class="form-control input-sm" value="@if(isset($data['loaner_deduct'])){{$data['loaner_deduct']}}@endif">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label"><b>{{viewLanguage('% Hoa Hồng Trả Lần 2')}}<span class="red"> (*) </span></b></label>
                                    <input type="number" id="percent_commission" name="percent_commission"  class="form-control input-sm" value="@if(isset($data['percent_commission'])){{$data['percent_commission']}}@endif">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label"><b>{{viewLanguage('Số Tiền Người Vay Được Hưởng')}}<span class="red"> (*) </span></b></label>
                                    <input type="number" id="fixed_amount_percent" name="fixed_amount_percent"  class="form-control input-sm" value="@if(isset($data['fixed_amount_percent'])){{$data['fixed_amount_percent']}}@endif">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label"><b>{{viewLanguage('Ngày Bắt Đầu Áp Dụng')}}</b></label>
                                    <input type="date" id="start_date" name="start_date"  class="form-control input-sm" value="@if(isset($data['start_date'])){{date('Y-m-d',strtotime($data['start_date']))}}@endif">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label"><b>{{viewLanguage('Ngày Kết Thúc Áp Dụng')}}</b></label>
                                    <input type="date" id="end_date" name="end_date"  class="form-control input-sm" value="@if(isset($data['end_date'])){{date('Y-m-d',strtotime($data['end_date']))}}@endif">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name" class="control-label"><b>{{viewLanguage('Trạng thái')}}</b></label>
                                    <select name="status" id="status" class="form-control input-sm" >
                                        @foreach($statuses as $key_status => $status)
                                            <option value="{{$key_status}}">{{$status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 text-left">
                                <a class="btn btn-warning" href="{{URL::route('admin.optionCommissionView')}}"><i class="fa fa-reply"></i> {{viewLanguage('back')}}</a>
                                @if($is_root || $permission_full || $permission_create)
                                    <button  class="btn btn-primary"><i class="fa fa-floppy-o"></i> {{viewLanguage('save')}}</button>
                                @endif
                            </div>
                            <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div><!-- /.page-content -->
    </div>
    <script>
        $(document).ready(function () {
            var selected_status = "<?php echo isset($data['status']) ? ($data['status']) : 'mac_dinh'; ?>"
            $("#status").val(selected_status);
        })

    </script>
@stop
