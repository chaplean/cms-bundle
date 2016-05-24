'use strict';

var cms = angular.module('Cms');

cms.factory('BackofficeListFactory', function (PublicationStatus) {
    var backofficeFactory = {};

    backofficeFactory.publicationStatuses = [];
    backofficeFactory.status = {
        id:       0,
        position: 0,
        keyname:  'published_unpublished'
    };

    backofficeFactory.ready = function (success, err) {
        PublicationStatus.getAll(function (publicationStatus) {
            var publicationStatuses = [backofficeFactory.status];
            backofficeFactory.publicationStatuses = publicationStatuses.concat(publicationStatus);

            success();
        }, function (error) {
            err(error);
        });
    };

    return backofficeFactory;
});
