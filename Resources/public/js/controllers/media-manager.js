'use strict';

var cms = angular.module('Cms');

cms.controller('MediaManager', function($scope, $uibModalInstance, filterFilter, Media, AlertService, TranslationService, FileUploader) {

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
        url: '/rest/media/news',
        autoUpload: true
    });

    $scope.editUploader = new FileUploader({
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
        $scope.selectedMedia.$save({},
            function() {
                $scope.quitInsertMedia();
            }, function() {
                AlertService.addAlert('danger', TranslationService.trans('media_manager.alert.save'));
            }
        );
    };

    $scope.deleteCurrentMedia = function() {
        $scope.selectedMedia.$delete({},
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
