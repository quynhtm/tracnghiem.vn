var stringeeClientPopup;
var call;
var startTime;
var fnCount;
$(document).ready(function() {
    VM_STRIGEE_POPUP.initCall();
    VM_STRIGEE_POPUP.btnHoldCall();
});
VM_STRIGEE_POPUP = {
    initCall: function() {
        console.log('StringeeUtil.isWebRTCSupported: ' + StringeeUtil.isWebRTCSupported());
        var access_token = $(".token_stringee").val();
        if (access_token != '' || access_token != undefined) {
            stringeeClientPopup = new StringeeClient();
            VM_STRIGEE_POPUP.settingClientEvents(stringeeClientPopup);
            stringeeClientPopup.connect(access_token)
        }
    },
    settingClientEvents: function(client) {
        client.on('connect', function() {});
        client.on('authen', function(res) {
            $('#loggedUserId').html(res.userId)
        });
        client.on('disconnect', function() {});
        client.on('incomingcall', function(incomingcall) {
            call = incomingcall;
            VM_STRIGEE_POPUP.settingCallEvents(incomingcall);
            VM_STRIGEE_POPUP.answerCall(call);
            startTime = new Date();
            VM_STRIGEE_POPUP.countTimeCall();

            if (call.fromNumber != '' || call.fromNumber != undefined) {
                $('.customerPhoneCall').text(call.fromNumber)
            }

            $('#btnHangupCall').on('click', function() {
                VM_STRIGEE_POPUP.hangupCall();
                VM_STRIGEE_POPUP.countTimeCall(!0);
                $('#btnHangupCall').text('Cuộc gọi đã tắt');
                VM_STRIGEE_POPUP.ajaxLogsCallTime(call.callId, 'stop');
            });
        });
        client.on('requestnewtoken', function() {})
    },
    settingCallEvents: function(call1) {
        call1.on('addlocalstream', function(stream) {});
        call1.on('addremotestream', function(stream) {
            remoteVideo.srcObject = null;
            remoteVideo.srcObject = stream
        });
        call1.on('signalingstate', function(state) {
            var reason = state.reason;
            var code = state.code;
            $('#callStatus').html(reason);
            if (code == 6) {
                VM_STRIGEE_POPUP.countTimeCall(!0);
                $('#btnHangupCall').text('Cuộc gọi đã tắt');
                VM_STRIGEE_POPUP.hangupCall();
                VM_STRIGEE_POPUP.countTimeCall(!0);
                VM_STRIGEE_POPUP.ajaxLogsCallTime(call.callId, 'stop');
            }
        });
        call1.on('mediastate', function(state) {});
        call1.on('info', function(info) {});
        call1.on('otherdevice popup', function(data) {})
    },
    hangupCall: function() {
        remoteVideo.srcObject = null;
        call.hangup(function(res) {
            VM_STRIGEE_POPUP.countTimeCall(!0);
            $('#btnHangupCall').text('Cuộc gọi đã tắt');
            window.onload = VM_STRIGEE_POPUP.closeWindow()
        })
    },
    answerCall: function(_call) {
        _call.answer(function(res) {})
    },
    holdCall:function(){
        remoteVideo.srcObject = null;
        call.hold();
    },
    unHoldCall:function(){
        call.unhold();
    },
    countTimeCall: function(clear) {
        if (clear) {
            clearTimeout(fnCount);
            startTime = 0;
            return
        }
        var endTime = new Date();
        var timeDiff = endTime - startTime;
        timeDiff /= 1000;
        var seconds = Math.round(timeDiff % 60);
        timeDiff = Math.floor(timeDiff / 60);
        var minutes = Math.round(timeDiff % 60);
        $('.countTime').html(VM_STRIGEE_POPUP.n(minutes) + ":" + VM_STRIGEE_POPUP.n(seconds));
        fnCount = setTimeout(VM_STRIGEE_POPUP.countTimeCall, 1000)
    },
    n: function(n) {
        return n > 9 ? n : "0" + n
    },
    closeWindow: function() {
        setTimeout(function() {
            window.close()
        }, 13000)
    },
    ajaxLogsCallTime:function(callId, type){
        var _token = $('input[name="_token"]').val();
        if(callId != '' && type != '' && _token != ''){
            $.ajax({
                type: "POST",
                url: WEB_ROOT + "/manager/log/ajaxLogsCallTime",
                data: 'callId=' + callId  + '&_token=' + _token   + '&type='+type,
                success: function(data) {
                    if (data != '') {
                        var check = jQuery.parseJSON(data);
                        if (check.status == 1) {
                            console.log('log call success!')
                        } else {
                            console.log('Log call miss!')
                        }
                    }
                }
            });
        }
    },
    btnHoldCall:function(){
        $("#btnHoldCall").on("click", function() {
            if($(this).hasClass("unHCall")){
                VM_STRIGEE_POPUP.unHoldCall();
                $(this).removeClass("unHCall").addClass("hCall");
                $("#btnHoldCall").text("Giữ cuộc gọi");
            }else{
                if($(this).hasClass("hCall")){
                    VM_STRIGEE_POPUP.holdCall();
                    $(this).removeClass("hCall").addClass("unHCall");
                    $("#btnHoldCall").text("Bỏ giữ cuộc gọi");
                }
            }
        });
    },
}