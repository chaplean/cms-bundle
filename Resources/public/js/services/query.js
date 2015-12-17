'use strict';

var app = angular.module('Cms');

app.factory('clCmsQueryFactory', function($window) {
    return {
        buildParam: function (object) {
            var params = '?';

            angular.forEach(object, function (value, key) {
                if (value != null) {
                    if (typeof value == 'object') {
                        value = value.id
                    }

                    params += (params != '?' ? '&' : '') + key + '=' + value
                }
            });

            return params;
        },
        getParams: function () {
            var params = $window.location.search;
            params = params.match(/[\?&]([^\?&]\w+=[^&]*)/g);

            var object = {};
            angular.forEach(params, function (value) {
                var matches = value.replace(/[\?&#]/, '').match(/(\w+)=(.*)/);

                object[matches[1]] = decodeURIComponent(matches[2]);
            });

            return object;
        }
    };
});
