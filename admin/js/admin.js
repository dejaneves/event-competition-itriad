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
