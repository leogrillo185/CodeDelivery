angular.module('starter.controllers')
    .controller('ClientViewProductCtrl',
        ['$scope', '$state', 'Product', '$ionicLoading', '$cart',
            function ($scope, $state, Product, $ionicLoading, $cart) {

                $scope.products = [];
                $ionicLoading.show({
                    template: 'Carregando...'
                });
                Product.query({}, function (data) {
                    $scope.products = data.data;
                    $ionicLoading.hide();
                }, function () {
                    $ionicLoading.hide();
                });

                $scope.addItem = function (item) {
                    //forçando que adicionará um produto por vez
                    item.qtd = 1;
                    //adcionando o item ao carrinho
                    $cart.addItem(item);
                    //redirecionando para a página de checkout
                    $state.go('client.checkout');
                };

                $scope.removeItem = function (i) {

                };


            }]);