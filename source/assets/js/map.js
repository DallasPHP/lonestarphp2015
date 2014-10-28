var map;
function initialize() {
    var latLng = new google.maps.LatLng(32.961772, -96.828379);
    var styles = [
        {
          stylers: [
            { hue: "#d52c2d" },
            { saturation: 0 }
          ]
        },{
          featureType: "road",
          elementType: "geometry",
          stylers: [
            { lightness: 100 },
            { visibility: "simplified" }
          ]
        },{
          featureType: "road.local",
          elementType: "labels",
          stylers: [
            { visibility: "off" }
          ]
        }
    ];

    // Create a new StyledMapType object, passing it the array of styles,
    // as well as the name to be displayed on the map type control.
    var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

    var mapOptions = {
        zoom: 15,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        panControl: true,
        zoomControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: false,
        overviewMapControl: false,
        disableDoubleClickZoom: false,
        scrollwheel: false,
        draggable: false,
        mapTypeControlOptions: {
          mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
        }
    };

    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');

    function addHotelMarker(title, latLng, url, map) {
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            title: title,
            icon: '/assets/img/map/hotel.png',
            animation: google.maps.Animation.DROP
        });

        // Add Click Event
        google.maps.event.addListener(marker, 'click', function() {
            window.location = url;
        });
    }

    var eventMarker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: "Addison Convention Center",
        icon: '/assets/img/map/logo.png',
        animation: google.maps.Animation.DROP
    });

    // Add Click Event for location
    google.maps.event.addListener(eventMarker, 'click', function() {
        window.location = 'http://www.addisontx.gov/Departments/conf_theatre/News___Articles/Addison_Conference_Centre.asp';
    });

    // Add Hotels
    addHotelMarker(
        "Hyatt House",
        new google.maps.LatLng(32.956958, -96.828211),
        "http://addison.house.hyatt.com/en/hotel/home.html",
        map
    );

    addHotelMarker(
        "Hawthorn Suites",
        new google.maps.LatLng(32.956447, -96.829499),
        "http://www.hawthorn.com/hotels/texas/addison/hawthorn-suites-by-wyndham-addison-galleria/hotel-overview",
        map
    );

    addHotelMarker(
        "Spring Hill Suites",
        new google.maps.LatLng(32.956949, -96.827179),
        "http://www.marriott.com/hotels/travel/dalsh-springhill-suites-dallas-addison-quorum-drive/",
        map
    );
}

google.maps.event.addDomListener(window, 'load', initialize);