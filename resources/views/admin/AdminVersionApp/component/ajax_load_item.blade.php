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
                <label for="status">{{viewLanguage('Type')}}</label>
                <select class="form-control input-sm" name="type" id="type">
                    {!! $optionType !!}
                </select>
            </div>
            <div class="form-group">
                <label for="status">{{viewLanguage('OS Type')}}</label>
                <select class="form-control input-sm" name="os_type" id="os_type">
                    {!! $optionOSType !!}
                </select>
            </div>
            <div class="form-group">
                <label for="status">{{viewLanguage('Maintenance')}}</label>
                <select class="form-control input-sm" name="is_mainten" id="is_mainten">
                    {!! $optionMaintenance !!}
                </select>
            </div>
            <div class="form-group">
                <label for="name">{{viewLanguage('Version')}}<span class="red"> (*) </span></label>
                <input name="version" title="{{viewLanguage('Version')}}" placeholder="VD: 3.3.12" class="form-control input-required" id="version" type="text" @if(isset($data->version))value="{{$data->version}}"@endif>
            </div>
            <div class="form-group">
                <label for="status">{{viewLanguage('Trạng thái')}}</label>
                <select class="form-control input-sm" name="status" id="status">
                    {!! $optionStatus !!}
                </select>
            </div>
            <div class="form-group">
                <label for="data">{{viewLanguage('Message')}}<span class="red"> (*) </span></label>
                <textarea name="message" id="message" title="{{viewLanguage('Message')}}" cols="30" rows="2" class="form-control input-required" >@if(isset($data->message)){{$data->message}}@endif</textarea>
            </div>
            <a class="btn btn-success" id="submit" onclick="VM.addItem('form#formAdd', 'form#formAdd :input', '#submit', WEB_ROOT + '/manager/version_app/post/' + '{{$data->id}}')">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> {{viewLanguage('Lưu')}}
            </a>
            <a class="btn btn-default" id="cancel" onclick="window.location.reload();">
                <i class="fa fa-undo" aria-hidden="true"></i> {{viewLanguage('Làm lại')}}
            </a>
        </form>
    </div>
</div>