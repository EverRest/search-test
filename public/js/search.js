(function () {
    // define config obj
    var config = {
            'renderPath': 'main' // element where you want to render component
        },
        map = {},
        markers = [];

    // api auth
    initAuth();

    // render search form and map
    render(config.renderPath);

    // init map
    initMap();

    // get info from api by code
    search();

    /**
     *  render component
     * @param string elem
     * return void
     */
    function render(elem) {
        var content = '',
            script = '';

        content += "<div class='container'><div class='row'><div class='col-md-12 search-container'>" +
                "<div class='collapse navbar-collapse search-wrapper col-md-8'>" +
                "<form id='search-form' class='navbar-form navbar-left'><div class='form-group'>" +
                "<input name='search' id='search' type='text' class='form-control' placeholder='Input code...'></div>" +
                "<button id='search-btn' type='button' class='btn btn-success'>OK</button></form></div>" +
                "<div id='map' class='google-map'></div></div></div></div>";

        $(elem).empty();
        $(elem).append(content);


        $('.google-map').css({'width': '100%', 'height': '400px'});
        $('.search-wrapper').css({'position': 'absolute', 'z-index': '10', 'left': '15%'});
    }

    /**
     * Search event
     * return void
     */
    function search() {
        $(document).on('click', '#search-btn', function (e) {
            var code = $('#search').val();
            $('#search').val('');

            // input validation
            if(validation(code)) {
                code = code.toUpperCase();

                // ajax request
                $.ajax({
                    url: 'info',
                    type: 'POST',
                    data:
                        {
                            'code': code
                        },
                    success : function (xml) {
                        console.log(xml);
                        var xmlDoc = $.parseXML(xml),
                            $xml = $( xmlDoc ),
                            notams = $xml.find( "NOTAM" ),
                            markers = [],
                            item = {};

                        // check is not empty search result
                        if (notams.length) {

                            notams.each(function( i ) {
                                item.q = $(notams[i]).find('ItemQ').text();
                                item.e = $(notams[i]).find('ItemE').text();
                                notams[i] = item;
                                // render marker
                                renderMarker(item);
                            });


                        } else {
                            error('The result is empty. Please check input.');
                        }
                    },
                    error : function (xhr, ajaxOptions, thrownError){
                        console.log('Ajax Error Status: ' + xhr.status);
                        console.log('Ajax Error: ' + thrownError);
                    }
                });

            } else {
                error('Code is not valid!!!');
            }

            return false;
        });
    }

    /**
     * valid search form input
     * @param string str
     * return bool res
     */
    function validation(str) {
        if (str.length > 4) return false;
        if (str.length < 4) return false;
        return !!str.match('[a-zA-Z]{4}');
    }

    /**
     * init google map
     * return void
     */
    function initMap() {
        setTimeout( function () {
            var el = $('#map');
            if (el.length !== 0) {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: -34.397, lng: 150.644},
                    styles: [
                        {
                            "featureType": "administrative",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#444444"
                                }
                            ]
                        },
                        {
                            "featureType": "landscape",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "color": "#f2f2f2"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 45
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "labels.icon",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "transit",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "color": "#46bcec"
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        }
                    ],
                    zoom: 8
                });
            }
        }, 100);
    }

    /**
     * get auth token rocketroute API
     * return false
     */
    function initAuth() {
        $.ajax({
            url: 'auth',
            type: 'GET',
            success : function (res) {
                var xmlDoc = $.parseXML( res ),
                    xml = $( xmlDoc ),
                    result = xml.find( "RESULT" );
                console.log(result);

                // check response for errors
                if ( result.text().toLowerCase() == 'error') {
                    var msg = xml.find( "MSG" ).text();
                    setTimeout(function () {
                        $('body').find('.error-message').remove();
                    }, 5000);
                }
            },
            error : function (xhr, ajaxOptions, thrownError){
                console.log('Ajax Error Status: ' + xhr.status);
                console.log('Ajax Error: ' + thrownError);
            }
        });
    }

    /**
     * render map marker
     * @param item
     * return void
     */
    function renderMarker(item) {

        var coordinates = {},
            tmp = '';

            coordinates = formatCoordinates(item.q);
            coordinates.message = item.e;
            tmp = dgrs2num(coordinates);
            coordinates.lat = tmp.lat;
            coordinates.lng = tmp.lng;

        var marker = new google.maps.Marker({
            position: {lat: coordinates.lng, lng: coordinates.lat},
            icon: 'http://www.clker.com/cliparts/H/Z/0/R/f/S/warning-icon-th.png',
            map: map
        });

        map.setCenter(new google.maps.LatLng(coordinates.lng, coordinates.lat));
        map.setZoom(12);
        markers.push(marker);

        var infowindow = new google.maps.InfoWindow({
            content: '<p>Message:' + coordinates.message + '</p>'
        });

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
        });

        return marker
    }

    /**
     * render map markers
     * @param items
     * return void
     */
    function renderMarkers(items) {

        var arr = [],
            coordinates = {};
        items.each(function(i) {
            coordinates = formatCoordinates(items[i].q);
            coordinates.message = items[i].e;
            arr[i] = coordinates;
            var marker = new google.maps.Marker({
                // The below line is equivalent to writing:
                // position: new google.maps.LatLng(-34.397, 150.644)
                position: {lat: -34.397, lng: 150.644},
                map: map
            });

            map.setCenter(new google.maps.LatLng(-34.397, 150.644));
            markers.push(marker);
            var infowindow = new google.maps.InfoWindow({
                content: '<p>Message:' + coordinates.message + '</p>'
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });
        });
    }

    function formatCoordinates(coordinates) {

        var tmp = coordinates.split(' '),
            marker = {},
            res = {},
            lat = 0,
            lng = 0;

        tmp = tmp[tmp.length-1];
        tmp = tmp.split('/');
        tmp = tmp[tmp.length-1];

        // check coordinates string
        if (!!tmp.match('[a-zA-Z]')) {
            var i = 0;
            tmp = tmp.split('');

            while (tmp[i] != 'N' && tmp[i] != 'W' && tmp[i] != 'E' && tmp[i] != 'S') {
                i++;
            }

            lat = tmp.slice(i + 1);
            lat = lat.join('');
            lng = tmp;
            lng.length =  i + 1;
            lng = lng.join('');

            res.lat = lat;
            res.lng  = lng;

            return res;
        } else {
            error('Can not get coordinates!');
        }
    }

    /**
     * show error message #search-form
     * @param msg
     */
    function error(msg) {
        $('#search-form').append('<h3 class="error-message"><strong>' + msg + '</strong></h3>');
        $('.error-message').css({'color':'red'});
        setTimeout(function () {
            $('#search-form').find('.error-message').remove();
        }, 2500);
    }

    /**
     * convert deg, min, sec to google maps coordinates
     * @param coordinates
     * @returns mixed
     */
    function dgrs2num(coordinates) {
        var res = {},
            tmp = '',
            str = '';

        res.sideLat = coordinates.lat;
        res.sideLat = res.sideLat.charAt(res.sideLat.length - 1);
        res.lat = coordinates.lat;
        tmp = res.lat.split('');
        tmp.length = tmp.length - 1;
        tmp = tmp.join('');
        res.lat = tmp;

        res.sideLng = coordinates.lng;
        res.sideLng = res.sideLng.charAt(res.sideLng.length - 1);
        res.lng = coordinates.lng;
        tmp = res.lng.split('');
        tmp.length = tmp.length - 1;
        tmp = tmp.join('');
        res.lng = tmp;

        //convert to decimal
        tmp = res;
        tmp.lng = tmp.lng;
        tmp.lat = +tmp.lat;

        // ?????????????
        if (tmp.lng.length == 4) {
            var str1 = '',
                str2 = '';
            str = tmp.lng.split('');
            str1 = str[0] + str[1];
            str2 = str[2] + str[3];

            tmp.lng = 1*str1 + 1*str2/60;

            if (tmp.sideLng == 'W') tmp.lng = -1 * tmp.lng;
            res.lng = tmp.lng;

        }

        if (tmp.lat < 100) {

            tmp.lat = ('0' + 1*tmp.lat/60) * 1;

            if (tmp.sideLat == 'S') tmp.lat = -1 * tmp.lat;
            res.lat = tmp.lat
        }

        return res;
    }

})();