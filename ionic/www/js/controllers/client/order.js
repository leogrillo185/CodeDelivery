angular.module('starter.controllers')
    .controller('ClientOrderCtrl', ['$scope', '$ionicLoading', 'ClientOrder', '$cart',
        '$state', '$ionicActionSheet',
        function ($scope, $ionicLoading, ClientOrder, $cart, $state, $ionicActionSheet) {

            //limpa o carrinho
            $cart.clear();
            //inicializa a variável items
            var items = [];

            $ionicLoading.show({
                template: 'Carregando...'
            });


            $scope.doRefresh = function(){
                getOrder().then(function (data) {
                    $scope.items = data.data;
                    $scope.$broadcast('scroll.refreshComplete');
                }, function () {
                    $scope.$broadcast('scroll.refreshComplete');
                })
            }

            function getOrder(){
                return ClientOrder.query({
                    id: null,
                    include: 'client',
                    orderBy: 'created_at',
                    sortedBy: 'desc'
                }).$promise;
            }

            getOrder().then(function (data) {
                $scope.items = data.data;
                $ionicLoading.hide();
            }, function () {
                $ionicLoading.hide();
            });

            $scope.showActionSheet = function(order){
                $ionicActionSheet.show({
                    buttons: [
                        {text: 'Ver detalhes'},
                        {text: 'Acompanhar entrega'}
                    ],
                    titleText: 'O que deseja fazer?',
                    cancelText: 'Cancelar',
                    cancel: function(){
                        //Fazer algo ao cancelar
                    },
                    buttonClicked: function(index){
                        switch(index){
                            case 0:
                                $state.go('client.view_order', {id: order.id});
                                break;
                            case 1:
                                $state.go('client.view_delivery', {id: order.id});
                                break;
                        }
                    }
                });
            };

            $scope.openOrderDetail = function(i){
                $state.go('client.view_order', {id: i});
            }


        }]);