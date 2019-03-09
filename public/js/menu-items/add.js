$c.MenuItemsAdd = (function () {
    'use strict';

    return function () {
        this.init = function () {
            new Checkbox.marcarTodos().init();
            initDelItensClick();
            initDelItensBatch();
            new $c.MenuItemsBlockAdd().init();
        };
        const initDelItensBatch = function () {
            $('.delItens').on('click', function (e) {
                e.preventDefault();
                let ids = [];
                const c = $('tbody input:checkbox:checked');
                c.each(function () {
                    ids.push($(this).val());
                });

                if (ids.length > 0) {
                    const callback = function () {
                        delItens(ids);
                    };

                    showDialog(callback);
                }
            });
        };
        const initDelItensClick = function () {
            $('.delItem').on('click', function (e) {
                e.preventDefault();

                const ids = $(this).data('id');
                const callback = function () {
                    delItens(ids);
                };

                showDialog(callback);
            });

        };
        const showDialog = function (callback) {
            new Dialog().init({
                heading: "Confirmação",
                description: "Deseja realmente remover?",
                cancelButtonTxt: "Cancelar",
                okButtonTxt: "Deletar",
                callback: callback
            });
        };
        const delItens = function (ids) {
            let fd = new FormData();
            fd.append('id', ids);
            $.ajax({
                method: 'POST',
                url: '/menu-items/del',
                data: fd,
                processData: false,
                contentType: false
            }).done(function (data) {
                console.log(data);
                window.location.reload();
            });
        };
    };

})();

$c.MenuItemsBlockModalAdd = (function () {
    'use strict';

    return function () {
        let menuId = null;
        let dtWeek = null;
        let mealSplitId = null;
        this.init = function () {
            initModal();
        };
        this.setData = function (data) {
            menuId = data.menuId;
            dtWeek = data.dtWeek;
            mealSplitId = data.mealSplitId;
        };
        const initModal = function () {
            $('#menuItemAddModal').modal('show');
            $('button.btnMenuItemAdd').off().on('click', function (e) {
                const mealId = $('#mealId').val();
                sendData(mealId);
            });
        };
        const sendData = function (mealId) {
            let fd = new FormData();

            fd.append('meal_id', mealId);
            fd.append('menu_id', menuId);
            fd.append('dt_week', dtWeek);
            fd.append('meal_split_id', mealSplitId);
            $.ajax({
                method: 'POST',
                url: '/menu-items/store',
                data: fd,
                processData: false,
                contentType: false
            }).done(function (data) {
                $('#menuItemAddModal').modal('hide');
                if (data.response) {
                    if (data.response == 'ok') {
                        window.location.reload();
                    }
                }
                console.log(data);
            });
        };
    };
})();

$c.MenuItemsBlockAdd = (function () {
    'use strict';

    return function () {
        this.init = function () {
            console.log('Block says: Hello!!');
            $('a.minus').on('click', initDelItemBlockClick);
            $('a.item-minus').on('click', initDelItemClick);
            $('a.item-pluss').on('click', initAddItemClick);
        };
        const initAddItemClick = function (e) {
            e.preventDefault();

            const menuId = $(this).data('menuid');
            const dtWeek = $(this).data('dtweek');
            const mealSplitId = $(this).data('mealsplitid');

            const modal = new $c.MenuItemsBlockModalAdd();
            modal.init();
            modal.setData({
                menuId: menuId,
                dtWeek: dtWeek,
                mealSplitId: mealSplitId
            });

        };
        const initDelItemClick = function (e) {
            e.preventDefault();

            const id = $(this).data('id');
            const callback = function () {
                delItem(id, null);
            };

            showDialog(callback);

        };
        const initDelItemBlockClick = function (e) {
            e.preventDefault();

            const id = $(this).data('id');
            const dt_week = $(this).data('dt_week');
            const callback = function () {
                delItem(id, dt_week);
            };

            showDialog(callback);

        };
        const showDialog = function (callback) {
            new Dialog().init({
                heading: "Confirmação",
                description: "Deseja realmente remover?",
                cancelButtonTxt: "Cancelar",
                okButtonTxt: "Deletar",
                callback: callback
            });
        };
        const delItem = function (id, dt_week) {
            let fd = new FormData();
            fd.append('id', id);
            if (dt_week) {
                fd.append('dt_week', dt_week);
            }
            $.ajax({
                method: 'POST',
                url: '/menu-items/del',
                data: fd,
                processData: false,
                contentType: false
            }).done(function (data) {
                if (data.response == 'ok') {
                    window.location.reload();
                }
                console.log(data);
            });
        };
    };
})();

new $c.MenuItemsAdd().init();
