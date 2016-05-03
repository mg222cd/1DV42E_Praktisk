"use strict";

//Constructor
var Map = function(latitude, longitude) {
    this.latitude = latitude;
    this.longitude = longitude;
    this.infoWindow = undefined;
    this.markers = [];
    var mapOptions = {
        center: new google.maps.LatLng (this.latitude, this.longitude),
        zoom: 5
    }
    this.map = new google.maps.Map (document.getElementById('map-canvas'), mapOptions);
};

Map.prototype.setMarker = function(location) {
    var that = this;
    var latLng = new google.maps.LatLng (location.latitude, location.longitude);
    var marker = new google.maps.Marker ({
        position: latLng,
        map: this.map,
    });
    this.markers.push(marker);
    google.maps.event.addListener(marker, 'click', function () {
        that.getInfoWindow(location, marker);
    });
};

Map.prototype.getInfoWindow = function(location, marker) {
    console.log(marker);
    var date = location.createddate;
    var dateSplitted = date.split('+');
    var firstHalf = dateSplitted[0];
    var secHalf = firstHalf.split('(');
    var unix = secHalf[1];
    var newDate = new Date();
    newDate.setTime(unix);
    var category = "";
    if (location.category == 0) { category = "Vägtrafik"};
    if (location.category == 1) { category = "Kollektivtrafik"};
    if (location.category == 2) { category = "Planerad störning"};
    if (location.category == 3) { category = "Övrigt"};
    if (this.infoWindow !== undefined) {
        this.infoWindow.close();
    }
    var contentString = "<div class='infoWinContent'>" +
        "<h3>" + location.title + "</h3>" +
        "<p>Datum: " + newDate + "</p>" +
        "<p>Beskrivning: " + location.description + "</p>" +
        "<p>Kategori: " + category + "</p>" +
        "</div";
    this.infoWindow = new google.maps.InfoWindow({
        content: contentString,
    });
    this.infoWindow.open(this.map, marker);
}

Map.prototype.deleteMarkers = function() {
    for (var i = 0; i < this.markers.length; i++) {
        this.markers[i].setMap(null);
    }
    this.markers = [];
}