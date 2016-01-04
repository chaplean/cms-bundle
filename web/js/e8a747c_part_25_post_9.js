'use strict';

var cms = angular.module('Cms');

cms.service('Post', function($resource) {

    return $resource(Routing.generate('cms_rest') + 'posts', {}, {
        delete:                 {method: 'delete', url: Routing.generate('cms_rest') + 'posts/:postId'},
        get:                    {method: 'get'   , url: Routing.generate('cms_rest') + 'posts/:postId'},
        getAvailableCategories: {method: 'get'   , url: Routing.generate('cms_rest') + 'post/available/categories', isArray: true},
        getAll:                 {method: 'get'   , url: Routing.generate('cms_rest') + 'post/all', isArray: true},
        getAllActive:           {method: 'get'   , url: Routing.generate('cms_rest') + 'post/all/active', isArray: true},
        getByCategory:          {method: 'get'   , url: Routing.generate('cms_rest') + 'posts/:category/category', isArray: true},
        save:                   {method: 'post'  , url: Routing.generate('cms_rest') + 'posts'},
        update:                 {method: 'put'   , url: Routing.generate('cms_rest') + 'posts/:postId'}
    });

});
