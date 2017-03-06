'use strict';

var cms = angular.module('Cms');

cms.controller('clCmsPageController', function($scope, $uibModal, $http, $log, $ngBootbox, $filter,
                                          Page, PublicationStatus, clCmsValidator, BackofficeEditFactory,
                                          TranslationService, CmsAlertService, clCmsDatepicker, clCmsMenu) {

    clCmsMenu.setActive('page');
    $scope.publicationStatuses = [];
    $scope.pageRoute = {
        publication: {
            datePublicationBegin: null,
            datePublicationEnd: null
        }
    };
    $scope.pagePath = '';
    $scope.datepicker = clCmsDatepicker;

    $scope.loadData = function() {
        BackofficeEditFactory.ready(function () {
            $scope.publicationStatuses = BackofficeEditFactory.publicationStatuses;

            if ($scope.pageId) {
                Page.get({pageId: $scope.pageId},
                    function(page) {
                        $scope.pageRoute = page;
                        if ($scope.pageRoute.publication.datePublicationBegin) {
                            $scope.pageRoute.publication.datePublicationBegin = moment($scope.pageRoute.publication.datePublicationBegin, 'YYYY-MM-DD').toDate();
                        }
                        if ($scope.pageRoute.publication.datePublicationEnd) {
                            $scope.pageRoute.publication.datePublicationEnd = moment($scope.pageRoute.publication.datePublicationEnd, 'YYYY-MM-DD').toDate();
                        }
                        $scope.pagePath = $scope.pageRoute.path;
                    });
            } else {
                $scope.pageRoute.publication.status = $scope.publicationStatuses[0];
            }
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
                    CmsAlertService.addAlert('success', TranslationService.trans('alert.page.updated'), 1.5);

                    if (quit) {
                        window.location = Routing.generate('cms_page_list');
                    }
                }, function (response) {
                    if(response.data.error) {
                        CmsAlertService.addAlert('warning', response.data.error, 1.5);
                    } else {
                        CmsAlertService.addAlert('danger', TranslationService.trans('error.important'), 1.5)
                    }
                });
            } else {
                Page.save(
                    pageRoute,
                    function (pageRoute) {
                        $scope.pageRoute = pageRoute;
                        $scope.pageId = pageRoute.id;
                        $scope.pagePath = pageRoute.path;
                        $scope.pageRoute.dateAdd = $filter('date')(pageRoute.dateAdd, 'dd/MM/yyyy');
                        CmsAlertService.addAlert('success', TranslationService.trans('alert.page.created'), 1.5);

                        if (quit) {
                            window.location = Routing.generate('cms_page_list');
                        }
                    }, function (errors) {
                        $log.error(errors);
                        CmsAlertService.addAlert('danger', TranslationService.trans('error.important'), 1.5)
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

    $scope.isRequire = clCmsValidator.isRequire;

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

    $scope.onDismissMediaManager = function() {

    };

    $scope.loadData();
});
