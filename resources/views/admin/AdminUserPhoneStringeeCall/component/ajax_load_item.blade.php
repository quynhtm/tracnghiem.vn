<?php use App\Library\AdminFunction\FunctionLib; ?>
<div class="panel panel-primary">
    <div class="panel-heading paddingTop1 paddingBottom1">
        <h4>
            @if(isset($data->id) && $data->id > 0)
                <i class="fa fa-edit icChage" aria-hidden="true"></i> <span class="frmHead">{{viewLanguage('Sửa')}} </span>
            @else
                <i class="fa fa-plus-square icChage" aria-hidden="true"></i> <span class="frmHead">{{viewLanguage('Thêm mới')}}</span>
            @endif
        </h4>
    </div>
    <div class="panel-body">
        <form id="formAdd" method="post">
            <input type="hidden" name="id_hiden" @if(isset($data->id))value="{{$data->id}}"@endif class="form-control" id="id_hiden">
            <div class="form-group">
                <label for="name">{{viewLanguage('Số điện thoại')}}<span class="red"> (*) </span></label>
                <input name="phone_number" title="{{viewLanguage('Số điện thoại')}}" class="form-control input-required" id="phone_number_ajax" type="text" @if(isset($data->phone_number))value="{{$data->phone_number}}"@endif>
            </div>
            <div class="form-group">
                <label for="phone_status">{{viewLanguage('Trạng thái')}}</label>
                <select class="form-control input-sm" name="phone_status" id="status">
                    {!! $optionStatus !!}
                </select>
            </div>
            <a class="btn btn-success" id="submit" onclick="VM.addItem('form#formAdd', 'form#formAdd :input', '#submit', WEB_ROOT + '/manager/user_phone_stringee_call/post/' + '{{$data->id}}')">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> {{viewLanguage('Lưu')}}
            </a>
            <a class="btn btn-default" id="cancel" onclick="window.location.reload();">
                <i class="fa fa-undo" aria-hidden="true"></i> {{viewLanguage('Làm lại')}}
            </a>
        </form>
    </div>
</div>