$(document).ready(function () {
    var lng;
    Admin.setLang();

    TracNghiem.btnChoseQuestion();
    TracNghiem.btnApproveQuestion();

});
TracNghiem = {
    btnChoseQuestion:function(){
        $('.btnChoseQuestion').click(function(){
            var total = $("table#tableApproveQuestion tbody input.check:checked" ).length;
            if(total==0){
                jAlert('Vui lòng chọn ít nhất 1 câu hỏi để trộn đè!', 'Thông báo');
                return false;
            }else{
                jConfirm('Bạn muốn chọn trộn đề [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
                    if(r){
                        var dataId = [];
                        var i = 0;
                        $("input[name*='checkItems']").each(function () {
                            if ($(this).is(":checked")) {
                                dataId[i] = $(this).val();
                                i++;
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: WEB_ROOT + '/manager/mixQuestions/choseQuestion',
                            data: {dataId: dataId},
                            dataType: 'json',
                            success: function (res) {
                                if(res.isIntOk == 1){
                                    alert('Đã chọn thành công');
                                }
                                else{
                                    alert('Lỗi chưa chọn được');
                                }
                            },
                        });
                    }
                });
            }
        });
    },
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