angular.module('starter.controllers')
    .controller('ClientTestCtrl',
        ['$scope', 'ClientOrder', 'UserData', '$state', '$stateParams', '$ionicLoading',
            '$ionicPopup', '$pusher', '$window', '$map', 'uiGmapIsReady', 'uiGmapGoogleMapApi', '$cordovaGeolocation',
            function ($scope, ClientOrder, UserData, $state, $stateParams, $ionicLoading,
                      $ionicPopup, $pusher, $window, $map, uiGmapIsReady, uiGmapGoogleMapApi, $cordovaGeolocation) {

                var watch, lat, long;

                $scope.markers = [];

                // map object
                $scope.map = {
                    control: {},
                    center: {
                        latitude: 0,
                        longitude: 0
                    },
                    zoom: 16
                };

                uiGmapGoogleMapApi.then(function(map){

                    $scope.markers.push({
                        id: 'chegada',
                        coords: {
                            latitude: -12.952360,
                            longitude: -38.461320
                        },
                        options: {
                            title: 'Local de Entrega',
                            icon: 'img/icon-map-client.png'
                        }
                    });

                    $scope.$watch('markers.length', function(value){
                        if(value == 2){
                            createBounds();
                        }
                    });

                    var watchOptions = {
                        timeOut: 3000,
                        enableHighAccuracy: false
                    };

                    watch = $cordovaGeolocation.watchPosition(watchOptions);

                    watch.then(null, function(responseError){
                        console.log("Erro ao obter a posição");
                    }, function(position){

                        console.log('Long: ' + position.coords.longitude);
                        lat = position.coords.latitude;
                        long = position.coords.longitude;

                        // marker object

                        $scope.markers.push({
                            id: 'saida',
                            coords: {
                                latitude: lat,
                                longitude: long
                            },
                            options:{
                                title: 'início',
                                icon: 'img/icon-map-deliveryman.png'
                            }
                        });

                        // directions object -- with defaults
                        $scope.directions = {
                            origin: -12.952360 + "," + -38.461320,
                            destination: new google.maps.LatLng(Number(lat), Number(long))
                        }

                        createBounds();
                        getDirections();

                    });

                    // get directions using google maps api
                   function getDirections(){
                       // instantiate google map objects for directions
                       var directionsDisplay = new google.maps.DirectionsRenderer({
                           //suppressMarkers: true
                       });
                       var directionsService = new google.maps.DirectionsService();
                       var geocoder = new google.maps.Geocoder();

                       var request = {
                            origin: $scope.directions.origin,
                            destination: $scope.directions.destination,
                            travelMode: google.maps.DirectionsTravelMode.DRIVING
                        };
                        directionsService.route(request, function (response, status) {
                            if (status === google.maps.DirectionsStatus.OK) {
                                directionsDisplay.setMap($scope.map.control.getGMap());
                                directionsDisplay.setOptions({
                                    polylineOptions: {
                                        strokeWeight: 6,
                                        strokeOpacity: 1,
                                        strokeColor:  'blue'
                                    },
                                    //Esconde os marcadores padrões A-B
                                    suppressMarkers:true
                                });
                                directionsDisplay.setDirections(response);
                            } else {
                                //alert('Google route unsuccesfull!');
                            }
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

                });

            }]);