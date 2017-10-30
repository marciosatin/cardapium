$c.MealsItens.add = (function () {
    'use strict';
    return function () {
        this.init = function () {
            new Checkbox.marcarTodos().init();
            initDelItensClick();
            initDelItensBatch();
        };
        const initDelItensBatch = function () {
            $('.delItens').on('click', function (e) {
                e.preventDefault();
                let ids = [];
                const c = $('input:checkbox:checked');
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
                url: '/meals-itens/del',
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

new $c.MealsItens.add().init();
