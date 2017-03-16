'use strict';

var cms = angular.module('Cms');

cms.filter('blockFilter', function() {
    return function (items, search) {
        if (!search) {
            return items;
        }
        search = search.toLowerCase();

        return items.filter(function (e) {
            return String(e.id).toLowerCase().indexOf(search) !== -1 || e.name.toLowerCase().indexOf(search) !== -1;
        });
    }
});
