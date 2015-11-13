'use strict';

var cms = angular.module('Cms');

cms.controller('PageController', function($scope, $uibModal, $http, $log, $ngBootbox, $filter,
                                          Page, PublicationStatus,
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
                function(response) {
                    $scope.pageRoute = response.page;
                    if ($scope.pageRoute.publication.datePublicationBegin) {
                        $scope.pageRoute.publication.datePublicationBegin = new Date($scope.pageRoute.publication.datePublicationBegin);
                    }
                    if ($scope.pageRoute.publication.datePublicationEnd) {
                        $scope.pageRoute.publication.datePublicationEnd = new Date($scope.pageRoute.publication.datePublicationEnd);
                    }
                    $scope.pagePath = $scope.pageRoute.path;
                });
        }

        PublicationStatus.getAll(function (response) {
            /** @namespace response.publicationStatus */
            $scope.publicationStatuses = response.publicationStatus;
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
                function (response) {
                    $scope.pagePath = response.pageRoute.path;
                    $scope.pageRoute.dateUpdate = $filter('date')(response.pageRoute.dateUpdate, 'dd/MM/yyyy');
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
                    function (response) {
                        $scope.pagePath = response.pageRoute.path;
                        $scope.pageRoute.dateAdd = $filter('date')(response.pageRoute.dateAdd, 'dd/MM/yyyy');
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

    $scope.isRequire = function (form, name) {
        return form.$invalid && form[name] && form[name].$touched && form[name].$error.required;
    };

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
        pageRouteTmp.publication.datePublicationBegin = $filter('date')(pageRouteTmp.publication.datePublicationBegin, 'dd/MM/yyyy');
        pageRouteTmp.publication.datePublicationEnd = $filter('date')(pageRouteTmp.publication.datePublicationEnd, 'dd/MM/yyyy');
        pageRouteTmp.publication.status = pageRouteTmp.publication.status.id;

        return pageRouteTmp;
    };

    $scope.loadData();
});
