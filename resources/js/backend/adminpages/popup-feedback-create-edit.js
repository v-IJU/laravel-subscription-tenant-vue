"use strict";

document.addEventListener("DOMContentLoaded", LoadPopupModelData);

function LoadPopupModelData() {
    // onchange registration type
}

listenSubmit("#addFeedbackForm", function (event) {
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
    console.log("renderServiceData Feedback", id);
    renderServiceData(id);
});

function renderServiceData(id) {
    $.ajax({
        url: $("#indexPopupUrl").val() + "/" + id + "/edit",
        type: "GET",
        success: function (result) {
            if (result.success) {
                console.log("renderServiceData", result.data.id);
                $("#edit_feedback_id").val(result.data.id);
                $("#edit_feedback_name").val(result.data.name);
                $("#edit_designation").val(result.data.designation);
                $("#edit_feedback_message").val(result.data.message);
                $("#edit_feedback_image").attr("src", result.data.image);

                $("#edit_feedback_modal").modal("show");
                //ajaxCallCompleted();
            }
        },
        error: function (result) {
            console.log(result);
        },
    });
}

listenSubmit("#editFeedbackForm", function (event) {
    event.preventDefault();
    //screenLock();

      let formSelector = $(this);
      let formData = new FormData(formSelector[0]);
      let id = $("#edit_feedback_id").val();

    console.log("editFeedbackForm ID::", id);
    // check token available

    $.ajax({
        url: window.update_feedback,
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
                $("#edit_feedback_modal").modal("hide");
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
