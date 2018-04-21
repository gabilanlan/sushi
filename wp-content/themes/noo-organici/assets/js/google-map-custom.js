
function initialize()
{
    if ( jQuery('.googleMap').length > 0 ) {

        jQuery('.googleMap').each(function(index){

            $obj = jQuery(this);

            var lat = $obj.data('lat');
            var lon = $obj.data('lon');
            var expl = null;
            var i = 0;

            var myCenter = new google.maps.LatLng(lat, lon);

            if ( $obj.data('latlonmulti') ) {
                expl = $obj.data('latlonmulti').split('|');
                myFirstCen = expl[0].split(',');
                lat = myFirstCen[1].trim();
                lon = myFirstCen[2].trim();

                var myCenter = new google.maps.LatLng(lat, lon);
            }
            
            var myOptions =
            {
                zoom: 14,
                center: myCenter,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementsByClassName("googleMap")[index], myOptions);
            

            var infowindow = new google.maps.InfoWindow();

            var myMarker = new google.maps.Marker(
            {
                position: myCenter,
                map: map,
                icon: $obj.data('icon')
            });

            if ( expl ) {
                for (i = 0; i < expl.length; i++) {
                    myCen = expl[i].split(',');
                    myCon = myCen[0].trim();
                    myLat = myCen[1].trim();
                    myLon = myCen[2].trim();
                    var myLatLon = new google.maps.LatLng(myLat, myLon);
                    marker = new google.maps.Marker(
                    {
                        position: myLatLon,
                        map: map,
                        icon: $obj.data('icon'),
                        content: myCon

                    });

                    google.maps.event.addListener(marker, 'click', (function(marker) {
                        return function() {
                          infowindow.setContent(marker['content']);
                          infowindow.open(map, marker);
                        }
                    })(marker));
                }
            }

        }); 
    }
}

google.maps.event.addDomListener(window, 'load', initialize);