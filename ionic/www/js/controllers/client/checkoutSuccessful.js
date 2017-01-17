angular.module('starter.controllers')
    .controller('ClientCheckoutSuccessfulCtrl', ['$scope', '$state', '$cart', '$stateParams',
        function ($scope, $state, $cart, $stateParams) {
            var cart = $cart.get();
            $scope.items = cart.items;
            $scope.total = cart.total;
            ///limpa o carrinho
            $cart.clear();
            $scope.pedido = $stateParams.index;
            $scope.openListOrders = function () {
                //ir para a lista de pedidos
                $state.go('client.order');
            };
        }]);
