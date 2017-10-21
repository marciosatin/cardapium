$c.MenuItems.add = (function () {
    'use strict';
    
    return function () {
        this.init = function () {
            console.log('teste');
            checkAll();
        };

        const checkAll = function () {
            $('.checkAll').on('click', function () {

                console.log($(this));

                $('input[type=checkbox]').prop('checked', $(this).prop('checked'));
            });
        };
    };

})();

new $c.MenuItems.add().init();
