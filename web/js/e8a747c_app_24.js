'use strict';

var cms = angular.module('Cms', [
    'ngAnimate', 'ngResource', 'ngSanitize', 'ngBootbox', 'ui.bootstrap',
    'ui.mask', 'boxuk.translation', 'textAngular', 'smart-table',
    'angularUtils.directives.dirPagination', 'angularMoment', 'angularFileUpload'

]);

cms.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{^').endSymbol('^}');
});

cms.run(function(amMoment) {
    amMoment.changeLocale(locale);
});

cms.controller('MainController', function($scope, $rootScope, Post, CmsAlertService) {

    $rootScope.path = function (url, options) {
        return Routing.generate(url, options);
    };

    $scope.alerts = CmsAlertService.alerts;

    $scope.closeAlert = function (index) {
        CmsAlertService.closeAlert(index);
    };
});
