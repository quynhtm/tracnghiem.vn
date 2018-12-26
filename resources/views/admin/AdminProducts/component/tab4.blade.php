<div id="menu3" class="tab-pane fade">
    <div class="row marginTop30">
        <div class="col-lg-5 row">
            <div class="col-lg-1"></div>
            <div class="col-lg-4"><span><b>{{viewLanguage('Người tạo')}}</b></span></div>
            <div class="col-lg-4"><span>@if(isset($data['created_by'])){{$data['created_by']}}@else{{viewLanguage('Chưa có')}}@endif</span></div>
        </div>
        <div class="col-lg-5 row">
            <div class="col-lg-1"></div>
            <div class="col-lg-4"><span><b>{{viewLanguage('Ngày kích hoạt')}}</b></span></div>
            <div class="col-lg-4"><span>@if(isset($data['actived_at'])){{$data['actived_at']}}@else{{viewLanguage('Chưa có')}}@endif</span></div>
        </div>
    </div>
    <div class="row marginTop10">
        <div class="col-lg-5 row">
            <div class="col-lg-1"></div>
            <div class="col-lg-4"><span><b>{{viewLanguage('Người kích hoạt')}}</b></span></div>
            <div class="col-lg-4"><span>@if(isset($data['actived_by'])){{$data['actived_by']}}@else{{viewLanguage('Chưa có')}}@endif</span></div>
        </div>
        <div class="col-lg-5 row">
            <div class="col-lg-1"></div>
            <div class="col-lg-4"><span><b>{{viewLanguage('Ngày khoá')}}</b></span></div>
            <div class="col-lg-4"><span>@if(isset($data['locked_at'])){{$data['locked_at']}}@else{{viewLanguage('Chưa có')}}@endif</span></div>
        </div>
    </div>
    <div class="row marginTop10">
        <div class="col-lg-5 row">
            <div class="col-lg-1"></div>
            <div class="col-lg-4"><span><b>{{viewLanguage('Người khóa')}}</b></span></div>
            <div class="col-lg-4"><span>@if(isset($data['locked_by'])){{$data['locked_by']}}@else{{viewLanguage('Chưa có')}}@endif</span></div>
        </div>
    </div>
    <div class="row marginTop10">
        <div class="col-lg-5 row">
            <div class="col-lg-1"></div>
            <div class="col-lg-4"><span><b>{{viewLanguage('Ghi chú')}}</b></span></div>
            <div class="col-lg-4"><textarea rows="4" cols="40" name="history">@if(isset($data['history'])){{$data['history']}}@endif</textarea></div>
        </div>
    </div>
</div>