angular.module('starter.controllers')
    .controller('ClientViewProductCtrl',
        ['$scope', '$state', 'Product', '$ionicLoading', '$cart',
            function ($scope, $state, Product, $ionicLoading, $cart) {
                $scope.products=[];
                $scope.page = 1;
                $scope.pageTotal = 1;
                $scope.total = null;

                $scope.loadProducts = function(){
                    Product.query({page: $scope.page}, function (data) {
                        $scope.pageTotal = data.meta.pagination.total_pages;
                        $scope.total = data.meta.pagination.total;
                        var items = data.data;
                        angular.forEach(items, function (item) {
                            $scope.products.push(item);
                        });
                        $scope.page++;
                        $scope.$broadcast('scroll.infiniteScrollComplete');
                    }, function (responseError) {

                    });
                }


                //Método para verificar se existem mais páginas para serem carregadas
                $scope.moreProductCanBeLoaded = function(){
                    if($scope.pageTotal >= $scope.page){
                        return true;
                    }
                    return false;
                }

                $scope.addItem = function (item) {
                    //forçando que adicionará um produto por vez
                    item.qtd = 1;
                    //adcionando o item ao carrinho
                    $cart.addItem(item);
                    //redirecionando para a página de checkout
                    $state.go('client.checkout');
                }

               /*
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
                */

            }]);