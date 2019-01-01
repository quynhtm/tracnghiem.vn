<?php use App\Library\AdminFunction\FunctionLib; ?>
<div class="panel panel-primary">
    <div class="panel-heading paddingTop1 paddingBottom1">
        <h4>
            @if(isset($data['id']) && $data['id'] > 0)
                <i class="fa fa-edit icChage" aria-hidden="true"></i> <span class="frmHead">{{viewLanguage('Sửa')}} </span>
            @else
                <i class="fa fa-plus-square icChage" aria-hidden="true"></i> <span class="frmHead">{{viewLanguage('Thêm mới')}}</span>
            @endif
        </h4>
    </div>
    <div class="panel-body">
        <form id="formAdd" method="post">
            <input type="hidden" name="id_hiden" @if(isset($data['id']))value="{{$data['id']}}"@endif class="form-control" id="id_hiden">
            <input name="define_type" value="{{$define_type}}" class="form-control" id="define_type" type="hidden">
            <div class="form-group col-lg-12">
                <label for="define_name">{{viewLanguage('Tên')}} <span class="red"> (*) </span></label>
                <input name="define_name" title="{{viewLanguage('Tên')}}" class="form-control input-required" id="define_name" type="text" @if(isset($data['define_name']))value="{{$data['define_name']}}"@endif>
            </div>
            <div class="form-group col-lg-12">
                <label for="define_name">{{viewLanguage('Mã code')}}</label>
                <input name="define_code" id="define_code"title="{{viewLanguage('Mã code')}}" class="form-control" type="text" @if(isset($data['define_code']))value="{{$data['define_code']}}"@endif>
            </div>
            <div class="form-group col-lg-12">
                <label for="define_name">{{viewLanguage('Mô tả')}}<span class="red"> (*) </span></label>
                <textarea name="define_note" id="define_note" cols="30" rows="2" title="{{viewLanguage('Mô tả')}}" class="form-control input-required">@if(isset($data['define_note'])){{$data['define_note']}}@endif</textarea>
            </div>
            <div class="form-group col-lg-6">
                <label for="define_status">{{viewLanguage('Thứ tự')}}</label>
                <input name="define_order"  id="define_order" title="{{viewLanguage('Thứ tự')}}" class="form-control"type="text" @if(isset($data['define_order']))value="{{$data['define_order']}}"@endif>
            </div>
            <div class="form-group col-lg-6">
                <label for="define_status">{{viewLanguage('Trạng thái')}}</label>
                <select class="form-control input-sm" name="define_status" id="define_status">
                    {!! $optionStatus !!}
                </select>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-lg-12">
                <a class="btn btn-success" id="submit" onclick="VM.addItem('form#formAdd', 'form#formAdd :input', '#submit', WEB_ROOT + '/manager/defineTracNghiem/post/' + '{{$data["id"]}}')">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i> {{viewLanguage('Lưu')}}
                </a>
                <a class="btn btn-default" id="cancel" onclick="window.location.reload();">
                    <i class="fa fa-undo" aria-hidden="true"></i> {{viewLanguage('Làm lại')}}
                </a>
            </div>
        </form>
    </div>
</div>