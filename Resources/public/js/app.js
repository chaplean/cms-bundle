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

cms.controller('clCmsMainController', function($scope, $rootScope, $window, Post, CmsAlertService, $ngBootbox, TranslationService, CmsRouter, clCmsMenu) {

    angular.element($window).bind('scroll', function() {
        var elTextAngular = angular.element('text-angular');

        if (elTextAngular) {
            var offsetToolbar = elTextAngular.offset().top;
            $rootScope.textAngularToolbarTopFixed = this.pageYOffset >= offsetToolbar && this.pageYOffset < offsetToolbar + angular.element('text-angular .ta-scroll-window').height();
        }
    });

    $ngBootbox.addLocale('fr', {
        OK:      TranslationService.trans('button.validate.global'),
        CANCEL:  TranslationService.trans('button.cancel.global'),
        CONFIRM: TranslationService.trans('button.confirm.global')
    });
    $ngBootbox.setLocale(locale);

    $rootScope.path = function (url, options) {
        return Routing.generate(url, options);
    };

    $scope.alerts = CmsAlertService.alerts;

    $scope.closeAlert = function (index) {
        CmsAlertService.closeAlert(index);
    };

    $scope.CmsRouter = CmsRouter;
    $scope.menu = clCmsMenu;
});
