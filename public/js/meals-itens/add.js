$c.MealsItens.add = (function () {
    'use strict';

    return function () {
        this.init = function () {
            new Checkbox.marcarTodos().init();
        };
    };

})();

new $c.MealsItens.add().init();
