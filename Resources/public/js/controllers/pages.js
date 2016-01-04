'use strict';

var cms = angular.module('Cms');

cms.controller('PagesController', function($scope, $uibModal, $http, $ngBootbox, Page, TranslationService, CmsAlertService) {

    $scope.$parent.menu.active = 'page';

    $scope.search = '';
    $scope.loadData = function() {
        Page.getAll({}, function(pages) {
                $scope.pages = pages;
                $scope.pagesDisplayed = [].concat($scope.pages);
            }
        );
    };

    $scope.getters = {
        title: function (value) {
            return value.page.title;
        },
        metaDescription: function (value) {
            return value.page.metaDescription;
        }
    };

    $scope.removePage = function (pageRoute) {
        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.delete_page', { 'page' : pageRoute.page.title })
        ).then(function() {
                Page.delete({
                        pageId: pageRoute.id
                    },
                    function (page) {
                        $scope.pages.splice($scope.pages.indexOf(page), 1);
                        CmsAlertService.addAlert('success', TranslationService.trans('alert.page.deleted'), 1.5);
                    }, function () {
                        CmsAlertService.addAlert('danger', TranslationService.trans('error.important'), 1.5)
                    }
                );
            }, function() {
                return false;
            }
        );
    };

    $scope.loadData();
});
