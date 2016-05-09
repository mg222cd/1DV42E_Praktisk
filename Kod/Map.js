function initialize(){

    $.ajax({ type: 'GET',   
         url: './Helpers/GetCoordinates.php',
         dataType: 'json',   
         success : function(data)
         {
            lat = parseFloat(data.data.lat);
            lng = parseFloat(data.data.lng);

            var myLatLng = { lat:lat, lng:lng};

            var mapOptions = {
                center: new google.maps.LatLng(lat, lng),
                zoom: 8
            };
            
            var map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);

            var marker = new google.maps.Marker({
                position : myLatLng,
                map : map
            });
         }
    });
}

google.maps.event.addDomListener(window, 'load', initialize);