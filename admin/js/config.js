app.config(['$stateProvider','$urlRouterProvider',function($stateProvider,$urlRouterProvider){

    $stateProvider
    .state ('login', {
        url: '/login',
        templateUrl: 'views/login.html'
    })
    .state ('page', {
        url: '/page',
        templateUrl: 'views/common.html'
    })
    .state ('page.dashboard', {
        url: '/dashboard',
        templateUrl: 'views/dashboard.html',
        controller:'DashboardController'
    })
    .state ('page.competition-detail', {
        url: '/competition/:id',
        templateUrl: 'views/competition-modality.html',
        controller:'CompatitionModalityController'
    });
    
}]).run(function($rootScope, $state, $location,$http){

    $http({
        method:'GET',
        url : '/api/v1/session'
    }).then(function(response){
        if(response.data.id){
            $rootScope.currentUser = {
                id: response.data.id,
                email: response.data.email,
                name: response.data.name
            };
        }
    }).then(function(){
        if($rootScope.currentUser){
            $state.go('page.dashboard');
        } else {
            location.href="#/login";
        }
    });

});
