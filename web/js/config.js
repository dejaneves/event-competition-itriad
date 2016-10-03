app.config(['$stateProvider','$urlRouterProvider',function($stateProvider,$urlRouterProvider){

    $stateProvider
    .state ('site', {
        url: '/',
        templateUrl: 'web/views/home.html'
    })
    .state ('subscribe', {
        url: '/subscribe',
        templateUrl: 'web/views/subscribe.html',
        controller:'SubscribeController'
    });
    $urlRouterProvider.otherwise('/');
}])
