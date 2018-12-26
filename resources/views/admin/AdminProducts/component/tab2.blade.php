<div id="menu1" class="tab-pane fade ">
    <div class="row marginTop20">
        <div class="col-lg-5">
            <h3><b>Quy định lãi</b></h3>
            <div class="col-lg-8 marginTop10 remove_padding" >
                <label for="name" class="text-bold" >{{viewLanguage('Lãi phẳng (%/năm)')}}<span class="red"> (*) </span></label>
                <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="interest_rate" name="interest_rate"  value="@if(isset($data['interest_rate'])){{$data['interest_rate']}}@endif" required>
            </div>
            <div class="col-lg-8 marginTop10 remove_padding">
                <label for="name" class="text-bold" >{{viewLanguage('Lãi ân hạn (VNĐ/1 lần)')}}</label>
                <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="grace_fee" name="grace_fee"  value="@if(isset($data['grace_fee'])){{$data['grace_fee']}}@endif">
            </div>
            <div class="col-lg-8 marginTop10 remove_padding">
                <label for="name" class="text-bold" >{{viewLanguage('Phí quá hạn (VNĐ/năm)')}} <span class="red"> (*) </span></label>
                <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="overdue_fee" name="overdue_fee"  value="@if(isset($data['overdue_fee'])){{$data['overdue_fee']}}@endif" required>
            </div>
            <div class="col-lg-8 marginTop10 remove_padding">
                <label for="name" class="text-bold" >{{viewLanguage('Thanh toán trước hạn (%/tổng lãi và phí còn lại)')}}<span class="red"> (*) </span></label>
                <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="before_maturity" name="before_maturity"  value="@if(isset($data['before_maturity'])){{$data['before_maturity']}}@endif" required>
            </div>
        </div>
        <div class="col-lg-6">
            <h3><b>Quy định phí</b></h3>
            <div class="col-lg-7 marginTop10 remove_padding">
                <label for="name" class="text-bold" >{{viewLanguage('Phí sàn môi giới (%/năm)')}}<span class="red"> (*) </span></label>
                <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="fee_rate" name="fee_rate"  value="@if(isset($data['fee_rate'])){{$data['fee_rate']}}@endif"  required>
            </div>
            <div class="col-lg-7 marginTop10 remove_padding">
                <label for="name" class="text-bold" >{{viewLanguage('Phí đảm bảo (%/năm)')}}<span class="red"> (*) </span></label>
                <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="ensure_rate" name="ensure_rate"  value="@if(isset($data['ensure_rate'])){{$data['ensure_rate']}}@endif"  required>
            </div>
            <div class="col-lg-7 marginTop10 remove_padding">
                <label for="name" class="text-bold" >{{viewLanguage('Phí thu xếp (%/năm)')}}<span class="red"> (*) </span></label>
                <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="total_fee" name="total_fee"  value="@if(isset($data['fee_rate']) && isset($data['total_fee'])){{$data['total_fee']}}@endif" required>
            </div>
        </div>

    </div>
</div>
