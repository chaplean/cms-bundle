'use strict';

var cms = angular.module('Cms');

cms.controller('PostsListController', function ($scope, $filter, Post, CmsRouter) {

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
    $scope.category = 'all';
    $scope.pageSize = 10;
    $scope.currentPage = 1;

    $scope.loadData = function () {
        Post.getAllActive({}, function (posts) {
            $scope.posts = [].concat(posts);
            $scope.postsFiltered = [].concat(posts);
        });

        Post.getAvailableCategories(function (categories) {
            $scope.categories = categories;
            if ($scope.categories.length == 1) {
                $scope.category = $scope.categories[0];
            } else {
                $scope.categories.push('all');
            }
            $scope.updateFilter();
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
