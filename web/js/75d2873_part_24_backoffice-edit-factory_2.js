'use strict';

var cms = angular.module('Cms');

cms.factory('BackofficeEditFactory', function (PublicationStatus) {
    var backofficeFactory = {};

    backofficeFactory.publicationStatuses = [];

    backofficeFactory.ready = function (success, err) {
        PublicationStatus.getAll(function (publicationStatus) {
            backofficeFactory.publicationStatuses = publicationStatus;

            success();
        }, function (error) {
            err(error);
        });
    };

    return backofficeFactory;
});
