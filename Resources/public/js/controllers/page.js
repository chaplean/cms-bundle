'use strict';

var cms = angular.module('Cms');

cms.controller('PageController', function($scope, $uibModal, $http, $log, $ngBootbox, Page, TranslationService, AlertService) {
    $scope.loadData = function() {
        if ($scope.pageId) {
            Page.get(
                {
                    pageId: $scope.pageId
                }, function(response) {
                    $scope.pageRoute = response.page;
                    $scope.pagePath = $scope.pageRoute.path;
                }
            );
        }
    };

    $scope.savePage = function (pageForm, formName, quit) {
        if (pageForm.$valid) {
            var page = {
                title: $scope.pageRoute.page.title,
                subtitle: $scope.pageRoute.page.subtitle,
                content: $scope.pageRoute.page.content,
                metaDescription: $scope.pageRoute.page.metaDescription,
                path: $scope.pageRoute.path,
                menuName: $scope.pageRoute.menuName,
                rollover: $scope.pageRoute.rollover
            };

            if ($scope.pageId) {
                Page.update({
                    pageId: $scope.pageId
                },
                page,
                function (response) {
                    $scope.pagePath = response.page.path;
                    AlertService.addAlert('success', TranslationService.trans('alert.page.updated'));

                    if (quit) {
                        window.location = Routing.generate('chaplean_cms_list');
                    }
                }, function (response) {
                    if(response.data.error) {
                        AlertService.addAlert('warning', response.data.error);
                    } else {
                        AlertService.addAlert('danger', TranslationService.trans('error.important'))
                    }
                });
            } else {
                Page.save(
                    page,
                    function (response) {
                        $scope.pagePath = response.page.path;
                        AlertService.addAlert('success', TranslationService.trans('alert.page.created'));

                        if (quit) {
                            window.location = Routing.generate('chaplean_cms_list');
                        }
                    }, function (errors) {
                        $log.error(errors);
                        AlertService.addAlert('danger', TranslationService.trans('error.important'))
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
