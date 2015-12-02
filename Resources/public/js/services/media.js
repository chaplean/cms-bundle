'use strict';

var cms = angular.module('Cms');

cms.factory('Media', function($resource) {

    return $resource(Routing.generate('cms_rest') + 'media/:id', {id: '@id'}, {
        save: {method: 'post', url: Routing.generate('cms_rest') + 'media/:id/edits'},
        getAll: {method: 'get', url: Routing.generate('cms_rest') + 'media/all', isArray: true}
    });

});
