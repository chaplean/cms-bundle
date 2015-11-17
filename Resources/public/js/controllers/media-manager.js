'use strict';

var cms = angular.module('Cms');

cms.controller('MediaManager', function($scope, $uibModalInstance) {
    $scope.quitInsertMedia = function() {
        $uibModalInstance.close();
    };

    $scope.quitWithoutMedia = function() {
        $uibModalInstance.close();
    };
});
