$(document).ready( function () {
    // init map
    initMap();

    //search event
    $(document).on('click', '#search-btn', function (e) {
        console.log('click');

        return false;
    });
});
