'use strict';

var cms = angular.module('Cms');

cms.factory('Validator', function() {

    var validator = {
        errors: {}
    };

    validator.isRequire = function (form, name) {
        return validator.onError(form, name, 'required');
    };

    validator.onError = function (form, name, type) {
        return form.$invalid && form[name] && (form[name].$touched || form.$submitted) && form[name].$error[type];
    };

    validator.addError = function (form, errors) {
        angular.forEach(errors, function (error, field) {
            if (form.hasOwnProperty(field)) {
                validator.errors[field] = error;
            }
        });
    };

    validator.isInvalidFieldSumitted = function (name) {
        //console.log(validator.errors, name);
        return typeof validator.errors[name] != 'undefined';
    };

    validator.getInvalidError = function(name) {
        return validator.isInvalidFieldSumitted(name) ? validator.errors[name] : '';
    };

    return validator;
});
