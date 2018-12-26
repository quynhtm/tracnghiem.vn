var stringeeClient;
var call;
var checkClose = 0;
var startTime;
var fnCount;
var localStorageCall = null;
var objSoftphone = null;
$(document).ready(function() {
    VM_STRIGEE.initCall()
});
VM_STRIGEE = {
    initCall: function() {
        console.log('StringeeUtil.isWebRTCSupported: ' + StringeeUtil.isWebRTCSupported());
        var access_token = $(".token_stringee").val();
        if (access_token != '' || access_token != undefined) {
            stringeeClient = new StringeeClient();
            VM_STRIGEE.settingClientEvents(stringeeClient);
            stringeeClient.connect(access_token)
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
            VM_STRIGEE.settingCallEvents(incomingcall);
            VM_STRIGEE.showPopupAnswer(!0);

            if (call.fromNumber != '' || call.fromNumber != undefined) {
                $('.numPhoneCustomerCall span').text(call.fromNumber)
            }
            $('#btnRejectCall').on('click', function() {
                VM_STRIGEE.rejectCall(call);
                VM_STRIGEE.showPopupAnswer(!1)
            });
            $('#btnHangupCall').on('click', function() {
                VM_STRIGEE.hangupCall();
                VM_STRIGEE.showPopupAnswer(!1);

                localStorageCall = localStorage.getItem('call_res_answer');
                if(localStorageCall != null){
                    objSoftphone = localStorageCall;
                }
                if(objSoftphone != null) {
                    if(objSoftphone.callId != null || objSoftphone.callId != undefined){
                        VM_STRIGEE.ajaxLogsCallTime(objSoftphone.callId, 'stop');
                    }
                }
                localStorage.removeItem('call_res_answer');

                var queueInfoId = JSON.parse(call.customDataFromYourServer).queueInfo.id;
                VM_STRIGEE.ajaxLogsCallAnswer(call.callId, call.fromNumber, call.toNumber, call.toAlias, queueInfoId);

            });
            $('#btnAnswerCall').unbind().click(function(){
                VM_STRIGEE.showPopupAnswer(!1);
                $.oauthPopup({
                    path: WEB_ROOT + '/manager/stringee/popupAnswerAgent',
                    width: 400,
                    height: 250
                });
                localStorage.setItem('call_res_answer', call);

                var queueInfoId = JSON.parse(call.customDataFromYourServer).queueInfo.id;
                VM_STRIGEE.ajaxLogsCallAnswer(call.callId, call.fromNumber, call.toNumber, call.toAlias, queueInfoId);
            });
        });
        client.on('requestnewtoken', function() {})
    },
    settingCallEvents: function(call1) {
        call1.on('addlocalstream', function(stream) {});
        call1.on('addremotestream', function(stream) {
            remoteVideo.srcObject = null;
            remoteVideo.srcObject = stream;
        });
        call1.on('signalingstate', function(state) {
            var reason = state.reason;
            $('#callStatus').html(reason);
            VM_STRIGEE.showPopupAnswer(!1);
            localStorageCall = localStorage.getItem('call_res');
            if(localStorageCall != null){
                objSoftphone = JSON.parse(localStorageCall);
            }
            //Answer
            if(state.code == 3){
                VM_STRIGEE.showTimeCall();
                if(objSoftphone != null) {
                    if(objSoftphone.callId != null || objSoftphone.callId != undefined){
                        VM_STRIGEE.ajaxLogsCallTime(objSoftphone.callId, 'answer');
                    }
                }
            }
            //Busy
            if(state.code == 5){
                VM_STRIGEE.enableButtonCall();
                VM_STRIGEE.busyCall();
                localStorage.removeItem('call_res');
            }
            //Stop
            if(state.code == 6){
                VM_STRIGEE.enableButtonCall();
                VM_STRIGEE.countTimeCall(true);
                if(objSoftphone != null) {
                    if(objSoftphone.callId != null || objSoftphone.callId != undefined){
                        VM_STRIGEE.ajaxLogsCallTime(objSoftphone.callId, 'stop');
                    }
                }
                localStorage.removeItem('call_res');
            }
        });
        call1.on('mediastate', function(state) {});
        call1.on('info', function(info) {});
        call1.on('otherdevice', function(data) {
            if ((data.type === 'CALL_STATE' && data.code >= 200) || data.type === 'CALL_END') {
                VM_STRIGEE.showPopupAnswer(!1)
            }
        })
    },
    makeCall: function(fromNumber, phone) {
        if (fromNumber != '' || fromNumber != undefined) {
            call = new StringeeCall(stringeeClient, fromNumber, phone);
            checkClose = 1;
            VM_STRIGEE.settingClientEvents(call);
            VM_STRIGEE.settingCallEvents(call);
            call.makeCall(function(res) {
                var objCall = JSON.stringify(res);
                if (res.r !== 0) {
                    $('#callStatus').html(res.message)
                }
                localStorage.setItem('call_res', objCall);
                VM_STRIGEE.ajaxLogsMakeCall(res.callId, res.fromNumber, res.toNumber);
            });
        }
    },
    hangupCall: function() {
        remoteVideo.srcObject = null;
        call.hangup(function(res) {
            checkClose = 0;
            VM_STRIGEE.showPopupAnswer(!1)
        })
    },
    rejectCall: function(_call) {
        _call.reject(function(res) {
            $('#sound_incomming_call')[0].pause()
        })
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
            if(fnCount != undefined){
                clearTimeout(fnCount);
                startTime = 0;
                return
            }
        }
        var endTime = new Date();
        var timeDiff = endTime - startTime;
        timeDiff /= 1000;
        var seconds = Math.round(timeDiff % 60);
        timeDiff = Math.floor(timeDiff / 60);
        var minutes = Math.round(timeDiff % 60);
        $('.countShowTime').html(VM_STRIGEE.n(minutes) + ":" + VM_STRIGEE.n(seconds));
        fnCount = setTimeout(VM_STRIGEE.countTimeCall, 1000)
    },
    n: function(n) {
        return n > 9 ? n : "0" + n
    },
    closeWindow: function() {
        setTimeout(function() {
            window.close()
        }, 13000)
    },
    showPopupAnswer: function(show) {
        if (show) {
            $('#sound_incomming_call')[0].play();
            $('#sPopupCallToAgent').addClass('in').show();
            $('#sPopupCallToAgent .modal-backdrop').addClass('in').show()
        } else {
            $('#sound_incomming_call')[0].pause();
            $('#sPopupCallToAgent').removeClass('in').hide();
            $('#sPopupCallToAgent .modal-backdrop').removeClass('in').hide()
        }
    },
    enableButtonCall:function(){
        $(".sPhoneCallDrop").removeClass('dCall').addClass('sCall');
        $(".sPhoneCallDrop .txt").text('Gọi điện');
        $(".VMCall").removeClass('DisableCall').addClass('Call');
        $(".sPhoneCall").removeClass('dCall').addClass('sCall');
        $(".sPhoneCall .txt").text('Gọi điện');

        VM_STRIGEE.countTimeCall(true);
        $('.showTimeCall .textShowTime').text('Kết thúc...');
        setTimeout(VM_STRIGEE.clearCountTimeCall, 5000);
        VM_STRIGEE.hangupCall();
    },
    busyCall:function(){
        $('.showCallBusy').text('Busy...');
        setTimeout(VM_STRIGEE.clearCountTimeCall, 5000);
    },
    showTimeCall:function(){
        $('.showTimeCall').addClass('active');
        $('.showTimeCall .textShowTime').text('Đang nghe...');
        startTime = new Date();
        VM_STRIGEE.countTimeCall();
    },
    clearCountTimeCall:function(){
        $('.showTimeCall').removeClass('active');
        $('.countShowTime').html('00:00');
        $('.showCallBusy').text('');
    },
    ajaxLogsMakeCall:function(callId, fromNumber, toNumber){
        var _token = $('input[name="_token"]').val();
        if(callId != '' && fromNumber != '' && toNumber != '' && _token != ''){
            $.ajax({
                type: "POST",
                url: WEB_ROOT + "/manager/log/ajaxLogsCall",
                data: 'callId=' + callId + '&fromNumber=' + fromNumber + '&toNumber=' + toNumber + '&_token=' + _token,
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
            })
        }
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
    ajaxLogsCallAnswer:function(callId, fromNumber, toNumber, toAlias, queueInfoId){
        var _token = $('input[name="_token"]').val();
        if(callId != '' && fromNumber != '' && toNumber != '' && toAlias && _token != ''){
            $.ajax({
                type: "POST",
                url: WEB_ROOT + "/manager/log/ajaxLogsCallAnswer",
                data: 'callId=' + callId + '&fromNumber=' + fromNumber + '&toNumber=' + toNumber + '&toAlias=' + toAlias + '&queueInfoId=' + queueInfoId + '&_token=' + _token,
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
            })
        }
    },
};
(function(jQuery) {
    jQuery.oauthPopup = function(options) {
        options.windowName = options.windowName || 'ConnectWithStringee';
        options.windowOptions = options.windowOptions || 'location=0,status=0,width=' + options.width + ',height=' + options.height + ',scrollbars=1';
        window.open(options.path, options.windowName, options.windowOptions)
    }
})(jQuery)