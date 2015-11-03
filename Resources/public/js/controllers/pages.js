'use strict';

var app = angular.module('App');

app.controller('PagesController', function($scope, $uibModal, $http, $ngBootbox, Page, TranslationService, AlertService) {
    $scope.search = '';

    $scope.loadData = function() {
        $scope.pages = Page.getAll();
        $scope.pagesDisplayed = [].concat($scope.pages);
    };

    $scope.getters = {
        title: function (value) {
            return value.pageContent.title;
        },
        metaDescription: function (value) {
            return value.pageContent.metaDescription;
        }
    };

    $scope.removePage = function (page) {
        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.delete_page', { 'page' : page.pageContent.title })
        ).then(function() {
                Page.delete({
                        pageId: page.id
                    },
                    function (page) {
                        $scope.pages.splice($scope.pages.indexOf(page), 1);
                        AlertService.addAlert('success', TranslationService.trans('alert.page.deleted'));
                    }, function (response) {
                        AlertService.addAlert('danger', TranslationService.trans('error.important.title'))
                    }
                );
            }, function() {
                return false;
            }
        );
    };

    $scope.loadData();
});
