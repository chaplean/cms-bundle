'use strict';

var cms = angular.module('Cms');

cms.controller('PageController', function($scope, $uibModal, $http, $log, $ngBootbox, Page, TranslationService, AlertService) {
    $scope.loadData = function() {
        if ($scope.pageId) {
            $scope.pageRoute = Page.get({pageId: $scope.pageId});

            $scope.pageRoute.$promise.then(function() {
                $scope.pagePath = $scope.pageRoute.path;
            });
        }
    };

    $scope.savePage = function (pageForm, quit) {
        if (pageForm.$valid) {
            var page = {
                path: $scope.pageRoute.path,
                label: $scope.pageRoute.label,
                rollover: $scope.pageRoute.rollover,
                title: $scope.pageRoute.page.title,
                metaDescription: $scope.pageRoute.page.metaDescription,
                content: $scope.pageRoute.page.content
            };

            if ($scope.pageId) {
                Page.update({
                    pageId: $scope.pageId
                },
                page,
                function (page) {
                    $scope.pagePath = page.path;
                    AlertService.addAlert('success', TranslationService.trans('alert.page.updated'));

                    if (quit) {
                        window.location = Routing.generate('chaplean_cms_list');
                    }
                }, function (response) {
                    if(response.data.error) {
                        AlertService.addAlert('warning', response.data.error);
                    } else {
                        AlertService.addAlert('danger', TranslationService.trans('error.important.title'))
                    }
                });
            } else {
                Page.save(page,
                    function (page) {
                        $scope.pagePath = page.path;
                        AlertService.addAlert('success', TranslationService.trans('alert.page.created'));

                        if (quit) {
                            window.location = Routing.generate('chaplean_cms_list');
                        }
                    }, function (errors) {
                        $log.error(errors);
                        AlertService.addAlert('danger', TranslationService.trans('error.important.title'))
                    });
            }
        } else {
            console.log(pageForm.$error);
        }
    };

    $scope.cancel = function () {
        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.leave_change')
        ).then(function() {
                window.location = Routing.generate('chaplean_cms_list');
            }, function() {
                return false;
            }
        );
    };

    $scope.isRequire = function (form, name) {
        return form.$invalid && form[name] && form[name].$touched && form[name].$error.required;
    };


    $scope.loadData();
});
