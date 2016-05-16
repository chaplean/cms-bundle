'use strict';

var cms = angular.module('Cms');

cms.config(function ($provide) {
    $provide.decorator('taOptions', function (taRegisterTool, $delegate, TranslationService, $uibModal) {
        taRegisterTool('mediaManager', {
            buttontext: TranslationService.trans('media_manager.open.label'),
            iconclass:  'fa fa-file-image-o open-media-manager',
            action:     function () {

                var that = this;

                var modalInstance = $uibModal.open({
                    animation:   true,
                    templateUrl: 'media-manager-modal.html',
                    controller:  'MediaManager',
                    size:        'lg'
                });
                modalInstance.result.then(function (media) {
                    var text = '';
                    if (media.category == 'image') {
                        text = '<img src="' + Routing.generate('cms_media_download') + '/' + media.id + '" title="' + media.title + '" alt="' + media.alternativeTitle + '"/>';
                    } else {
                        text = '<a href="' + Routing.generate('cms_media_download') + '/' + media.id + '">' + media.title + '</a>';
                    }

                    that.$editor().wrapSelection('insertHtml', text, true);
                });
            }
        });

        $delegate.toolbar[3].splice($delegate.toolbar[3].length - 2, 0, 'mediaManager');
        return $delegate;
    });
});

cms.controller('MediaManager', function ($scope, $http, $uibModalInstance, filterFilter, Media, CmsAlertService, TranslationService, FileUploader, FileItem) {

    $scope.updateFilter = function () {
        $scope.mediasFiltered = filterFilter($scope.medias, $scope.mediaFilter);
    };

    $scope.medias = Media.getAll().$promise.then(function (data) {
        $scope.medias = data;
        $scope.medias.forEach(function (media) {
            $scope.mediaInit(media);
        });
        $scope.updateFilter();
    }, function () {
        $scope.medias = [];
        $scope.updateFilter();
    });

    $scope.nameFilter = null;
    $scope.sortType = 'dateUpdate';
    $scope.categoryFilter = null;

    $scope.selectedMedia = null;

    $scope.newMediaFile = null;
    $scope.editMediaFile = null;

    $scope.detailsForm = {};

    $scope.newUploader = new FileUploader({
        url:           Routing.generate('cms_rest') + 'media',
        autoUpload:    true,
        onSuccessItem: function (item, newMedia) {
            $scope.mediaInit(newMedia);
            $scope.selectMedia(newMedia);
            $scope.medias.push(newMedia);
            $scope.updateFilter();
        },
        onErrorItem:   function (xhr, msg, status) {
            if (status == 400) {
                CmsAlertService.addAlert('danger', TranslationService.trans('media_manager.alert.invalid_extension'), 5);
            } else {
                CmsAlertService.addAlert('danger', TranslationService.trans('media_manager.alert.upload'), 5);
            }
        }
    });

    $scope.editUploader = new FileUploader({
        autoUpload:         true,
        onSuccessItem:      function (item, updatedMedia) {
            $scope.mediaInit(updatedMedia);
            updatedMedia.decachedPath = updatedMedia.path + '?' + new Date().getTime();
            angular.extend($scope.selectedMedia, updatedMedia);
        },
        onErrorItem:        function () {
            CmsAlertService.addAlert('danger', TranslationService.trans('media_manager.alert.upload'), 5);
        },
        onBeforeUploadItem: function (item) {
            item.url = Routing.generate('cms_rest') + 'media' + $scope.selectedMedia.id + '/edits';
        }
    });

    $scope.quitInsertMedia = function () {
        $uibModalInstance.close($scope.selectedMedia);
    };

    $scope.quitWithoutMedia = function () {
        $uibModalInstance.dismiss();
    };

    $scope.mediaFilter = function (value, index, array) {
        if ($scope.nameFilter) {
            if (value.fileName.toLowerCase().indexOf($scope.nameFilter.toLowerCase()) == -1) {
                return false;
            }
        }

        if ($scope.categoryFilter) {
            if (value.category != $scope.categoryFilter) {
                return false;
            }
        }

        return true;
    };

    $scope.selectMedia = function (media) {
        $scope.selectedMedia = media;

        $http.get(media.decachedPath)
            .error(function () {
                $scope.selectedMedia.notFound = true;
            });
    };

    $scope.insertCurrentMedia = function () {
        if ($scope.selectedMedia.category == 'image') {
            var data = {
                title:            $scope.selectedMedia.title,
                alternativeTitle: $scope.selectedMedia.alternativeTitle
            };
        } else if ($scope.selectedMedia.category == 'pdf') {
            var data = {
                title: $scope.selectedMedia.title
            };
        }

        if (typeof data != 'undefined') {
            Media.save({id: $scope.selectedMedia.id}, data);
        }
        $scope.quitInsertMedia();
    };

    $scope.deleteCurrentMedia = function () {
        Media.delete({id: $scope.selectedMedia.id}, {}, function (data) {
            var position = $scope.medias.indexOf($scope.selectedMedia);
            $scope.medias.splice(position, 1);
            $scope.selectedMedia = null;
            $scope.updateFilter();
        }, function () {
            CmsAlertService.addAlert('danger', TranslationService.trans('media_manager.alert.delete'), 5);
        });
    };

    $scope.uploadNewFile = function () {
        console.log('new');
        console.log($scope.newMediaFile);
    };

    $scope.uploadEditFile = function () {
        console.log('edit');
        console.log($scope.editMediaFile);
    };

    $scope.mediaInit = function (media) {
        media.decachedPath = media.path;
        if (typeof media.dateUpdate == 'undefined' || media.dateUpdate == null) {
            media.dateUpdate = media.dateAdd;
        }
    };

});
