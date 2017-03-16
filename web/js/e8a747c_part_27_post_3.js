'use strict';

var cms = angular.module('Cms');

cms.filter('postFilter', function(TranslationService) {
    return function (items, search) {
        if (!search) {
            return items;
        }
        search = search.toLowerCase();

        return items.filter(function (e) {
            return (TranslationService.trans('post.category.' + e.category).toLowerCase()).indexOf(search) !== -1
                || (e.page.title.toLowerCase()).indexOf(search) !== -1;
        });
    }
});
