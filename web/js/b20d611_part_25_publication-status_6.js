'use strict';

var cms = angular.module('Cms');

cms.service('PublicationStatus', function ($resource) {

    return $resource(Routing.generate('cms_rest') + 'publicationstatuses', {}, {
        get:    {method: 'get', url:    Routing.generate('cms_rest') + 'publicationstatuses/:publicationStatusId'},
        getAll: {method: 'get', url:    Routing.generate('cms_rest') + 'publicationstatus/all', isArray: true}
    });

});
