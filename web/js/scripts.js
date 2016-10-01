(function(){ "use strict";

/**
* @name apiRequest
* @param  {Object}   request  [description]
* @param  {Function} callback [description]
* @return {Object}
*/
function apiRequest(request,callback){
    var urlBase = "/api/v1/";

    if( typeof callback === 'function' ){
        var request = {
            url     : urlBase + request.url,
            method  : request.method,
            data    : request.data
        };

        $.ajax({
            method  : request.method,
            url     : request.url,
            dataType: 'json',
            data    : request.data
        })
        .done(function(response) {
            callback(response);
        });
    }
}

/**
* @name runSubscribe
*/
function runSubscribe(){
    var trigger = {
        selector : '.btn-subscribe',
        eventListener:'click'
    };

    function subscribe(event){
        event.preventDefault();
        var tplSuccess = document.querySelector('#tplSuccessRegistration').innerHTML;
        var el = $(event.currentTarget),
            panel = el.closest('.panel'),
            panelBody = panel.find('.panel-body');

        el.prop('disabled',true);

        var request = {
            method  : 'POST',
            url     : 'participant/create',
            data    : {
                nome      : $('input[name="nome"]').val(),
                email     : $('input[name="email"]').val(),
                sobrenome : $('input[name="sobrenome"]').val()
            }
        };

        apiRequest(request,function(response){
            console.log(response);
            if(parseInt(response.result) > 0){
                panelBody.html(tplSuccess);
            } else {
                el.prop('disabled',false);
                panel.removeClass('body-success');
            }
        });
    }

    // Event Delegation
    $(trigger.selector).on(trigger.eventListener,$.proxy(subscribe,this));

} runSubscribe();


})();
