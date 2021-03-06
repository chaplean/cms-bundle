'use strict';

var cms = angular.module('Cms');

cms.controller('clCmsPostsController', function($scope, $log, $uibModal, $filter, $ngBootbox, Post, TranslationService, Notification, BackofficeListFactory, clCmsMenu) {

    clCmsMenu.setActive('post');
    $scope.search = '';
    $scope.post = {
        category: null
    };
    $scope.posts = [];
    $scope.postsFiltered = [];
    $scope.postsDisplayed = [];

    $scope.categories = [];
    $scope.category = 'all';

    $scope.status = {};
    $scope.publicationStatuses = [];


    $scope.loadData = function() {
        BackofficeListFactory.ready(function () {
            $scope.publicationStatuses = BackofficeListFactory.publicationStatuses;
            $scope.status = BackofficeListFactory.status;

            Post.getAll({},
                function(posts) {
                    $scope.posts = [].concat(posts);
                    $scope.postsFiltered = [].concat(posts);

                    Post.getAvailableCategories(function (categories) {
                        $scope.categories = categories;
                        if ($scope.categories.length == 1) {
                            $scope.category = $scope.categories[0];
                        } else {
                            $scope.categories.push('all');
                        }
                        $scope.updateFilter();
                    });
                }
            );
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
            $scope.postsFiltered = $filter('filter')($scope.postsFiltered, {publication: {status: {id: $scope.status.id}}}, true);
        } else {
            $scope.postsFiltered = [].concat(
                $filter('filter')($scope.postsFiltered, {publication: {status: {keyname: 'published'}}}, true),
                $filter('filter')($scope.postsFiltered, {publication: {status: {keyname: 'unpublished'}}}, true)
            );
        }

        if ($scope.category != 'all') {
            $scope.postsFiltered = $filter('filter')($scope.postsFiltered, {category: $scope.category}, true);
        } else {
            $scope.postsFiltered = [].concat($scope.postsFiltered);
        }

        $scope.postsFiltered = $filter('postFilter')($scope.postsFiltered, $scope.search);
    };

    $scope.removePost = function (post) {

        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.delete_post', { 'post' : post.page.title })
        ).then(function() {
            Post.delete(
                {postId: post.id},
                function () {
                    var indexSplice = -1;
                    angular.forEach($scope.posts, function (value, index) {
                        if (indexSplice == -1 && value.id == post.id) {
                            indexSplice = index;
                        }
                    });
                    console.log(indexSplice, post.id);
                    $scope.posts.splice(indexSplice, 1);
                    $scope.updateFilter();
                    Notification.success({message: TranslationService.trans('alert.post.deleted'), delay: 5000});
                }, function () {
                    Notification.error({message: TranslationService.trans('error.important'), delay: 5000});
                }
            );
        }, function() {
            return false;
        });
    };

    $scope.loadData();
});
