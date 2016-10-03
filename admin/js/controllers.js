// Controller Dashboard
app.controller('DashboardController',function($scope,$http){
  var urlBase = "/api/v1/";
  $scope.competition = {};
  $http({
    method:'GET',
    url : urlBase + 'competition/active'
  }).then(function(response){
    console.log(response.data);
    $scope.competition = response.data;
  });
});

// Controller Login
app.controller('LoginController',function($scope,$http,$rootScope){
  $scope.form = {
    email: 'admin@gmail.com',
    password:'123'
  };

  $scope.login = function(form){
    var request = {
      url     : 'register',
      method  : 'post',
      data    : {
        email : form.email,
        password : form.password
      }
    };

    apiRequest(request,function(response){
      if(response.user.checkEmail){
        if(response.user.checkPassword){
          $rootScope.currentUser = {
            id: response.user.data.admin_id,
            email: response.user.data.email,
            name: response.user.data.name
          };
          location.href="#/page/dashboard";
        }
      }
    });
  }
});

app.controller('CompatitionModalityController',function($scope,$stateParams,$http){
  var urlBase = "/api/v1/";
  $http({
    method:'GET',
    url : urlBase + 'competition/id/' + $stateParams.id
  }).then(function(response){
    $scope.modalities = response.data;
    console.log(response.data);
  });
});
