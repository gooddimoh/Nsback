/**
 * Используется для подсчёта числа выбранных фильтров поиска в Каталоге
 */

updateCounter();

$("input, select").on("change", function () {
    updateCounter();
});

$(".filter__btn-remove").on("click", function () {
    setTimeout(function (){
        updateCounter();
    }, 1000);
})


function updateCounter()
{
    let counter = 0;

    counter += $('form#search-form input[type="checkbox"]:checked').length;
    counter += $('form#search-form input[name="name"]').filter(function () {
        return this.value.trim() != '';
    }).length;
    counter += $('form#search-form option:selected').filter(function () {
        return this.value.trim() != '';
    }).length;

    $("#filter-counter").html(counter);
}