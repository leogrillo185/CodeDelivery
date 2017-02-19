angular.module('starter.services')
    .factory('$map', function(){
        var pink_parks = [
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#FFFFFF",
                        "lightness": 100,
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "elementType": "geometry.fill",
                "stylers": [
                    { "color": "" }
                ]
            },
            {
                featureType: 'road.arterial',
                elementType: 'label',
                stylers: [
                    {
                        visibility: 'on',
                        lightness:  50,
                        saturation: 30
                    }
                ]
            }
        ];

        return {
            center: {
                latitude: 0,
                longitude: 0
            },
            zoom: 16,
            options:{
                MapTypeId: 'roadmap',
                zoomControl: false,
                scaleControl: false,
                streetViewControl: false,
                styles: pink_parks
            }
        }

    });