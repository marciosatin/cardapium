$c.MenuItems.add = (function () {
    'use strict';

    return function () {
        this.init = function () {
            new Checkbox.marcarTodos().init();
        };
    };

})();

new $c.MenuItems.add().init();
