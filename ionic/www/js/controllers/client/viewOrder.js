angular.module('starter.controllers')
    .controller('ClientViewOrderCtrl',
        ['$scope', 'ClientOrder', '$state', '$stateParams', '$ionicLoading',
            function ($scope, ClientOrder, $state, $stateParams, $ionicLoading) {

                $scope.order = {};

                $ionicLoading.show({
                    template: 'Carregando...'
                });

                ClientOrder.get({id: $stateParams.id, include: "items,cupom"}, function (data) {
                     $scope.order = data.data;
                     console.log(data.data.items.data);
                    $ionicLoading.hide();
                }, function(responseError){
                    $ionicLoading.hide();
                })


                $scope.backToOrders = function(){
                    $state.go('client.order');
                }

            }]);