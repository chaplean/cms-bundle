'use strict';

var cms = angular.module('Cms');

cms.filter('pageFilter', function() {
    return function (items, search) {
        if (!search) {
            return items;
        }
        search = search.toLowerCase();
        return items.filter(function (e) {
            return (e.path.toLowerCase().indexOf(search) !== -1)
                || (e.pageContent.title.toLowerCase().indexOf(search) !== -1)
                || (e.pageContent.metaDescription.toLowerCase().indexOf(search) !== -1);
        });
    }
});
