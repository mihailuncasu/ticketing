function actionConfirm(id) { 
    $('#confirmBox').simpleConfirm({
        message: "Do you proceed?",
        success: function () {
            // Ajax call
            alert('You pressed '+id);
        },
        cancel: function () {
            // Ajax call
        }
    });  
};

(function ($) {
    $.fn.simpleConfirm = function (options) {
        if (typeof options === 'undefined')
            options = {};

        var defaultOptions = {
            title: 'Confirm action?',
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
})(jQuery);