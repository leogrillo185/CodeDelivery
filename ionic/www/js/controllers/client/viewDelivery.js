angular.module('starter.controllers')
    .controller('ClientViewDeliveryCtrl',
        ['$scope', 'ClientOrder', 'UserData', '$state', '$stateParams', '$ionicLoading',
            '$ionicPopup', '$pusher', '$window', '$map', 'uiGmapGoogleMapApi',
            function ($scope, ClientOrder, UserData, $state, $stateParams, $ionicLoading,
                      $ionicPopup, $pusher, $window, $map, uiGmapGoogleMapApi) {

                $scope.map = $map;
                $scope.markers = [];
                $scope.order = {};

                $ionicLoading.show({
                    template: 'Carregando..'
                });

                uiGmapGoogleMapApi.then(function(maps){
                    $ionicLoading.hide();
                },function(responseError){
                    $ionicLoading.hide();
                });

                ClientOrder.get({id: $stateParams.id, include: 'items,cupom'}, function(data){
                    $scope.order =   data.data;
                    if($scope.order.status == 1){
                        initMarkers($scope.order);
                    }else{
                        $ionicPopup.alert({
                            title: "Aviso",
                            template: 'Pedido não está em status de entrega',
                            buttons: [
                                {
                                    text: 'Voltar',
                                    type: 'button-positive'
                                }
                            ]
                        }).then(function(){
                            $state.go('client.order');
                        });
                    }
                });

                function initMarkers(order){
                    var client = UserData.get().client.data,
                        address = client.zipcode + ', ' +
                                client.address + ', ' +
                                client.city + ' - ' +
                                client.state;
                    createMarkerClient(address);
                    watchPositionDeliveryman(order.hash);
                }

                $scope.$watch('markers.length', function(value){
                    if(value == 2){
                        createBounds();
                    }
                });

                function createMarkerClient(address){
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({address: address}, function(results, status){
                        if(status == google.maps.GeocoderStatus.OK){
                            var lat = results[0].geometry.location.lat(),
                                long = results[0].geometry.location.lng();

                           $scope.markers.push({
                                id: 'client',
                                coords: {
                                    latitude: lat,
                                    longitude: long
                                },
                                options: {
                                    title: 'Local de Entrega',
                                    icon: 'img/icon-map-client.png'
                                }
                            });

                            $scope.map = {
                                center: {
                                    latitude: lat,
                                    longitude: long
                                }
                            }

                        }else{
                            $ionicPopup.alert({
                                title: "Aviso",
                                template: 'Não foi possível encontrar o seu endereço'
                            });
                        }
                    });
                }

                //channel é o hash
                function watchPositionDeliveryman(channel){
                    var pusher = $pusher($window.client),
                        channel = pusher.subscribe(channel);
                        channel.bind('CodeDelivery\\Events\\GetLocationDeliveryman', function(data){
                            var lat = data.geo.lat, long = data.geo.long;
                            console.log(data.geo);
                            if($scope.markers.length == 1 || $scope.markers.length == 0){
                                //entao cria o marcador do entregador
                                $scope.markers.push({
                                    id: 'deliveryman',
                                    coords: {
                                        latitude: lat,
                                        longitude: long
                                    },
                                    options: {
                                        title: 'Entregador',
                                        icon: 'img/icon-map-deliveryman.png'
                                    }
                                });
                                return;
                            }

                            for (var key in $scope.markers){
                                if($scope.markers[key].id == 'deliveryman'){
                                    $scope.markers[key].coords = {
                                        latitude: lat,
                                        longitude: long
                                    };
                                }
                            };

                        });
                }

                function createBounds(){
                    var bounds = new google.maps.LatLngBounds(),
                        latlng;
                    angular.forEach($scope.markers, function(value){
                        latlng = new google.maps.LatLng(Number(value.coords.latitude), Number(value.coords.longitude));
                        bounds.extend(latlng);
                    });

                    $scope.map.bounds = {
                        northeast: {
                            latitude: bounds.getNorthEast().lat(),
                            longitude: bounds.getNorthEast().lng()
                        },
                        southwest: {
                            latitude: bounds.getSouthWest().lat(),
                            longitude: bounds.getSouthWest().lng()
                        }
                    }
                }

                $scope.backToOrders = function(){
                    $state.go('client.order');
                };

                $scope.events = {
                    position_changed: function(){
                        $scope.$apply(function(){

                            if($scope.map.fit){
                                $scope.fitBounds = function(){
                                    createBounds();
                                }
                            }

                        })
                    }
                }

                
            }])
            .controller('CvdControlDescentralize', ['$scope','$map', function($scope,$map){
                $scope.map = $map;
                $scope.fit = function(){
                    $scope.map.fit = !$scope.map.fit;
                }
            }])
            .controller('CvdControlReload', ['$scope','$window','$timeout',function($scope,$window,$timeout){
                $scope.reload = function(){
                    $timeout(function(){
                        $window.location.reload(true);
                    },100);
                }
            }]);