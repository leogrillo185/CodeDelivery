angular.module('starter.controllers')
    .controller('ClientOrderCtrl', ['$scope', '$ionicLoading', 'Order', '$cart',
        function ($scope, $ionicLoading, Order, $cart) {

            //limpa o carrinho
            $cart.clear();
            //inicializa a variável items
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