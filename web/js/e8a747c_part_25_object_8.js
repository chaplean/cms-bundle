'use strict';

var app = angular.module('Cms');

app.factory('clCmsObjectFactory', function($q, $filter) {
    return function (transalationKey, reference, updateKey) {
        var objectFactory = {
            transalationKey: transalationKey,
            reference: reference,
            updateKey: updateKey,
            /**
             * @param {function} buildParam
             * @param object
             * @param quit
             * @param duplicate
             * @param duplication
             */
            submit: function (buildParam, object, quit, duplicate, duplication) {
                var deffered = $q.defer();
                var objectToSubmit = buildParam(object);

                if(object.id && !duplication) {
                    var param = {};
                    param[objectFactory.updateKey] = object.id;
                    /** @namespace reference.entity */
                    objectFactory.reference.update(param, objectToSubmit, function (objectSubmitted) {
                        objectSubmitted.dateUpdate = $filter('date')(objectSubmitted.dateUpdate, 'dd/MM/yyyy');
                        deffered.resolve(objectSubmitted);
                    }, function (err) {
                        deffered.reject(err);
                    });
                } else {
                    /** @namespace reference.entity */
                    objectFactory.reference.save(objectToSubmit, function (objectSubmitted) {
                        objectSubmitted.dateAdd = $filter('date')(objectSubmitted.dateAdd, 'dd/MM/yyyy');
                        deffered.resolve(objectSubmitted);
                    }, function (err) {
                        deffered.reject(err);
                    });
                }

                return deffered.promise;
            }
        };
        return objectFactory;
    };
});
