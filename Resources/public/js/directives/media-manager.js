'use strict';

var app = angular.module('Cms');

app.directive('mediaManager', function() {
    return {
        scope: {
            callback: '&callback'
        },
        templateUrl: 'media-manager.html',
        controller: function($scope, $uibModal) {
            $scope.openModal = function() {
                $uibModal.open({
                    animation: true,
                    templateUrl: 'media-manager-modal.html',
                    controller: 'MediaManager',
                    size: 'lg',
                    resolve: $scope.callback
                });
            };
        }
    };
});
