'use strict';

var cms = angular.module('Cms');

cms.factory('Media', function($resource) {

    return $resource(Routing.generate('cms_rest') + 'media/:id', {id: '@id'}, {
        getAll: {method: 'get', url: Routing.generate('cms_rest') + 'media/all', isArray: true}
    });

});
