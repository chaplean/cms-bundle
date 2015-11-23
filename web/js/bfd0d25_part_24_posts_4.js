'use strict';

var cms = angular.module('Cms');

cms.controller('PostsController', function($scope, $uibModal, $filter, $ngBootbox, Post, TranslationService, AlertService) {
    $scope.search = '';

    $scope.post = {
        category: null
    };

    $scope.loadData = function() {
        Post.getAll(
            {},
            function(posts) {
                $scope.posts = [].concat(posts);
                $scope.postsDisplayed = [].concat($scope.posts);
                console.log($scope.posts);
            }
        );
    };

    $scope.getters = {
        title: function (value) {
            return value.page.title;
        }
    };

    $scope.filterPosts = function (posts, search) {
        return $filter('postFilter')(posts, search);
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
