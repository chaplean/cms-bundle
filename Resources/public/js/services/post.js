'use strict';

var cms = angular.module('Cms');

cms.service('Post', function($resource) {

    return $resource(Routing.generate('cms_rest') + 'posts', {}, {
        delete:        {method: 'delete', url: Routing.generate('cms_rest') + 'posts/:postId'},
        get:           {method: 'get'   , url: Routing.generate('cms_rest') + 'posts/:postId'},
        getAll:        {method: 'get'   , url: Routing.generate('cms_rest') + 'post/all', isArray: true},
        getByCategory: {method: 'get'   , url: Routing.generate('cms_rest') + 'post/:category/category'},
        save:          {method: 'post'  , url: Routing.generate('cms_rest') + 'posts'},
        update:        {method: 'put'   , url: Routing.generate('cms_rest') + 'posts/:postId'}
    });

});
