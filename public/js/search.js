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
                // dataType: 'application/json',
                data:
                    {
                        'code': code
                    },
                success : function (xml) {
                    var xmlDoc = $.parseXML(xml)
                        xml = $( xmlDoc ),
                        notam = xml.find( "NOTAM" );

                    // check is not empty search resul
                    if (notam.length) {
                        renderMarker();
                    } else {
                        error('The result is empty. Please check input.');
                    }

                    console.log(notam);
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

function renderMarker() {
    console.log('renderMarker');
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