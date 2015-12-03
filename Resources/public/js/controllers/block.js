'use strict';

var cms = angular.module('Cms');

cms.controller('BlockController', function($scope, $uibModal, $http, $log, $ngBootbox, $filter,
                                          Block, PublicationStatus, Validator,
                                          TranslationService, AlertService, Datepicker) {

    $scope.publicationStatuses = [];
    $scope.block = {
        publication: {
            datePublicationBegin: null,
            datePublicationEnd: null
        }
    };
    $scope.datepicker = Datepicker;

    $scope.loadData = function() {
        if ($scope.blockId) {
            Block.get({blockId: $scope.blockId}, function(block) {

                $scope.block = block;
                if ($scope.block.publication.datePublicationBegin) {
                    $scope.block.publication.datePublicationBegin = moment($scope.block.publication.datePublicationBegin, 'YYYY-MM-DD').toDate();
                }
                if ($scope.block.publication.datePublicationEnd) {
                    $scope.block.publication.datePublicationEnd = moment($scope.block.publication.datePublicationEnd, 'YYYY-MM-DD').toDate();
                }
            });
        }

        PublicationStatus.getAll(function (publicationStatus) {
            $scope.publicationStatuses = publicationStatus;
        });
    };

    $scope.saveBlock = function (blockForm, formName, quit) {
        if (blockForm.$valid) {
            var block = $scope.buildData($scope.block);

            if ($scope.blockId) {
                Block.update({blockId: $scope.blockId}, block,
                    function (block) {
                        $scope.block.dateUpdate = $filter('date')(block.dateUpdate, 'dd/MM/yyyy');
                        AlertService.addAlert('success', TranslationService.trans('alert.block.updated'));

                        if (quit) {
                            window.location = Routing.generate('cms_block_list');
                        }
                    }, function (response) {
                        if(response.status == 400) {
                            Validator.addError(blockForm, response.data);
                            AlertService.addAlert('warning', TranslationService.trans('error.important'));
                        } else {
                            AlertService.addAlert('danger', TranslationService.trans('error.important'))
                        }
                    });
            } else {
                Block.save(block, function (block) {
                    $scope.block.dateAdd = $filter('date')(block.dateAdd, 'dd/MM/yyyy');
                    AlertService.addAlert('success', TranslationService.trans('alert.block.created'));

                    if (quit) {
                        window.location = Routing.generate('cms_block_list');
                    }
                }, function (errors) {
                    $log.error(errors);
                    $scope.errors = errors;
                    AlertService.addAlert('danger', TranslationService.trans('error.important'))
                });
            }
        } else {
            console.log(blockForm.$error);
        }
    };

    $scope.cancel = function () {
        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.leave_change')
        ).then(function() {
                window.location = Routing.generate('cms_block_list');
            }, function() {
                return false;
            }
        );
    };

    $scope.isRequire = Validator.isRequire;
    $scope.onError = Validator.onError;
    $scope.isInvalidFieldSumitted = Validator.isInvalidFieldSumitted;
    $scope.getInvalidError = Validator.getInvalidError;

    $scope.buildData = function (block) {
        var blockTmp = angular.copy(block);

        delete blockTmp.id;
        delete blockTmp.dateAdd;
        delete blockTmp.dateUpdate;
        delete blockTmp.publication.id;
        delete blockTmp.publication.dateAdd;
        delete blockTmp.publication.dateUpdate;
        if (typeof blockTmp.publication.datePublicationBegin == 'string') {
            blockTmp.publication.datePublicationBegin = moment(blockTmp.publication.datePublicationBegin, 'DD/MM/YYYY');
        }
        if (typeof blockTmp.publication.datePublicationEnd == 'string') {
            blockTmp.publication.datePublicationEnd = moment(blockTmp.publication.datePublicationEnd, 'DD/MM/YYYY');
        }
        blockTmp.publication.status = blockTmp.publication.status.id;

        return blockTmp;
    };

    $scope.loadData();
});
