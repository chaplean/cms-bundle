'use strict';

var cms = angular.module('Cms');

cms.controller('PostController', function($scope, $uibModal, $http, $log, $ngBootbox, $filter,
                                          Post, PublicationStatus, Validator,
                                          TranslationService, AlertService, Datepicker) {

    $scope.publicationStatuses = [];
    $scope.post = {
        publication: {
            datePublicationBegin: null,
            datePublicationEnd: null
        }
    };
    $scope.datepicker = Datepicker;
    $scope.errors = {};

    $scope.loadData = function() {
        if ($scope.postId) {
            Post.get({postId: $scope.postId}, function(post) {

                    $scope.post = post;
                    if ($scope.post.publication.datePublicationBegin) {
                        $scope.post.publication.datePublicationBegin = moment($scope.post.publication.datePublicationBegin, 'YYYY-MM-DD').format('DD/MM/YYYY');
                    }
                    if ($scope.post.publication.datePublicationEnd) {
                        $scope.post.publication.datePublicationEnd = moment($scope.post.publication.datePublicationEnd, 'YYYY-MM-DD').format('DD/MM/YYYY');
                    }
                });
        }

        PublicationStatus.getAll(function (publicationStatus) {
            $scope.publicationStatuses = publicationStatus;
        });
    };

    $scope.savePost = function (postForm, formName, quit) {
        if (postForm.$valid) {
            var post = $scope.buildData($scope.post);

            if ($scope.postId) {
                Post.update({postId: $scope.postId}, post, function (post) {

                        $scope.post.dateUpdate = $filter('date')(post.dateUpdate, 'dd/MM/yyyy');
                        AlertService.addAlert('success', TranslationService.trans('alert.post.updated'));

                        if (quit) {
                            window.location = Routing.generate('cms_post_list');
                        }
                    }, function (response) {
                        if(response.data.error) {
                            AlertService.addAlert('warning', response.data.error);
                        } else {
                            AlertService.addAlert('danger', TranslationService.trans('error.important'))
                        }
                    });
            } else {
                Post.save(post, function (post) {
                        $scope.post.dateAdd = $filter('date')(post.dateAdd, 'dd/MM/yyyy');
                        AlertService.addAlert('success', TranslationService.trans('alert.post.created'));

                        if (quit) {
                            window.location = Routing.generate('cms_post_list');
                        }
                    }, function (errors) {
                        $log.error(errors);
                        $scope.errors = errors;
                        AlertService.addAlert('danger', TranslationService.trans('error.important'))
                    });
            }
        } else {
            console.log(postForm.$error);
        }
    };

    $scope.cancel = function () {
        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.leave_change')
        ).then(function() {
                window.location = Routing.generate('cms_post_list');
            }, function() {
                return false;
            }
        );
    };

    $scope.isRequire = Validator.isRequire;

    $scope.translateStatus = function (key) {
        return TranslationService.trans('publication_status.status.' + key);
    };

    $scope.buildData = function (post) {
        var postTmp = angular.copy(post);

        delete postTmp.id;
        delete postTmp.dateAdd;
        delete postTmp.dateUpdate;
        delete postTmp.page.id;
        delete postTmp.publication.id;
        delete postTmp.publication.dateAdd;
        delete postTmp.publication.dateUpdate;
        if (typeof postTmp.publication.datePublicationBegin == 'string') {
            postTmp.publication.datePublicationBegin = moment(postTmp.publication.datePublicationBegin, 'DD/MM/YYYY');
        }
        if (typeof postTmp.publication.datePublicationEnd == 'string') {
            postTmp.publication.datePublicationEnd = moment(postTmp.publication.datePublicationEnd, 'DD/MM/YYYY');
        }
        postTmp.publication.status = postTmp.publication.status.id;
        console.log(postTmp);

        return postTmp;
    };

    $scope.loadData();
});
