"use strict";

document.addEventListener("DOMContentLoaded", LoadPopupModelData);

function LoadPopupModelData() {
    // onchange registration type
    console.log("LoadPopupModelData");
}

listenSubmit("#addServiceForm", function (event) {
    event.preventDefault();
    //screenLock();
    let formData = $(this).serialize();

    // check token available
    $.ajax({
        url: $("#indexPopupCreateUrl").val(),
        type: "POST",
        dataType: "json",
        data: formData,
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
    console.log("renderServiceData");
});

function renderServiceData(id) {
    console.log("renderServiceData");
    $.ajax({
        url: $("#indexPopupUrl").val() + "/" + id + "/edit",
        type: "GET",
        success: function (result) {
            if (result.success) {
                console.log("else");
                $("#edit_service_id").val(result.data.id);
                $("#edit_service_name").val(result.data.service_name);
                $("#edit_service_description").val(result.data.description);

                $("#edit_service_modal").modal("show");
                //ajaxCallCompleted();
            }
        },
        error: function (result) {
            console.log(result);
        },
    });
}

listenSubmit("#editServiceForm", function (event) {
    event.preventDefault();
    //screenLock();
    let formData = $(this).serialize();
    let id = $("#edit_service_id").val();
    // check token available
    $.ajax({
        url: $("#indexPopupUrl").val() + "/" + id,
        type: "patch",
        dataType: "json",
        data: formData,
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
