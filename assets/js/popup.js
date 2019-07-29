function confirmDelete(id) {
    $('#confirmBox').simpleConfirm({
        message: "Delete it for sure?",
        success: function () {
            // M: Ajax call
            var getUrl = window.location;
            var rootUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            $.ajax({
                type: 'post',
                url: rootUrl + "/ticket/delete",
                data: {
                    'id': id,
                },
                dataType: 'json',
                success: function (data) {
                    // M: Avoid form resubmission using this workaround in order to reload the page;
                    window.location.href = window.location.href;
                },
                error: function (data) {
                    alert('Internal server error!');
                }
            })
        },
        cancel: function () {
            // M: We don't do anything;
        }
    });
};

function confirmToggle(id, action) {
    $('#confirmBox').simpleConfirm({
        message: action + " this ticket?",
        success: function () {
            // M: Ajax call
            var getUrl = window.location;
            var rootUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            $.ajax({
                type: 'post',
                url: rootUrl + "/ticket/toggle",
                data: {
                    'id': id,
                },
                dataType: 'json',
                success: function (data) {
                    window.location.href = window.location.href;
                },
                error: function (data) {
                    alert('Internal server error!');
                }
            })
        },
        cancel: function () {
            // M: We don't do anything;
        }
    });
};

(function ($) {
    $.fn.simpleConfirm = function (options) {
        if (typeof options === 'undefined')
            options = {};

        var defaultOptions = {
            title: 'Confirm action',
            message: '',
            acceptBtnLabel: 'Yes',
            cancelBtnLabel: 'Nope',
            success: function () {},
            cancel: function () {}
        }
        options = $.extend(defaultOptions, options);

        this.each(function () {
            var $this = $(this);
            var html;

            $this.addClass('simple-dialog active');

            html = '<div class="simple-dialog-content">';
            html += '<div class="simple-dialog-header"><h3 class="title">' + options.title + '</h3></div>';
            html += '<div class="simple-dialog-body"><p class="message">' + options.message + '</p></div>';
            html += '<div class="simple-dialog-footer clearfix"><a class="simple-dialog-button btn-success accept" data-action="close">' + options.acceptBtnLabel + '</a><a class="simple-dialog-button btn-danger cancel" data-action="close">' + options.cancelBtnLabel + '</a></div>';
            html += '</div>';

            $this.html(html);

            $(document).on('click', 'a[data-action="close"]', function (e) {
                e.preventDefault();
                $(this).parents('.simple-dialog').removeClass('active');
                if ($(this).hasClass('accept')) {
                    options.success();
                }
                if ($(this).hasClass('cancel')) {
                    options.cancel();
                }
            });
        });

        return this;
    };
})($);