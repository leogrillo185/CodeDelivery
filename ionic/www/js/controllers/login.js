angular.module('starter.controllers')
    .controller('LoginCtrl',
        ['$scope', 'OAuth','OAuthToken', 'User', 'UserData', '$ionicPopup', '$redirect',
            function ($scope, OAuth, OAuthToken, User, UserData, $ionicPopup, $redirect) {

                $scope.user = [
                    username = '',
                    password = ''
                ];

                $scope.login = function () {

                    var promise = OAuth.getAccessToken($scope.user);
                    promise
                        .then(function (data) {
                            return User.authenticated({include: 'client'}).$promise;
                        })
                        .then(function (data) {
                            UserData.set(data.data);//adciona ao local storage
                            $redirect.redirectAfterLogin();
                            //$state.go('client.checkout');
                        }, function () {
                            UserData.set(null);
                            OAuthToken.removeToken();
                            $ionicPopup.alert({
                                title: 'Advertência',
                                template: 'Login ou senha inválidos'
                            })
                            console.debug(responseError);
                        })

                    /*OAuth.getAccessToken($scope.user).then(function (data) {
                     $state.go('client.checkout');
                     },
                     function (responseError) {
                     $ionicPopup.alert({
                     title: 'Advertência',
                     template: 'Login ou senha inválidos'
                     })
                     console.debug(responseError);

                     });*/
                }
            }]);