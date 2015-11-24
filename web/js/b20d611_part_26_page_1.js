'use strict';

var cms = angular.module('Cms');

cms.controller('PageController', function($scope, $uibModal, $http, $log, $ngBootbox, $filter,
                                          Page, PublicationStatus, Validator,
                                          TranslationService, AlertService, Datepicker) {

    $scope.publicationStatuses = [];
    $scope.pageRoute = {
        publication: {
            datePublicationBegin: null,
            datePublicationEnd: null
        }
    };
    $scope.pagePath = '';
    $scope.datepicker = Datepicker;

    $scope.loadData = function() {
        if ($scope.pageId) {
            Page.get({pageId: $scope.pageId},
                function(page) {
                    $scope.pageRoute = page;
                    if ($scope.pageRoute.publication.datePublicationBegin) {
                        $scope.pageRoute.publication.datePublicationBegin = moment($scope.pageRoute.publication.datePublicationBegin, 'YYYY-MM-DD').format('DD/MM/YYYY');
                    }
                    if ($scope.pageRoute.publication.datePublicationEnd) {
                        $scope.pageRoute.publication.datePublicationEnd = moment($scope.pageRoute.publication.datePublicationEnd, 'YYYY-MM-DD').format('DD/MM/YYYY');
                    }
                    $scope.pagePath = $scope.pageRoute.path;
                });
        }

        PublicationStatus.getAll(function (publicationStatus) {
            $scope.publicationStatuses = publicationStatus;
        });
    };

    $scope.savePage = function (pageForm, formName, quit) {
        if (pageForm.$valid) {
            var pageRoute = $scope.buildData($scope.pageRoute);

            if ($scope.pageId) {
                Page.update({
                    pageId: $scope.pageId
                },
                pageRoute,
                function (pageRoute) {
                    $scope.pagePath = pageRoute.path;
                    $scope.pageRoute.dateUpdate = $filter('date')(pageRoute.dateUpdate, 'dd/MM/yyyy');
                    AlertService.addAlert('success', TranslationService.trans('alert.page.updated'));

                    if (quit) {
                        window.location = Routing.generate('cms_page_list');
                    }
                }, function (response) {
                    if(response.data.error) {
                        AlertService.addAlert('warning', response.data.error);
                    } else {
                        AlertService.addAlert('danger', TranslationService.trans('error.important'))
                    }
                });
            } else {
                Page.save(
                    pageRoute,
                    function (pageRoute) {
                        $scope.pagePath = pageRoute.path;
                        $scope.pageRoute.dateAdd = $filter('date')(pageRoute.dateAdd, 'dd/MM/yyyy');
                        AlertService.addAlert('success', TranslationService.trans('alert.page.created'));

                        if (quit) {
                            window.location = Routing.generate('cms_page_list');
                        }
                    }, function (errors) {
                        $log.error(errors);
                        AlertService.addAlert('danger', TranslationService.trans('error.important'))
                    });
            }
        } else {
            console.log(pageForm.$error);
        }
    };

    $scope.cancel = function () {
        $ngBootbox.confirm(
            TranslationService.trans('message.confirm.leave_change')
        ).then(function() {
                window.location = Routing.generate('cms_page_list');
            }, function() {
                return false;
            }
        );
    };

    $scope.isRequire = Validator.isRequire;

    $scope.translateStatus = function (key) {
        return TranslationService.trans('publication_status.status.' + key);
    };

    $scope.buildData = function (pageRoute) {
        var pageRouteTmp = angular.copy(pageRoute);

        delete pageRouteTmp.id;
        delete pageRouteTmp.dateAdd;
        delete pageRouteTmp.dateUpdate;
        delete pageRouteTmp.page.id;
        delete pageRouteTmp.publication.id;
        delete pageRouteTmp.publication.dateAdd;
        delete pageRouteTmp.publication.dateUpdate;
        if (typeof pageRouteTmp.publication.datePublicationBegin == 'string') {
            pageRouteTmp.publication.datePublicationBegin = moment(pageRouteTmp.publication.datePublicationBegin, 'DD/MM/YYYY');
        }
        if (typeof pageRouteTmp.publication.datePublicationEnd == 'string') {
            pageRouteTmp.publication.datePublicationEnd = moment(pageRouteTmp.publication.datePublicationEnd, 'DD/MM/YYYY');
        }
        pageRouteTmp.publication.status = pageRouteTmp.publication.status.id;
        console.log(pageRouteTmp);

        return pageRouteTmp;
    };

    $scope.loadData();
});