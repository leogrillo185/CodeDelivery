angular.module('starter.controllers')
    .controller('ClientCheckoutCtrl',
        ['$scope', '$state', '$cart', 'Cupom', 'ClientOrder', '$ionicPopup', '$ionicLoading', '$cordovaBarcodeScanner', 'User',
            function ($scope, $state, $cart, Cupom, ClientOrder, $ionicPopup, $ionicLoading, $cordovaBarcodeScanner,  User) {

                var cart = $cart.get();
                $scope.cupom = cart.cupom;
                $scope.items = cart.items;
                $scope.total = $cart.getTotalFinal();

                /*User.authenticated({include: 'client'}, function(data){
                    //console.log(data.data.client);
                }, function(responseError){

                });*/

                $scope.removeItem = function (i) {
                    //remove o item do carrinho
                    $cart.removeItem(i);
                    //remove o ítem da listagem da página
                    $scope.items.splice(i, 1);
                    //atualixa o total do carrinho
                    $scope.total = $cart.getTotalFinal();
                };


                $scope.openListProducts = function (i) {
                    $state.go('client.view_products');
                };

                $scope.openProductDetail = function (i) {
                    $state.go('client.checkout_item_detail', {index: i});
                };

                $scope.save = function () {
                    //copiando os items para não alterar os items da view
                    var o = {items: angular.copy($scope.items)};
                    angular.forEach(o.items, function (item) {
                        item.product_id = item.id;
                    });

                    if($scope.cupom.value){
                        if($cart.get().cupom.value > $cart.get().total){
                            $ionicPopup.alert({
                                title: "Erro",
                                template: 'O valor do cupom é maior que o valor do pedido! Adicione mais itens ou remova o cupom.'
                            });
                            return;
                        }
                        o.cupom_code = $scope.cupom.code;
                    }

                    //Exibindo a mensagem de carregamento
                    $ionicLoading.show({
                        template: 'Carregando..'
                    });

                    //Salvando o pedido

                    ClientOrder.save({id: null}, o, function (data) {
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

                //Ler QRCode
                $scope.readBarCode = function(){
                    //Ativando o scanner de código de barras
                    $cordovaBarcodeScanner
                        .scan()
                        .then(function(barcodeData) {
                            getValueCupom(barcodeData.text);
                        }, function(error) {
                            $ionicPopup.alert({
                                title: 'Advertência',
                                template: 'Não foi possível ler o QRCode. Tente novamente.'
                            })
                        });

                };

                $scope.removeCupom = function(){
                    $cart.removeCupom();
                    $scope.cupom = $cart.get().cupom;
                    $scope.total = $cart.getTotalFinal();
                };

                //Consulta o cupom na api
                function getValueCupom(code){
                    $ionicLoading.show({
                        template: 'Carregando..'
                    });
                    Cupom.get({code: code}, function(data){
                       $cart.setCupom(data.data.code, data.data.value);
                        $scope.cupom = $cart.get().cupom;
                        $scope.total = $cart.getTotalFinal();
                        $ionicLoading.hide();
                    }, function(responseError){
                        $ionicLoading.hide();
                        $ionicPopup.alert({
                            title: 'Advertência',
                            template: 'Cupom Inválido'
                        })
                    });
                }


            }]);