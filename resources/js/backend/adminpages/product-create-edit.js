"use strict";

document.addEventListener("DOMContentLoaded", LoadProductCreateEdit);

function LoadProductCreateEdit() {
    // onchange registration type
    //product varients inclusiverate calculation
    console.log("product vairnet");
}

listenKeyup(".varient_rate", function () {
    let varientprice = parseFloat($(this).val());
    //console.log(varientprice);
    //actual product gst

    let gst =
        $("#product_gst").length && $("#product_gst").val() > 0
            ? Number($("#product_gst").val())
            : 0;

    let inclusiveRateInput = $(this)
        .closest(".mb-3")
        .next(".mb-3")
        .find(".inclusive_rate");

    let amount = (varientprice + varientprice * (gst / 100)).toFixed(2);

    //calculate inclusive rate
    inclusiveRateInput.val(amount);
});
