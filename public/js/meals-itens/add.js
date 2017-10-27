$c.MealsItens.add = (function () {
    'use strict';
    return function () {
        this.init = function () {
            new Checkbox.marcarTodos().init();
            initDelItens();
        };
        const initDelItens = function () {
            $('.delItem').on('click', function (e) {
                e.preventDefault();

                const id = $(this).data('id');
                const callback = function () {
                    let fd = new FormData();
                    fd.append('id', id);
                    $.ajax({
                        method: "POST",
                        url: "/meals-itens/del",
                        data: fd,
                        processData: false,
                        contentType: false
                    }).done(function (data) {
                        console.log(data);
                        window.location.reload();
                    });
                };
                const options = {
                    heading: "Confirmação",
                    question: "Deseja realmente remover?",
                    cancelButtonTxt: "Cancelar",
                    okButtonTxt: "Deletar",
                    callback: callback
                };

                confirm(options);
            });

        };
        const confirm = function (options) {
            const confirmModal =
                    $('<div class="modal fade" tabindex="-1" role="dialog">' +
                            '<div class="modal-dialog" role="document">' +
                            '<div class="modal-content">' +
                            '<div class="modal-header">' +
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                            '<h4 class="modal-title">' + options.heading + '</h4>' +
                            '</div>' +
                            '<div class="modal-body">' +
                            '<p>' + options.question + '&hellip;</p>' +
                            '</div>' +
                            '<div class="modal-footer">' +
                            '<button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">' + options.cancelButtonTxt + '</button>' +
                            '<button type="button" class="btn btn-primary btn-ok">' + options.okButtonTxt + '</button>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>');

            confirmModal.find('.btn-ok').click(function (event) {
                options.callback();
                confirmModal.modal('hide');
            });

            confirmModal.modal('show');
        };

    };

})();

new $c.MealsItens.add().init();
