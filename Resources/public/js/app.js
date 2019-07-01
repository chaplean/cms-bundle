'use strict';

var cms = angular.module('Cms', [
    'ngAnimate', 'ngResource', 'ngSanitize', 'ngBootbox', 'ui.bootstrap',
    'ui.mask', 'boxuk.translation', 'textAngular', 'smart-table',
    'angularUtils.directives.dirPagination', 'angularMoment', 'angularFileUpload',
    'ui-notification'
]);

cms.config(function ($interpolateProvider, $httpProvider) {
    $interpolateProvider.startSymbol('{^').endSymbol('^}');

    // disable IE ajax request caching (to prevent cache on rest calls)
    $httpProvider.interceptors.push(function() {
        return {
            'request': function(config) {
                // startsWith (since IE doesn't support it)
                if (config.url.lastIndexOf('http', 0) !== 0) {
                    config.headers['If-Modified-Since'] = 'Mon, 26 Jul 1997 05:00:00 GMT';
                    config.headers['Cache-Control'] = 'no-cache';
                    config.headers['Pragma'] = 'no-cache';
                }

                return config;
            }
        };
    });

    // Recursively search for dates and transform the timezome part to please IE
    $httpProvider.defaults.transformResponse.push(function (responseData) {
        function convertDateStringsToDates(input) {
            if (typeof input !== "object") {
                return input;
            }

            for (var key in input) {
                if (!input.hasOwnProperty(key)) {
                    continue;
                }

                var value = input[key];
                // Check for string properties which look like dates.
                if (typeof value === "string" && value.match(/^[\d-]*T[\d:]*\+\d{4}$/)) {
                    input[key] = value.replace(/(\d\d)(\d\d)$/, '$1:$2');
                } else if (typeof value === "object") {
                    convertDateStringsToDates(value);
                }
            }
        }

        convertDateStringsToDates(responseData);
        return responseData;
    });
});

cms.run(function(amMoment) {
    amMoment.changeLocale(locale);
});

cms.controller('clCmsMainController', function($scope, $rootScope, $window, Post, $ngBootbox, TranslationService, CmsRouter, clCmsMenu) {

    angular.element($window).bind('scroll', function() {
        var elTextAngular = angular.element('text-angular');
        var that = this;

        angular.forEach(elTextAngular, function (textAngular) {
            var el = angular.element(textAngular);
            var offsetToolbar = el.offset().top;
            var id = el.attr('id');
            $rootScope.textAngularToolbarTopFixed[id] = that.pageYOffset >= offsetToolbar && that.pageYOffset < offsetToolbar + angular.element('text-angular#' + id + ' .ta-scroll-window').height();
        });

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
        CONFIRM: TranslationService.trans('button.validate.global')
    });
    $ngBootbox.setLocale(locale);

    $rootScope.path = function (url, options) {
        return Routing.generate(url, options);
    };

    $scope.CmsRouter = CmsRouter;
    $scope.menu = clCmsMenu;
});
