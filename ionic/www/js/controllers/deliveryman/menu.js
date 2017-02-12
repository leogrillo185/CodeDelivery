angular.module('starter.controllers')
    .controller('DeliverymanMenuCtrl',
        ['$scope', 'UserData',
            function ($scope, UserData) {
                //Recuperando os dados do user para o menu
                $scope.user = UserData.get();
            }]);