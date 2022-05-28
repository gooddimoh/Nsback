const displayFieldBill = (isBalanceRefund) => {
    console.log(isBalanceRefund);

    if (isBalanceRefund === undefined) {
        return;
    }

    let bill = $("#field-bill");

    !Boolean(Number(isBalanceRefund)) ? bill.show() : bill.hide()
}

displayFieldBill($("#refund-to-balance input[type=radio]:checked").val());

$("#refund-to-balance input[type=radio]").on("change", function () {
    displayFieldBill($(this).val());
});

$("#order-quantity").on("click", function (e) {
    e.preventDefault();
    $("#quantity").val($(this).text());
});