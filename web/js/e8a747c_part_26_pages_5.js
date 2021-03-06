'use strict';

var cms = angular.module('Cms');

cms.controller('clCmsPagesController', function($scope, $filter, $uibModal, $http, $ngBootbox, Page, TranslationService, Notification, clCmsMenu) {
    clCmsMenu.setActive('page');

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

    $scope.updateFilter = function () {
        $scope.pagesDisplayed = [].concat($scope.pages);
        $scope.pagesDisplayed = $filter('pageFilter')($scope.pagesDisplayed, $scope.search);
    };

    $scope.removePage = function (pageRoute) {
        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.delete_page', { 'page' : pageRoute.page.title })
        ).then(function() {
                Page.delete({
                        pageId: pageRoute.id
                    },
                    function () {
                        var indexSplice = -1;
                        angular.forEach($scope.pages, function (value, index) {
                            if (value.id == pageRoute.id) {
                                indexSplice = index;
                            }
                        });
                        $scope.pages.splice(indexSplice, 1);
                        $scope.updateFilter();
                        Notification.success({message: TranslationService.trans('alert.page.deleted'), delay: 5000});
                    }, function () {
                        Notification.error({message: TranslationService.trans('error.important'), delay: 5000})
                    }
                );
            }, function() {
                return false;
            }
        );
    };

    $scope.loadData();
});
