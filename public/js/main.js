(function () {
    $c = window.Cardapium = {};
    window.Checkbox = {};
    window.Dialog = {};
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

Dialog = (function () {
    'use strict';

    return function () {
        let opt = {};
        this.init = function (options) {
            opt = options;
            dialogModal();
        };

        const dialogModal = function () {
            let okButtonTxt = '';
            if (opt.okButtonTxt) {
                okButtonTxt = '<button type="button" class="btn btn-primary notika-btn-primary btn-ok">' + opt.okButtonTxt + '</button>';
            }
            const confirmModal =
                    $('<div class="modal fade" tabindex="-1" role="dialog">' +
                            '<div class="modal-dialog" role="document">' +
                            '<div class="modal-content">' +
                            '<div class="modal-header">' +
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                            '<h4 class="modal-title">' + opt.heading + '</h4>' +
                            '</div>' +
                            '<div class="modal-body">' +
                            '<p>' + opt.description + '</p>' +
                            '</div>' +
                            '<div class="modal-footer">' +
                            '<button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">' + opt.cancelButtonTxt + '</button>' +
                            okButtonTxt +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>');

            confirmModal.find('.btn-ok').click(function () {
                opt.callback();
                confirmModal.modal('hide');
            });

            confirmModal.modal('show');
        };

    };
})();