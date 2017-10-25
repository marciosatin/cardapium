(function () {
    $c = window.Cardapium = {};
    $c.MenuItems = {};
    $c.MealsItens = {};
    window.Checkbox = {};
})();

Checkbox.marcarTodos = (function () {
    'use strict';

    return function () {
        this.init = function () {
            checkAll();
        };
        
        const checkAll = function () {
            const c = $('input[name="id[]"]');
            $('.checkAll').on('click', function () {
                c.prop('checked', $(this).prop('checked'));
            });
            c.on('click', function () {
                let prop = true;
                c.each(function () {
                    if (!$(this).prop('checked')) {
                        prop = false;
                    }
                });
                $('.checkAll').prop('checked', prop);
            });
        };
    };
})();