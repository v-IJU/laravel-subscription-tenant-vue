"use strict";

document.addEventListener("DOMContentLoaded", LoadPopupModelData);

function LoadPopupModelData() {
    // onchange registration type
    console.log("LoadPopupModelData");
}

listenSubmit("#addCouponForm", function (event) {
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
                $("#add_coupon_modal").modal("hide");
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
    console.log("ID to edit for coupon is :", id);
    $.ajax({
        url: $("#indexPopupUrl").val() + "/" + id + "/edit",
        type: "GET",        
        success: function (result) {
            console.log("success result: ", result);
            if (result.success) {                              
                $("#edit_coupon_id").val(result.data.id);
                $("#coupon_amount").val(result.data.coupon_amount);
                $("#coupon_type").val(result.data.coupon_type);
                $("#coupon_start_date").val(result.data.coupon_start_date);                 
                $("#coupon_end_date").val(result.data.coupon_end_date);                
                $("#edit_coupon_modal").modal("show");
                //ajaxCallCompleted();
            }
            else{
                console.log("COUPON ERROR");
            }
        },
        error: function (result) {
            console.log('Coupon data edit errror:',result);
        },
    });
}

listenSubmit("#editCouponForm", function (event) {
    event.preventDefault();
    //screenLock();
    let formData = $(this).serialize();
    let id = $("#edit_coupon_id").val();
    // check token available
    $.ajax({
        url: $("#indexPopupUrl").val() + "/" + id,
        type: "patch",
        dataType: "json",
        data: formData,
        success: function (result) {
            if (result.success) {
                displaySuccessMessagetoastr(result.message);
                $("#edit_coupon_modal").modal("hide");
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
