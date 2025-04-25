"use strict";

document.addEventListener("DOMContentLoaded", LoadPopupModelData);

function LoadPopupModelData() {
    // onchange registration type
    console.log("LoadPopupModelData");
}

listenSubmit("#addIndustriesForm", function (event) {
    event.preventDefault();
    //screenLock();
    let formSelector = $(this);
    let formData = new FormData(formSelector[0]);

    // check token available
    $.ajax({
        url: $("#indexPopupCreateUrl").val(),
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (result) {
            if (result.success) {
                displaySuccessMessagetoastr(result.message);
                $(".popup-modal").modal("hide");
                window.table.ajax.reload(null, false);
            }
            //console.log(result);

            //return;
        },
        error: function (result) {
            printErrorMessage(null, result);
        },
    });
});

// edit

listenClick(".popup-edit-btn", function (event) {
    // if ($(".ajaxCallIsRunning").val()) {
    //     return;
    // }
    // ajaxCallInProgress();
    let id = event.currentTarget.dataset.id;
    console.log("renderServiceData", id);
    renderServiceData(id);
});

function renderServiceData(id) {
    $.ajax({
        url: $("#indexPopupUrl").val() + "/" + id + "/edit",
        type: "GET",
        success: function (result) {
            if (result.success) {
                console.log("renderServiceData", result.data.id);
                $("#edit_industry_id").val(result.data.id);
                $("#edit_industry_name").val(result.data.industry_name);
                $("#edit_industry_description").val(result.data.description);
                $("#edit_industry_image").attr("src", result.data.image);

                $("#edit_service_modal").modal("show");
                //ajaxCallCompleted();
            }
        },
        error: function (result) {
            console.log(result);
        },
    });
}

listenSubmit("#editIndustriesForm", function (event) {
    event.preventDefault();
    //screenLock();
    let formSelector = $(this);
    let formData = new FormData(formSelector[0]);

    let id = $("#edit_industry_id").val();
    // console.log("renderIndustryData", id);
    // check token available

    $.ajax({
        url: window.update_industry,
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (result) {
            if (result.success) {
                displaySuccessMessagetoastr(result.message);
                $("#edit_service_modal").modal("hide");
                window.table.ajax.reload(null, false);
            }
            //console.log(result);

            //return;
        },
        error: function (result) {
            printErrorMessage(null, result);
        },
    });
});
