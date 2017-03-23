'use strict';

var cms = angular.module('Cms');

cms.controller('clCmsPostController', function($scope, $uibModal, $http, $log, $ngBootbox, $filter,
                                          Post, PublicationStatus, clCmsValidator, BackofficeEditFactory,
                                          TranslationService, Notification, clCmsDatepicker, CmsRouter, clCmsMenu) {

    clCmsMenu.setActive('post');
    $scope.publicationStatuses = [];
    $scope.post = {
        publication: {
            datePublicationBegin: null,
            datePublicationEnd: null
        }
    };
    $scope.datepicker = clCmsDatepicker;
    $scope.title = '';
    //$scope.postFactory = new clCmsObjectFactory('post', Post, 'postId');

    $scope.loadData = function() {
        BackofficeEditFactory.ready(function () {
            $scope.publicationStatuses = BackofficeEditFactory.publicationStatuses;
            $scope.post.publication.status = $scope.publicationStatuses[0];
            $scope.post.publication.isHighlighted = '0';

            if ($scope.postId) {
                Post.get({postId: $scope.postId}, function(post) {
                    $scope.post = post;
                    $scope.title = $scope.post.page.title;
                    if ($scope.post.publication.datePublicationBegin) {
                        $scope.post.publication.datePublicationBegin = moment($scope.post.publication.datePublicationBegin, 'YYYY-MM-DD').toDate();
                    }

                    if ($scope.post.publication.datePublicationEnd) {
                        $scope.post.publication.datePublicationEnd = moment($scope.post.publication.datePublicationEnd, 'YYYY-MM-DD').toDate();
                    }
                });
            }
        }, function (err) {
            $log.error(err);
        });
    };

    $scope.savePost = function (postForm, formName, quit, duplicate, duplication) {
        if (postForm.$valid && (!duplication || duplication)) {
            var post = $scope.buildData($scope.post);

            //$scope.postFactory.submit($scope.buildData, $scope.post, quit, duplicate, duplication)
            //    .then(function (post) {
            //        $scope.post = post;
            //});
            if ($scope.postId && !duplication) {
                Post.update({postId: $scope.postId}, post,
                    function (post) {

                        $scope.post.dateUpdate = $filter('date')(post.dateUpdate, 'dd/MM/yyyy');
                        $scope.title = $scope.post.page.title;
                        if (duplicate) {
                            $scope.post.page.title += (' ' + TranslationService.trans('global.duplicate'));
                            $scope.post.publication.status = $scope.publicationStatuses[1];
                            $scope.savePost(postForm, formName, quit, false, true);
                        } else {
                            Notification.success({message: TranslationService.trans('alert.post.updated'), delay: 5000});

                            if (quit) {
                                window.location = Routing.generate('cms_post_list');
                            }
                        }
                    }, function (response) {
                        if(response.status == 400) {
                            clCmsValidator.addError(postForm, response.data);
                            Notification.warning({message: TranslationService.trans('error.important'), delay: 5000});
                        } else {
                            Notification.error({message: TranslationService.trans('error.important'), delay: 5000});
                        }
                    });
            } else {
                Post.save(post, function (post) {
                        $scope.post.dateAdd = $filter('date')(post.dateAdd, 'dd/MM/yyyy');
                        $scope.postId = post.id;
                        $scope.title = $scope.post.page.title;

                        if (duplicate) {
                            $scope.post.page.title += (' ' + TranslationService.trans('global.duplicate'));
                            $scope.savePost(postForm, formName, quit, false, true);
                        } else {
                            if (duplication) {
                                Notification.success({message: TranslationService.trans('alert.post.duplicated'), delay: 5000});
                            } else {
                                Notification.success({message: TranslationService.trans('alert.post.created'), delay: 5000});
                            }

                            setTimeout(function () {
                                if (quit) {
                                    window.location = Routing.generate('cms_post_list');
                                } else {
                                    CmsRouter.go('cms_post_edit', {postId: $scope.postId});
                                }
                            }, 500);
                        }
                    }, function (errors) {
                        $log.error(errors);
                        $scope.errors = errors;
                        Notification.error({message: TranslationService.trans('error.important'), delay: 5000});
                    });
            }
        } else {
            console.log(postForm);
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

    $scope.isRequire = clCmsValidator.isRequire;
    $scope.onError = clCmsValidator.onError;
    $scope.isInvalidFieldSumitted = clCmsValidator.isInvalidFieldSumitted;
    $scope.getInvalidError = clCmsValidator.getInvalidError;

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
        if (!postTmp.publication.isHighlighted && postTmp.publication.isHighlighted !== false) {
            postTmp.publication.isHighlighted = false;
        }
        postTmp.publication.status = postTmp.publication.status.id;
        console.log(postTmp);

        return postTmp;
    };

    $scope.loadData();
});
