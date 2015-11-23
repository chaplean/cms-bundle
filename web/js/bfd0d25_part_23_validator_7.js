'use strict';

var cms = angular.module('Cms');

cms.factory('Validator', function() {

    var validator = {};

    validator.isRequire = function (form, name) {
        return form.$invalid && form[name] && (form[name].$touched || form.$submitted) && form[name].$error.required;
    };

    validator.getError = function (errors, form, name) {
        var onError = form[name] && (form[name].$touched || form.$submitted) && errors[name];

        if (onError) {
            return errors[name];
        }

        return false;
    };

    return validator;
});
