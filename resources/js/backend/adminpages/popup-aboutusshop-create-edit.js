"use strict";

document.addEventListener("DOMContentLoaded", LoadPopupModelData);

function LoadPopupModelData() {
    // onchange registration type
}

listenSubmit("#addaboutusshopForm", function (event) {
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
                $("#edit_aboutusshop_id").val(result.data.id);
                $("#edit_category").val(result.data.category);
                $("#edit_title").val(result.data.title);
                $("#edit_description").val(result.data.description);
                $("#edit_image").attr("src", result.data.image);

                $("#edit_aboutusshop_modal").modal("show");
                //ajaxCallCompleted();
            }
        },
        error: function (result) {
            console.log(result);
        },
    });
}

listenSubmit("#editaboutusshopForm", function (event) {
    event.preventDefault();
    //screenLock();

    let formSelector = $(this);
    let formData = new FormData(formSelector[0]);
    let id = $("#edit_aboutusshop_id").val();

    console.log("edit_aboutusshop_id ID::", id);
    // check token available

    $.ajax({
        url: window.update_aboutusshop,
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
                $("#edit_aboutusshop_modal").modal("hide");
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
