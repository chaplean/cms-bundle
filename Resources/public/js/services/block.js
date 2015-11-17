'use strict';

var cms = angular.module('Cms');

cms.service('Block', function($resource) {

    return $resource(Routing.generate('cms_rest') + 'blocks', {}, {
        delete: {method: 'delete', url: Routing.generate('cms_rest') + 'blocks/:blockId'},
        get:    {method: 'get'   , url: Routing.generate('cms_rest') + 'blocks/:blockId'},
        getAll: {method: 'get'   , url: Routing.generate('cms_rest') + 'block/all'      },
        save:   {method: 'post'  , url: Routing.generate('cms_rest') + 'blocks'         },
        update: {method: 'put'   , url: Routing.generate('cms_rest') + 'blocks/:blockId'}
    });

});
