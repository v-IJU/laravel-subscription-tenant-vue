"use strict";

window.isEmpty = (value) => {
    return value === undefined || value === null || value === "";
};

window.randomCode = (length = 6) => {
    return Math.random().toString(36).slice(-length);
};

window.listen = function (event, selector, callback) {
    $(document).on(event, selector, callback);
};
window.listenClick = function (selector, callback) {
    $(document).on("click", selector, callback);
};
window.listenSubmit = function (selector, callback) {
    $(document).on("submit", selector, callback);
};
window.listenHiddenBsModal = function (selector, callback) {
    $(document).on("hidden.bs.modal", selector, callback);
};
window.listenChange = function (selector, callback) {
    $(document).on("change", selector, callback);
};
window.listenKeyup = function (selector, callback) {
    $(document).on("keyup", selector, callback);
};
window.listenShownBsModal = function (selector, callback) {
    $(document).on("shown.bs.modal", selector, callback);
};

window.displaySuccessMessagetoastr = function (message) {
    toastr.success(message);
};

window.displayErrorMessagetoastr = function (message) {
    toastr.error(message);
};

window.printErrorMessage = function (selector, errorResult) {
    // $(selector).show().html("");
    // $(selector).text(errorResult.responseJSON.message);
    displayErrorMessagetoastr(errorResult.responseJSON.message);
};

$(".datetimepicker").datetimepicker({
    format: "DD-MM-YYYY hh:mm A",
    icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down",
        previous: "fa fa-chevron-left",
        next: "fa fa-chevron-right",
        today: "fa fa-calendar-check",
        clear: "fa fa-trash",
        close: "fa fa-times",
    },
});
