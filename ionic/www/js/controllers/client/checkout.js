angular.module('starter.controllers')
    .controller('ClientCheckoutCtrl',
        ['$scope', '$state', '$cart', 'Order', '$ionicPopup', '$ionicLoading', 'User',
            function ($scope, $state, $cart, Order, $ionicPopup, $ionicLoading, User) {

                User.authenticated({include: 'client'}, function(data){
                    console.log(data.data);
                });

                var cart = $cart.get();
                $scope.items = cart.items;
                $scope.total = cart.total;

                $scope.removeItem = function (i) {
                    //remove o item do carrinho
                    $cart.removeItem(i);
                    //remove o ítem da listagem da página
                    $scope.items.splice(i, 1);
                    //atualixa o total do carrinho
                    $scope.total = $cart.get().total;
                };

                $scope.openListProducts = function (i) {
                    $state.go('client.view_products');
                };

                $scope.openProductDetail = function (i) {
                    $state.go('client.checkout_item_detail', {index: i});
                };

                $scope.save = function () {
                    //copiando os items para não alterar os items da view
                    var items = angular.copy($scope.items);
                    angular.forEach(items, function (item) {
                        item.product_id = item.id;
                    });


                    //Exibindo a mensagem de carregamento
                    $ionicLoading.show({
                        template: 'Carregando..'
                    });

                    //Salvando o pedido
                    Order.save({id: null}, {items: items}, function (data) {
                        //escondento do carregador
                        $ionicLoading.hide();
                        //redirecinando para a página de sucesso
                        //$state.go('client.checkout_successful', {index: data.data.id});
                        $state.go('client.order');
                        //console.log(data.data.id);

                    }, function (responseError) {
                        //Escondento o carregador
                        $ionicLoading.hide();
                        //exibindo popup com se deu erro
                        $ionicPopup.alert({
                            title: 'Advertência',
                            template: 'Erro. Não foi possível efetuar o pedido. Tente novamente'
                        })
                    });
                };

            }]);