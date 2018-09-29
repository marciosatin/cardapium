$c.MenuGenAdd = (function () {
    'use strict';

    return function () {
        this.init = function () {
            $('button.btn-salvar').on('click', btnSalvarClicked);
            initRefresh();
        };
        const initRefresh = function () {
            $('a.refresh').on('click', initRefreshClicked);
        };
        const initRefreshClicked = function () {
          window.location.reload();  
        };
        const btnSalvarClicked = function () {
            let fd = new FormData(), oData, menu = {itens: []};

            oData = $('div.cell-week-day');
            oData.each(function () {
                menu.itens.push({
                    day: $(this).data('day'),
                    amealid: $(this).data('amealid'),
                    jmealid: $(this).data('jmealid')
                });
            });

            menu.dtIni = $('span.dtIni').data('dtini');
            menu.dtFin = $('span.dtFin').data('dtfin');

            fd.append('menu', JSON.stringify(menu));
            $.ajax({
                method: 'POST',
                url: '/menu-generator/store',
                data: fd,
                processData: false,
                contentType: false
            }).done(function (data) {
                if (data.error) {
                    alert('Ocorreu um erro ao salvar');
                    console.log(data);
                    return;
                }
                window.location.href = '/menus';
            }).fail(function (data) {
                console.log(data);
            });
        };
    };
})();

new $c.MenuGenAdd().init();
