angular.module('starter.services')
    .service('$redirect', ['$state', 'UserData','appConfig',
        function($state, UserData, appConfig){
        this.redirectAfterLogin = function(){
            var user = UserData.get();
            return $state.go(appConfig.redirectAfterLogin[user.role]);
        }
}]);