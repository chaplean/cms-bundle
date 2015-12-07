'use strict';

var cms = angular.module('Cms');

cms.filter('postFilter', function() {
    return function (items, search) {
        if (!search) {
            return items;
        }
        search = search.toLowerCase();

        return items.filter(function (e) {
            return (e.category.toLowerCase().indexOf(search) !== -1)
                || (e.page.title.toLowerCase().indexOf(search) !== -1);
        });
    }
});
