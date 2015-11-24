'use strict';

var cms = angular.module('Cms');

cms.service('Page', function($resource) {

    return $resource(Routing.generate('cms_rest') + 'pages', {}, {
        delete: {method: 'delete', url: Routing.generate('cms_rest') + 'pages/:pageId'},
        get:    {method: 'get'   , url: Routing.generate('cms_rest') + 'pages/:pageId'},
        getAll: {method: 'get'   , url: Routing.generate('cms_rest') + 'page/all', isArray: true},
        save:   {method: 'post'  , url: Routing.generate('cms_rest') + 'pages'        },
        update: {method: 'put'   , url: Routing.generate('cms_rest') + 'pages/:pageId'}
    });

});
