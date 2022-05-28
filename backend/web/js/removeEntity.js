let removeButton = $("#remove");
let seconds = 4;
let buttonName = $(removeButton).text();

let timerId = setInterval(function () {
    console.log("tik");
    $(removeButton).text(buttonName + " " + seconds);
    seconds--;
}, 1000);

setTimeout(function () {
    $(removeButton).attr('disabled', false);
    clearInterval(timerId);
    $(removeButton).html(buttonName);
}, 5000);