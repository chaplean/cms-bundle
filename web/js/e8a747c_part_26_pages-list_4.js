'use strict';

var cms = angular.module('Cms');

cms.controller('clCmsPagesListController', function ($scope, $filter, Page, CmsRouter) {

    $scope.search = '';
    $scope.pages = [];
    $scope.page = {
        rollover: null,
        page:     {
            title:    null,
            subtitle: null,
            content:  null
        }
    };
    $scope.pageSize = 10;
    $scope.currentPage = 1;

    $scope.loadData = function () {
        Page.getAll({}, function (pages) {
            $scope.pages = [].concat(pages);
        });
    };

    $scope.go = CmsRouter.go;

    $scope.loadData();
});
