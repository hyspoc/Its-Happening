var map;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: {lat: 39.172360, lng: -86.523570}
    });
}

function addUserMarker(asCenter) {

    function geoSuccess(pos) {
        var crd = pos.coords;

        addMarker(crd.latitude, crd.longitude, "You", null);

        if(asCenter) {
            map.setCenter({lat: crd.latitude, lng: crd.longitude});
        }
    }

    function geoError(err) {
        // location of luddy hall
        addMarker(39.172360, -86.523570, "You", null);
    }

    navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
}

function addMarker(latitude, longitude, title, icon_type, asCenter) {
    var marker = new google.maps.Marker({
        position: {lat: parseFloat(latitude), lng: parseFloat(longitude)},
        title: title,
        map: map
    });

    switch (icon_type) {
        case "Music":
        marker.setIcon("images/placeholders/music.png");
        break;
        case "Arts":
        marker.setIcon("images/placeholders/arts.png");
        break;
        case "Party":
        marker.setIcon("images/placeholders/party.png");
        break;
        case "Sports":
        marker.setIcon("images/placeholders/sports.png");
        break;
        case "Food":
        marker.setIcon("images/placeholders/food.png");
        break;
        case "Business":
        marker.setIcon("images/placeholders/business.png");
        break;
        case "Other":
        marker.setIcon("images/placeholders/placeholder.png");
        break;
        default:
    }

    if(asCenter) {
        map.setCenter({lat: parseFloat(latitude), lng: parseFloat(longitude)});
    }
}
