'use strict';

var cms = angular.module('Cms', [
    'ngAnimate', 'ngResource', 'ngSanitize', 'ngBootbox', 'ui.bootstrap',
    'ui.mask', 'boxuk.translation', 'textAngular', 'smart-table',
    'angularUtils.directives.dirPagination'

]);

cms.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{^').endSymbol('^}');
});

cms.controller('MainController', function($scope, $rootScope, AlertService) {
    $rootScope.path = function (url, options) {
        return Routing.generate(url, options);
    };

    $scope.alerts = AlertService.alerts;

    $scope.closeAlert = function (index) {
        AlertService.closeAlert(index);
    };
});
