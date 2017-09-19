(function () {
    // define config obj
    var config = {
            'renderPath': 'main' // element where you want to render component
        },
        map = {};

    // api auth
    initAuth();

    // render search form and map
    render(config.renderPath);

    // init map
    initMap();

    // get info from api by code
    search();

})();

/**
 *  render component
 * @param string selector
 * return void
 */
function render(selector) {
    var content = '',
        script = '';

    content += "<div class='container'><div class='row'><div class='col-md-12 search-container'>" +
            "<div class='collapse navbar-collapse search-wrapper col-md-8'>" +
            "<form id='search-form' class='navbar-form navbar-left'><div class='form-group'>" +
            "<input name='search' id='search' type='text' class='form-control' placeholder='Input code...'></div>" +
            "<button id='search-btn' type='button' class='btn btn-success'>OK</button></form></div>" +
            "<div id='map' class='google-map'></div></div></div></div>";

    $(selector).empty();
    $(selector).append(content);


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
                url: 'https://apidev.rocketroute.com/notam/v1/service.wsdl',
                crossOrigin: true,
                data:
                    {
                        'req':  '<?xml version="1.0" encoding="UTF-8"?>' +
                                '<REQWX>' +
                                '<USR>medynskyypavlo@gmail.com</USR>' +
                                '<PASSWD>89954141c89f2a74fbcc2d1a3478f5f6</PASSWD>' +
                                '<ICAO>' + code +'</ICAO>' +
                                '</REQWX>',
                    },
                type: 'POST',
                // contentType: 'application/x-www-form-urlencoded',
                // dataType: 'text/plain; charset=utf-8',
                // dataType: 'text/html',
                success : function (xml) {
                    console.log(xml);
                },
                error : function (xhr, ajaxOptions, thrownError){
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });

        } else {
            $('#search-form').append('<h3 class="error-message"><strong>Code is not valid!!!</strong></h3>');
            $('.error-message').css({'color':'red'});
            setTimeout(function () {
                $('#search-form').find('.error-message').remove();
            }, 2000);
        }

        return false;
    });
}

/**
 * valid search form
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
    console.log('initAuth');
    $.ajax({
        crossOrigin: true,
        url: 'https://flydev.rocketroute.com/remote/auth',
        data:
            {
                'req':  '<?xml version="1.0" encoding="UTF-8" ?>' +
                '<AUTH><USR>medynskyypavlo@gmail.com</USR>' +
                '<PASSWD>3fhHkWBkbrkJ8Pk3NZDr</PASSWD>' +
                '<DEVICEID>e138231a68ad82f054e3d756c6634ba1</DEVICEID>' +
                '<PCATEGORY>RocketRoute</PCATEGORY>' +
                '<APPMD5>akUXPx57q6yXzrMM9f24</APPMD5>' +
                '</AUTH>',
            },
        type: 'POST',
        contentType: 'text/plain',
        // contentType: 'application/x-www-form-urlencoded',
        dataType: "text/plain; charset=utf-8",
        cache: false,
        // contentType: 'application/javascript',
        success : function (xml) {
            console.log(xml);
        },
        error : function (xhr, ajaxOptions, thrownError){
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}