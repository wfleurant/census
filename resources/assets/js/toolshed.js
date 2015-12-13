/* Toolshed.JS */

/* Resources from from dsnidata/census/tracts.json */
var tracts = function(url) {

    console.log('API::tracts(%s)', url);
    return $.ajax({
        url: url,
        type: 'get',
        data: {},
        success: function (data) {
            return data;
        }
    });

};
