(function () {
// $(document).ready(function () {
    // define config obj
    var config = {
            'renderPath': 'main' // element where you want to render component
        },
        map = {};

    // render search form and map
    render(config.renderPath);

    // init map
    initMap();

    search();

// });
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
                headers: {
                    "Access-Control-Allow-Origin: ": "*",
                    "Access-Control-Allow-Methods: ": "POST",
                    "Access-Control-Allow-Headers: ": "Authorization"
                },
                url: 'https://fly.rocketroute.com/remote/auth',
                data: {
                        'req': '<?xml version="1.0" encoding="UTF-8" ?>' +
                                '<AUTH><USR>medynskyypavlo@gmail.com</USR>' +
                                '<PASSWD>3fhHkWBkbrkJ8Pk3NZDr</PASSWD>' +
                                '<DEVICEID>1299f2aa8935b9ffabcd4a2cbcd16b8d45691629</DEVICEID>' +
                                '<PCATEGORY>RocketRoute</PCATEGORY>' +
                                '<APPMD5>akUXPx57q6yXzrMM9f24</APPMD5>' +
                                '</AUTH>'
                    },
                type: 'POST',
                crossDomain: true,
                contentType: 'utf-8',
                dataType: 'text',
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
    var el = $('#map');
    console.log(el);
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
}