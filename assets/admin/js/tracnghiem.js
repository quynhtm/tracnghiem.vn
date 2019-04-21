$(document).ready(function () {
    var lng;
    Admin.setLang();

    TracNghiem.btnApproveQuestion();

});
TracNghiem = {
    btnApproveQuestion:function(){
        $('.btnApproveQuestion').click(function(){
            var total = $("table#tableApproveQuestion tbody input.check:checked" ).length;
            if(total==0){
                jAlert('Vui lòng chọn ít nhất câu hỏi để gửi duyệt!', 'Thông báo');
                return false;
            }else{
                jConfirm('Bạn muốn gửi duyệt [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
                    if(r){
                        $('form.frmApproveQuestionList').submit();
                        return true;
                    }
                });
            }
        });
    },
}