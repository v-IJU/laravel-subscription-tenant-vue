"use strict";

document.addEventListener("DOMContentLoaded", LoadPopupModelData);

function LoadPopupModelData() {
    // onchange registration type
}

listenSubmit("#addAssociatorForm", function (event) {
    event.preventDefault();
    //screenLock();
    let formSelector = $(this);
    let formData = new FormData(formSelector[0]);

    //check token available
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
    let id = event.currentTarget.dataset.id;
    renderServiceData(id);
});

function renderServiceData(id) {
    $.ajax({
        url: $("#indexPopupUrl").val() + "/" + id + "/edit",
        type: "GET",
        success: function (result) {
            if (result.success) {
                console.log("renderServiceData", result.data.id);
                $("#edit_associator_id").val(result.data.id);
                $("#edit_associator_image").attr("src", result.data.image);

                $("#edit_associator_modal").modal("show");
                //ajaxCallCompleted();
            }
        },
        error: function (result) {
            console.log(result);
        },
    });
}

listenSubmit("#editAssociatorForm", function (event) {
    event.preventDefault();
    //screenLock();

    let formSelector = $(this);
    let formData = new FormData(formSelector[0]);
    let id = $("#edit_associator_id").val();

    console.log("editAssociatorForm ID::", id);
    // check token available

    $.ajax({
        url: window.update_associator,
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
                $("#edit_associator_modal").modal("hide");
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
