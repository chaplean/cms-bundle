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

cms.controller('MainController', function($scope, $rootScope, $window, Post, CmsAlertService, $ngBootbox, TranslationService, CmsRouter) {

    angular.element($window).bind('scroll', function() {
        var offsetToolbar = angular.element('text-angular').offset().top;
        $rootScope.textAngularToolbarTopFixed = this.pageYOffset >= offsetToolbar && this.pageYOffset < offsetToolbar + angular.element('text-angular .ta-scroll-window').height();

        $scope.safeApply();
    });

    $scope.safeApply = function(fn) {
        var phase = this.$root.$$phase;
        if(phase == '$apply' || phase == '$digest') {
            if(fn && (typeof(fn) === 'function')) {
                fn();
            }
        } else {
            this.$apply(fn);
        }
    };

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
    $scope.menu = {
        active: ''
    };

    $scope.activeMenu = function (menu) {
        $scope.menu.active = menu;
    }
});
