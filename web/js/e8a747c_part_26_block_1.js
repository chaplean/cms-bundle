'use strict';

var cms = angular.module('Cms');

cms.controller('clCmsBlockController', function($scope, $uibModal, $http, $log, $ngBootbox, $filter,
                                          Block, PublicationStatus, clCmsValidator,
                                          TranslationService, CmsAlertService, clCmsDatepicker,
                                          clCmsMenu) {

    clCmsMenu.setActive('block');
    $scope.publicationStatuses = [];
    $scope.block = {
        publication: {
            datePublicationBegin: null,
            datePublicationEnd: null
        }
    };
    $scope.datepicker = clCmsDatepicker;

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

            clCmsValidator.errors = {};
            if ($scope.blockId) {
                Block.update({blockId: $scope.blockId}, block,
                    function (block) {
                        $scope.block.dateUpdate = $filter('date')(block.dateUpdate, 'dd/MM/yyyy');
                        CmsAlertService.addAlert('success', TranslationService.trans('alert.block.updated'), 1.5);

                        if (quit) {
                            window.location = Routing.generate('cms_block_list');
                        }
                    }, function (response) {
                        if(response.status == 400) {
                            clCmsValidator.addError(blockForm, response.data);
                            //CmsAlertService.addAlert('warning', TranslationService.trans('error.important'), 1.5);
                        } else {
                            CmsAlertService.addAlert('danger', TranslationService.trans('error.important'), 1.5)
                        }
                    });
            } else {
                Block.save(block, function (block) {
                    $scope.blockId = block.id;
                    $scope.block.dateAdd = $filter('date')(block.dateAdd, 'dd/MM/yyyy');
                    CmsAlertService.addAlert('success', TranslationService.trans('alert.block.created'), 1.5);

                    if (quit) {
                        window.location = Routing.generate('cms_block_list');
                    }
                }, function (error) {
                    //$log.error(error);
                    if (error.status == 400) {
                        clCmsValidator.addError(blockForm, error.data);
                        //CmsAlertService.addAlert('warning', TranslationService.trans('error.important'), 1.5);
                    } else {
                        CmsAlertService.addAlert('danger', TranslationService.trans('error.important'), 1.5)
                    }
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

    $scope.isRequire = clCmsValidator.isRequire;
    $scope.onError = clCmsValidator.onError;
    $scope.isInvalidFieldSumitted = clCmsValidator.isInvalidFieldSumitted;
    $scope.getInvalidError = clCmsValidator.getInvalidError;

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
