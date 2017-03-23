'use strict';

var cms = angular.module('Cms');

cms.factory('CmsAlertService', function(Notification) {

    return {
        /**
         * Add an alert message
         *
         * @deprecated use Notification instead
         *
         * @param type Type of alert (danger, warning, success, info)
         * @param message Message to display
         * @param duration How long the alert is displayed, in seconds
         * @param link A link to add to the message
         */
        addAlert: function (type, message, duration, link) {
			if (typeof duration === 'undefined' || duration === null) {
				duration = 5;
			}

            Notification({message: message, delay: duration * 1000}, type);
        }
    };

});
