angular.module('starter.controllers')
    .controller('DeliverymanViewOrderlCtrl',
        ['$scope', 'DeliverymanOrder', '$state', '$stateParams', '$ionicLoading', '$ionicPopup', '$cordovaGeolocation',
            function ($scope, DeliverymanOrder, $state, $stateParams, $ionicLoading, $ionicPopup, $cordovaGeolocation) {
                var watch, lat = null, long;
                $ionicLoading.show({
                    template: 'Carregando...'
                });

                DeliverymanOrder.get({id: $stateParams.id, include: "items,cupom"}, function (data) {
                    $scope.order = data.data;
                    $ionicLoading.hide();
                }, function (responseError) {
                    $ionicLoading.hide();
                });

                $scope.goToDelivery = function () {
                    $ionicPopup.alert({
                        title: "Advertência",
                        template: 'Para parar a localização clique em ok.'
                    }).then(function () {
                        stopWatchPosition();
                    });
                    //Mudando o status da order para entrega
                    DeliverymanOrder.updateStatus({id: $stateParams.id}, {status: 1}, function () {
                        var watchOptions = {
                            timeOut: 3000,
                            enableHighAccuracy: false
                        }
                        watch = $cordovaGeolocation.watchPosition(watchOptions);
                        watch.then(null,
                            function (responseError) {

                            },
                            function (position) {
                                if (!lat) {
                                    lat = position.coords.latitude;
                                    long = position.coords.longitude;
                                } else {
                                    long += 0.00150;
                                }
                                DeliverymanOrder.geo({id: $stateParams.id}, {
                                    lat: lat,
                                    long: long
                                });
                                //console.log(position);
                            });
                    });
                };

                function stopWatchPosition() {
                    //Se existe o watch, se ele for um objeto e se existe a propriedade watchID
                    if (watch && typeof watch == 'object' && watch.hasOwnProperty('watchID')) {
                        $cordovaGeolocation.clearWatch(watch.watchID);
                    }
                }

                $scope.backToOrders = function () {
                    $state.go('deliveryman.order');
                };

            }]);