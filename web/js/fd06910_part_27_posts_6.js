'use strict';

var cms = angular.module('Cms');

cms.controller('PostsController', function($scope, $uibModal, $filter, $ngBootbox, Post, PublicationStatus, TranslationService, AlertService) {

    $scope.search = '';
    $scope.post = {
        category: null
    };
    $scope.publicationStatuses = [];
    $scope.categories = [];
    $scope.category = 'all';

    $scope.loadData = function() {
        Post.getAll(
            {},
            function(posts) {
                $scope.posts = [].concat(posts);
                $scope.postsFiltered = [].concat(posts);
            }
        );

        PublicationStatus.getAll(function (publicationStatus) {
            $scope.publicationStatuses = [
                {
                    id: 0,
                    position: 0,
                    keyname: 'published_unpublished'
                }
            ];
            $scope.publicationStatuses = $scope.publicationStatuses.concat(publicationStatus);
            $scope.status = $scope.publicationStatuses[0];
            $scope.updateFilter();
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

    $scope.getters = {
        title: function (value) {
            return value.page.title;
        }
    };

    $scope.updateFilter = function () {
        $scope.postsFiltered = [].concat($scope.posts);

        if ($scope.status.id != 0) {
            $scope.postsFiltered = $filter('filter')($scope.postsFiltered, {publication: {status: {id: $scope.status.id}}});
        } else {
            $scope.postsFiltered = [].concat(
                $filter('filter')($scope.postsFiltered, {publication: {status: {id: 1}}}),
                $filter('filter')($scope.postsFiltered, {publication: {status: {id: 2}}})
            );
        }

        if ($scope.category != 'all') {
            $scope.postsFiltered = $filter('filter')($scope.postsFiltered, {category: $scope.category});
        } else {
            $scope.postsFiltered = [].concat($scope.postsFiltered);
        }
    };

    $scope.removePost = function (post) {
        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.delete_post', { 'post' : post.page.title })
        ).then(function() {
            Post.delete({
                    postId: post.id
                    },
                    function (post) {
                        $scope.posts.splice($scope.posts.indexOf(post), 1);
                        AlertService.addAlert('success', TranslationService.trans('alert.post.deleted'));
                    }, function () {
                        AlertService.addAlert('danger', TranslationService.trans('error.important'))
                    }
                );
            }, function() {
                return false;
            }
        );
    };

    $scope.loadData();
});
