'use strict';

var app = angular.module('Cms');

app.factory('clCmsMenu', function() {
    var clCmsMenu = {
        current: null,
        setActive: function (menu) {
            clCmsMenu.current = menu;
        },
        isActive: function (menu) {
            return clCmsMenu.current == menu;
        }
    };

    return clCmsMenu;
});
