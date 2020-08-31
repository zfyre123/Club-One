jQuery(document).ready(function($) {

      function createMap(){
        var opts = {
          center: {
            lat: 33.3309399,
            lng: -111.950461,
          },
          zoom: 11,
          styles: [
        {
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#f5f5f5"
            }
          ]
        },
        {
          "elementType": "labels.icon",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#616161"
            }
          ]
        },
        {
          "elementType": "labels.text.stroke",
          "stylers": [
            {
              "color": "#f5f5f5"
            }
          ]
        },
        {
          "featureType": "administrative.land_parcel",
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#bdbdbd"
            }
          ]
        },
        {
          "featureType": "poi",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#eeeeee"
            }
          ]
        },
        {
          "featureType": "poi",
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#757575"
            }
          ]
        },
        {
          "featureType": "poi.park",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#e5e5e5"
            }
          ]
        },
        {
          "featureType": "poi.park",
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#9e9e9e"
            }
          ]
        },
        {
          "featureType": "road",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#ffffff"
            }
          ]
        },
        {
          "featureType": "road.arterial",
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#757575"
            }
          ]
        },
        {
          "featureType": "road.highway",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#dadada"
            }
          ]
        },
        {
          "featureType": "road.highway",
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#616161"
            }
          ]
        },
        {
          "featureType": "road.local",
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#9e9e9e"
            }
          ]
        },
        {
          "featureType": "transit.line",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#e5e5e5"
            }
          ]
        },
        {
          "featureType": "transit.station",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#eeeeee"
            }
          ]
        },
        {
          "featureType": "water",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#c9c9c9"
            }
          ]
        },
        {
          "featureType": "water",
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#9e9e9e"
            }
          ]
        }
      ],
          maxZoom: 16,
          minZoom: 0,
          mapTypeId: 'roadmap',
        };

        
        opts.clickableIcons = true;
        opts.disableDoubleClickZoom = true;
        opts.draggable = true;
        opts.keyboardShortcuts = true;
        opts.scrollwheel = false;
        

        
        var setControlOptions = function(key, enabled, position, style, mapTypeIds){
          opts[key + 'Control'] = enabled;
          opts[key + 'ControlOptions'] = {
            position: google.maps.ControlPosition[position],
            style: google.maps.MapTypeControlStyle[style],
            mapTypeIds: mapTypeIds
          };
        };
        
          
        setControlOptions('fullscreen',false,'DEFAULT','',null);
        
          
        setControlOptions('mapType',false,'DEFAULT','DEFAULT',["roadmap","satellite","terrain"]);
        
          
        setControlOptions('rotate',false,'DEFAULT','',null);
        
          
        setControlOptions('scale',false,'','',null);
        
          
        setControlOptions('streetView',false,'DEFAULT','',null);
        
          
        setControlOptions('zoom',false,'DEFAULT','',null);
        

        var map = new google.maps.Map(document.getElementById('map'), opts);

        
        (function(){
          var markerOptions = {
            map: map,
            position: {
              lat: 33.3309399,
              lng: -111.950461,
            }
          };
          
          markerOptions.icon = {
            url: '/wp-content/uploads/2020/06/Full-Color-1.png',
            scaledSize: new google.maps.Size(
              69,
              76),
            size: new google.maps.Size(
              69,
              76),
            anchor: new google.maps.Point(
              69,
              76)
          };
          markerOptions.options = {
            optimized: true,
          };
          
          var marker = new google.maps.Marker(markerOptions);


        })();
        

      }


}); 
