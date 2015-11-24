'use strict';

var cms = angular.module('Cms');

cms.controller('MediaManager', function($scope, $uibModalInstance, filterFilter, Media) {

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
        $scope.quitInsertMedia();
    };

    $scope.editCurrentMedia = function() {
    };

    $scope.deleteCurrentMedia = function() {
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
