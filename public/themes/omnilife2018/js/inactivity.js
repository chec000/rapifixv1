const oneMinute     = 60000;
const sessionLimit  = 300;

let inactiveMinutes = 0;

const timerIncrement = () => {
    inactiveMinutes++;
    if (inactiveMinutes >= sessionLimit) { window.location.reload(); }
};

$(document).ready(function () {
    setInterval(timerIncrement, oneMinute);
    $(this).click(() => inactiveMinutes = 0);
});