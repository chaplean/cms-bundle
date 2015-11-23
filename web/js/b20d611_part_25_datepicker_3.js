'use strict';

var cms = angular.module('Cms');

cms.factory('Datepicker', function() {

    var datepicker = {};

    datepicker.options = {
        startingDay: 1
    };

    datepicker.open = function ($event, ind) {
        $event.preventDefault();
        $event.stopPropagation();

        datepicker['open' + ind] = true;
    };

    return datepicker;
});
