'use strict';

var cms = angular.module('Cms');

cms.factory('CmsRouter', function ($window) {
    var router = {
        path: function (url, options) {
            return Routing.generate(url, options);
        },

        go: function (url, options, params) {
            var location = router.path(url, options);

            if (params) {
                location += '#';
            }

            router.goHttp(location, params);
        },

        goHttp: function (location, params) {
            if (params) {
                var i = 0;

                angular.forEach(params, function (value, key) {
                    location += (i ? '&' : '?') + key + '=' + value;
                    i++;
                });
            }

            $window.location = location;
        }
    };

    return router;
});