jQuery(document).ready(function ($) {

});

Shopcuatui = {
    addOneProductToCart: function (str_pro_id, number) {
        var _token = $('input[name="_token"]').val();
        var number_add = (parseInt(number) > 1) ? number : 1;
        jQuery.ajax({
            type: "POST",
            url: WEB_ROOT + '/them-vao-gio-hang.html',
            data: {pro_id: str_pro_id, number: number_add, _token: _token},
            success: function (data) {
                if (data.intIsOK === 1) {
                    $('#totalItemCart').html('');
                    $('#totalItemCart').html(parseInt(data.totalCart));
                    alert(data.msg);
                } else {
                    alert(data.msg);
                }
            }
        });
    }
}