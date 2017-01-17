angular.module('starter.controllers')
    .controller('ClientOrderCtrl', ['$scope', '$ionicLoading', 'Order',
        function ($scope, $ionicLoading, Order) {

            var items = [];

            $ionicLoading.show({
                template: 'Carregando...'
            });

            Order.query({
                id: null,
                include: 'client',
                orderBy: 'created_at',
                sortedBy: 'desc'
            }, function (data) {
                $scope.items = data.data;
                $ionicLoading.hide();
            }, function () {
                $ionicLoading.hide();
            });

        }]);