registerToggler("#show-result", "#result");
registerToggler("#supplier-toggler", "#supplier-message");
registerToggler("#goods-description-toggler", "#goods-description");
registerToggler("#order-result-toggler", "#order-result", (caller, contentId) => {
    $.ajax({
        method: 'POST',
        url: '/backend/web/finance/order/show-result',
        data: {id: caller.data('id')},
        success: function (data) {
            data = data.replace(/<(?!br\s*\/?)[^>]+>/g, '');
            $(contentId).html(data);
        }
    });
});

$("#show-order-url").on("click", function () {
    let $this = $(this);
    $.ajax({
        method: 'POST',
        url: '/backend/web/finance/order/show-url',
        data: {id: $this.data('id')},
        success: function (url) {
            $this.html(url);
            $this.attr({href : url, target : '_blank'})
        }
    });
});

// Functions
function registerToggler(buttonId, contentId, beforeCallback) {
    $(buttonId).on("click", function (e) {
        e.preventDefault();

        if (typeof beforeCallback === 'function') {
            beforeCallback($(this), contentId);
        }

        $(contentId).slideToggle();
    });
}