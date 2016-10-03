app.controller('SubscribeController',function($scope,$http,$location){
  var urlBase = "/api/v1/";
  $scope.form = {
    modalidades : []
  };

  $scope.btnSend = false;
  $scope.finish = false;

  $http({
    method: 'GET',
    url: urlBase + 'modality/all'
  }).then(function(response){
    $scope.form.modalidades = response.data;
  });

  function finishSubscribe(){
    $scope.finish = true;
    swal({
      title: "Inscrição",
      text: "Sua inscrição foi realizada com Sucesso!",
      type: "success"
      },function(isConfirm){
        if (isConfirm) {
          location.href="#/";
        }
    });
  }

  $scope.subscribe = function(form){
    var request = {
      method  : 'POST',
      url     : 'participant/create',
      data    : {
        nome      : form.nome,
        email     : form.email,
        sobrenome : form.sobrenome,
        participou_anterior : form.participou_anterior
      }
    };
    $scope.btnSend = true;
    apiRequest(request,function(response){
      var inscricaoId = response.result;
      if(inscricaoId > 0){
        var arr = [];
        angular.forEach(form.modalidade,function(value,key){
          arr.push({
            inscricao_id:inscricaoId,
            competicao_has_modalidade_id:form.modalidades[key].competicao_has_modalidade_id
          });
        });

        function subscribeModality(arr,count){
          var sizeArr = arr.length;
          if(count <= sizeArr ){
            var requestModality = {
              method  : 'POST',
              url     : 'participant/modality',
              data    : {
                inscricao_id:arr[count-1].inscricao_id,
                competicao_has_modalidade_id:arr[count-1].competicao_has_modalidade_id
              }
            };
            //console.log(requestModality);
            apiRequest(requestModality,function(resModality){
              if(resModality > 0){
                count++;
                subscribeModality(arr,count);
              } else{
                alert('Error');
              }
            });
          } else {
            finishSubscribe();
          }

        }
        var countOut = 1;
        subscribeModality(arr,countOut);

      } else {
        $scope.btnSend = false;
      }

    });
  };

});
