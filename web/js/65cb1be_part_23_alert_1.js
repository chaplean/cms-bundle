'use strict';

var cms = angular.module('Cms');

cms.factory('CmsAlertService', function($timeout) {

    var alerts = [];

    return {
        alerts: alerts,

        /**
         * Add an alert message
         * @param type Type of alert (danger, warning, success, info)
         * @param message Message to display
         * @param duration How long the alert is displayed
         * @param link A link to add to the message
         */
        addAlert: function (type, message, duration, link) {
            var alert = {type: type, message: message};
            if (link) {
                alert.link = Routing.generate(link);
            }

            alerts.push(alert);

            if (duration) {
                $timeout(function () {
                    alerts.splice(alerts.lastIndexOf(alert), 1);
                }, duration * 1000);
            }
        },

        closeAlert: function (index) {
            alerts.splice(index, 1);
        }
    };

});
