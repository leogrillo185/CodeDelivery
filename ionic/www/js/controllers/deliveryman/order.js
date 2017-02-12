angular.module('starter.controllers')
    .controller('DeliverymanOrderCtrl',
        ['$scope', '$ionicLoading', 'DeliverymanOrder', '$cart', '$state',
        function ($scope, $ionicLoading, DeliverymanOrder, $cart, $state) {

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
                return DeliverymanOrder.query({
                    id: null,
                    include: 'client',
                    orderBy: 'id',
                    sortedBy: 'desc'
                }).$promise;
            }

            getOrder().then(function (data) {
                $scope.items = data.data;
                $ionicLoading.hide();
            }, function () {
                $ionicLoading.hide();
            })

            $scope.openOrderDetail = function(i){
                $state.go('deliveryman.view_order', {id: i});
            }


        }]);