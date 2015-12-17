'use strict';

var cms = angular.module('Cms');

cms.controller('PostsListController', function ($scope, $location, $filter, Post, CmsRouter, clCmsQueryFactory) {

    $scope.search = '';
    $scope.post = {
        category: null,
        page:     {
            title:    null,
            subtitle: null,
            content:  null
        }
    };
    $scope.publicationStatuses = [];
    $scope.categories = [];
    $scope.category = null;
    $scope.pageSize = 10;
    $scope.currentPage = 1;

    $scope.loadData = function () {
        Post.getAllActive({}, function (posts) {
            $scope.posts = [].concat(posts);
            $scope.postsFiltered = [].concat(posts);
        });

        Post.getAvailableCategories(function (categories) {
            var parameters = clCmsQueryFactory.getParams();
            $scope.categories = categories;

            if (parameters.category && $scope.categories.indexOf(parameters.category) != -1) {
                $scope.category = parameters.category;
                $scope.updateFilter();
            } else {
                $scope.category = 'all';
            }

            if ($scope.categories.length == 1 && $scope.category == null) {
                $scope.category = $scope.categories[0];
            } else {
                $scope.categories.push('all');
            }
        });
    };

    $scope.updateFilter = function () {
        $scope.postsFiltered = [].concat($scope.posts);

        if ($scope.category != 'all') {
            $scope.postsFiltered = $filter('filter')($scope.postsFiltered, {category: $scope.category});
        } else {
            $scope.postsFiltered = [].concat($scope.postsFiltered);
        }
    };

    $scope.updateCategory = function (category) {
        $scope.category = category;
        $scope.updateFilter();
    };

    $scope.go = CmsRouter.go;

    $scope.loadData();
});
