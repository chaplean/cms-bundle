'use strict';

var cms = angular.module('Cms');

cms.controller('BlocksController', function($scope, $filter, $uibModal, $http, $ngBootbox, Block, TranslationService, CmsAlertService) {

    $scope.$parent.menu.active = 'block';
    $scope.search = '';
    $scope.blocks = [];
    $scope.blocksDisplayed = [];

    $scope.loadData = function() {
        Block.getAll({}, function(blocks) {
                $scope.blocks = blocks;
                $scope.blocksDisplayed = [].concat($scope.blocks);
            }
        );
    };

    $scope.updateFilter = function () {
        $scope.blocksDisplayed = [].concat($scope.blocks);
        $scope.blocksDisplayed = $filter('blockFilter')($scope.blocksDisplayed, $scope.search);
    };

    $scope.removeBlock = function (block) {
        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.delete_block', { 'block' : block.name })
        ).then(function() {
                Block.delete({
                        blockId: block.id
                    },
                    function () {
                        var indexSplice = -1;
                        angular.forEach($scope.blocks, function (value, index) {
                            if (value.id == block.id) {
                                indexSplice = index;
                            }
                        });
                        $scope.blocks.splice(indexSplice, 1);
                        $scope.updateFilter();
                        CmsAlertService.addAlert('success', TranslationService.trans('alert.block.deleted'), 1.5);
                    }, function () {
                        CmsAlertService.addAlert('danger', TranslationService.trans('error.important'), 1.5)
                    }
                );
            }, function() {
                return false;
            }
        );
    };

    $scope.loadData();
});
