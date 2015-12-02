'use strict';

var cms = angular.module('Cms');

cms.controller('MediaManager', function($scope, $uibModalInstance, filterFilter, Media, AlertService, TranslationService, FileUploader, FileItem) {

    $scope.updateFilter = function() {
        $scope.mediasFiltered = filterFilter($scope.medias, $scope.mediaFilter);
    };

    $scope.medias = Media.getAll().$promise.then(function(data) {
        $scope.medias = data;
        $scope.medias.forEach(function(media) {
            if (typeof media.dateUpdate == 'undefined' || media.dateUpdate == null) {
                media.dateUpdate = media.dateAdd;
            }
        });
        $scope.updateFilter();
    });

    $scope.nameFilter = null;
    $scope.sortType = 'dateUpdate';
    $scope.categoryFilter = null;

    $scope.selectedMedia = null;

    $scope.newMediaFile = null;
    $scope.editMediaFile = null;

    $scope.newUploader = new FileUploader({
        url: 'http://localhost:8000/app_test.php/rest/media',
        autoUpload: true,
        onSuccessItem: function(item, response) {
            var newMedia = response;
            $scope.selectMedia(newMedia);
            $scope.medias.push(newMedia);
            $scope.updateFilter();
        }
    });

    $scope.editUploader = new FileUploader({
        autoUpload: true,
        onSuccessItem: function(item, response) {
            angular.extend($scope.selectedMedia, response);
        },
        onBeforeUploadItem: function(item) {
            item.url = 'http://localhost:8000/app_test.php/rest/media/' + $scope.selectedMedia.id + '/edits';
        }
    });

    $scope.quitInsertMedia = function() {
        $uibModalInstance.close();
    };

    $scope.quitWithoutMedia = function() {
        $uibModalInstance.close();
    };

    $scope.mediaFilter = function(value, index, array) {
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

    $scope.selectMedia = function(media) {
        $scope.selectedMedia = media;
    };

    $scope.insertCurrentMedia = function() {
        $scope.save($scope.selectedMedia, {},
            function() {
                $scope.quitInsertMedia();
            }, function() {
                AlertService.addAlert('danger', TranslationService.trans('media_manager.alert.save'));
            }
        );
    };

    $scope.deleteCurrentMedia = function() {
        Media.delete($scope.selectedMedia, {},
            function () {
                var position = $scope.medias.indexOf($scope.selectedMedia);
                $scope.medias.splice(position, 1);
                $scope.selectedMedia = null;
                $scope.updateFilter();
            }, function() {
                AlertService.addAlert('danger', TranslationService.trans('media_manager.alert.delete'));
            }
        );
    };

    $scope.uploadNewFile = function() {
        console.log('new');
        console.log($scope.newMediaFile);
    };

    $scope.uploadEditFile = function() {
        console.log('edit');
        console.log($scope.editMediaFile);
    };

});
