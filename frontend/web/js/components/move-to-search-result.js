/**
 * Перемещает пользователя к результату поиска на главной странице, минуя форму поиска
 */
{
    let queryParams = {}
    location.search.substr(1).split("&").forEach(function (item) {
        queryParams[item.split("=")[0]] = item.split("=")[1]
    })

    if (typeof searchTriggered !== "undefined" && searchTriggered) {
        $(window).scrollTop($('.catalog__products').offset().top);
    }
}