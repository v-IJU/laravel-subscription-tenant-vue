import axios from "axios";
import hljs from "highlight.js";
import "highlight.js/styles/default.css";
import "highlight.js/styles/github-dark.css";
export default class GeneralConfig {
    static GeneralInit() {
        console.log("General Init New");

        // Initialize select2
        $("#school-dropdown, #class-dropdown").select2();

        // loads classes for preselected school
        //handleSchoolSelection();

        // loads classes for user selected school
        $(document).on("change", "#school-dropdown", handleSchoolSelection);

        // Function for both preselected school and school dropdown change
        function handleSchoolSelection() {
            let selectedSchoolId = $("#school-dropdown").val();
            loadClasses(selectedSchoolId);
        }

        // Function to load classes select2
        function loadClasses(schoolId) {
            if (schoolId) {
                let url = window.filterclasslist;
                axios
                    .post(url, { schoolId: schoolId })
                    .then((response) => {
                        let classes = response.data.classes; // Adjust based on your API response
                        let classDropdown = $("#class-dropdown");

                        // Clear existing options
                        classDropdown.empty();

                        // Add new options
                        // classDropdown.append(
                        //     '<option value="">Select a class</option>'
                        // );
                        classDropdown.select2({
                            allowClear: true,
                            placeholder: "Select Class...",
                            data: response.data.classes,
                        });

                        // Reinitialize select2 for the updated dropdown
                        classDropdown.val("").trigger("change");
                    })
                    .catch((error) => {
                        console.error("Error fetching classes:", error);
                    });
            } else {
                // Clear the class dropdown if no school is selected
                $("#class-dropdown")
                    .empty()
                    .append('<option value="">Select a class</option>')
                    .trigger("change");
            }
        }

        GeneralConfig.ImageUpload();
        document.addEventListener("DOMContentLoaded", (event) => {
            document.querySelectorAll("pre code").forEach((block) => {
                hljs.highlightElement(block);
            });
        });

        $(".removeuploadimage").on("click", function () {
            var input = this;
            var element = input.getAttribute("data-name");
            $(`input[name=${element}]`).val("");

            $(`#${element}holder`).attr("src", "");
            $(`#${element}holder`).hide();
            $(this).hide();
        });

        //event to update order status to shipping
        $(document).on("click", "#shipping_button", function () {
            let url = window.updateShippingStatus;
            let orderIndexURL = window.orderIndex;
            let orderStatus = $("#order_status").val();
            let orderNumber = $("#order_number").val();
            var shippingDetails = CKEDITOR.instances.shipping_details.getData();
            let orderId = document.getElementById("order_id").value;
            var form = $(this).closest("form");

            // Validation check
            if (orderStatus == "") {
                alert("Please Change the status");
                return false;
            } else if (orderStatus == 1 || shipping_details == "") {
                alert("Please enter the details");
                event.preventDefault(); // Stop the form from submitting
                return false;
            } else if (orderStatus == 2 && shippingDetails != "")
                // confirm the action to save details
                Swal.fire({
                    title: `Are you sure you want to change the status for Order #${orderNumber}?`,
                    text: "Please confirm the order number & customer name",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Send it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#loading-overlay").show();

                        // Create a form data object
                        var formData = new FormData();
                        formData.append("shippingDetails", shippingDetails);
                        formData.append("orderId", orderId);
                        formData.append("orderStatus", orderStatus);

                        axios
                            .post(url, formData)
                            .then((response) => {
                                setTimeout(() => {
                                    window.location.href = orderIndexURL;
                                }, 1000);

                                toastr.success(
                                    "Order status Updated and Invoice emailed to customer successfully"
                                );

                                $("#loading-overlay").fadeOut();
                            })
                            .catch((error) => {
                                console.error("Error:", error);
                                $("#loading-overlay").fadeOut();
                            });
                    }
                });
            // end of swal fire response
        });

        //ajax call for clone product registration
        $(document).on("click", "#clone_product_register", function () {
            let url = window.duplicateproduct;
            let inputData = $("#product-clone-form-create").serialize();

            axios
                .post(url, inputData)
                .then((response) => {
                    if (response.data) {
                        console.log("Response data is :", response);
                    }
                })
                .catch((error) => {
                    console.log(
                        "Product register process failed. Error:",
                        error
                    );
                });
        });

        //ajax call for new product registration
        $(document).on("click", "#product_register", function () {
            let url = window.registerproduct;
            var inputData = new FormData();

            // Append multiple images to the FormData object
            let imageFiles = document.getElementById("file").files;
            if (imageFiles.length > 0) {
                Array.from(imageFiles).forEach((file, index) => {
                    inputData.append("pimage[]", file);
                });
            }

            let formData = $("#product-form-create").serialize();
            inputData.append(formData);

            axios
                .post(url, inputData)
                .then((response) => {
                    if (response.data) {
                        console.log("Response data is :", response);
                    }
                })
                .catch((error) => {
                    console.log(
                        "Product register process failed. Error:",
                        error
                    );
                });
        });

        //[1] function to load product categories on gender selection
        $(document).on("change", ".gender_select", function () {
            let url = window.filtercategorylist;
            let genderId = $(this).val();
            var inputData = new FormData();
            inputData.append("genderId", genderId);

            axios
                .post(url, inputData)
                .then((response) => {
                    if (response.data.sizecategories) {
                        let selectElement = $(".size_category");

                        // Clear existing options
                        selectElement.empty().append("<option></option>");

                        // Initialize or reinitialize Select2
                        selectElement.select2({
                            allowClear: true,
                            placeholder: "Select category...",
                            data: response.data.sizecategories,
                        });
                    }
                })

                .catch((error) => {
                    console.error("Error:", error);
                });
        });

        // function to load classes for user selected school
        $(document).on("change", "#school-dropdown", handleSchoolSelection);

        // [2] to load sizes on product category selection
        $(document).on("change", ".size_category", handleSizeSelection);

        // [2] function to load sizes on product category selection
        function handleSizeSelection() {
            let url = window.filtersizelist;
            let sizeCategoryId = $("#size_category").val();
            var inputData = new FormData();
            inputData.append("sizeCategoryId", sizeCategoryId);
            axios
                .post(url, inputData)
                .then((response) => {
                    if (response.data.sizes) {
                        $(".addmore_pvsizes").empty();
                        $(".addmore_pvsizes").append(
                            "<option>Select sizes</option>"
                        );

                        // Format the data for Select2
                        let formattedData = response.data.sizes.map((item) => {
                            return { id: item.id, text: item.size }; // Rename 'size' to 'text'
                        });

                        // Initialize or reinitialize Select2 with formatted data
                        $(".addmore_pvsizes").select2({
                            allowClear: true,
                            placeholder: "Select category...",
                            data: formattedData,
                        });
                    }
                })

                .catch((error) => {
                    console.error("Error:", error);
                });
        }

        //function to load colors for selected product category
        $(document).on("change", "#size_category", handleColorSelection);

        // function to load colors on product category selection
        function handleColorSelection() {
            let url = window.filtercolorlist;
            let sizeCategoryId = $("#size_category").val();
            var inputData = new FormData();
            inputData.append("sizeCategoryId", sizeCategoryId);
            axios
                .post(url, inputData)
                .then((response) => {
                    if (
                        response.data.colors &&
                        response.data.colors.length > 0
                    ) {
                        // Get the color container div
                        let colorContainer =
                            document.getElementById("color-container");

                        // Clear existing content
                        colorContainer.innerHTML =
                            "<strong>Available House colors:</strong> ";

                        // Append color variants
                        response.data.colors.forEach((color) => {
                            let colorSpan = document.createElement("span");
                            colorSpan.textContent = color.color;
                            colorSpan.classList.add(
                                "badge",
                                "bg-primary",
                                "mx-1"
                            ); // Styling with Bootstrap
                            colorContainer.appendChild(colorSpan);
                        });

                        // Show the color container if hidden
                        colorContainer.style.display = "block";
                    } else {
                        document.getElementById(
                            "color-container"
                        ).style.display = "none";
                    }
                })

                .catch((error) => {
                    console.error("Error:", error);
                });
        }

        // for parent registration
        // filters school classes by selecting school
        $(document).on("change", ".school_select", function () {
            let schoolId = $(this).val();
            var inputData = new FormData();
            inputData.append("schoolId", schoolId);

            let data_class_id = $(this).attr("data-class-id");
            let url = window.filterclasslist;

            axios
                .post(url, inputData)
                .then((response) => {
                    if (response.data.classes) {
                        let selectElement = $(
                            "select[id='" + data_class_id + "']"
                        );

                        selectElement.empty();

                        // selectElement.prepend(
                        //     "<option value='' disabled selected>Choose Class...</option>"
                        // );

                        selectElement.select2({
                            allowClear: true,
                            placeholder: "Choose Class...",
                            data: response.data.classes,
                        });
                    }
                })

                .catch((error) => {
                    console.error("Error:", error);
                });
        });

        // validates logo image upload in school registration
        $(document).on("input", ".tex_img", function () {
            let msg_p = $(this).closest("div").find(".error_msg");
            msg_p.text("");
            const maxSizeInMB = 2;
            const maxSizeInBytes = maxSizeInMB * 1024 * 1024;
            const allowedMimes = [
                "image/jpeg",
                "image/png",
                "image/jpg",
                // "application/pdf",
                // "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            ];
            for (let i = 0; i < this.files.length; i++) {
                if (allowedMimes.includes(this.files[i].type)) {
                    if (this.files[i].size > maxSizeInBytes) {
                        // notify_script(
                        //     "Error",
                        //     "File size exceeds the maximum limit of " +
                        //         maxSizeInMB +
                        //         " MB.",
                        //     "error",
                        //     true
                        // );

                        console.log(msg_p);
                        msg_p.text(
                            "File size exceeds the maximum limit of " +
                                maxSizeInMB +
                                " MB."
                        );
                        this.value = "";
                        return;
                    }
                } else {
                    var input = this;
                    var img = $(input).closest(".row").find(".redcol .file");
                    img.attr("src", " ");
                    input.value = "";
                    $(this).prop("disabled", true);
                    setTimeout(() => $(this).prop("disabled", false), 100);
                    msg_p.text(
                        "File accepted: .jpeg, .jpg, .png. Please choose a suitable file format."
                    );
                    return;
                }
            }
        });

        $(document).on("click", ".delete", function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();

            var target = $(this).closest("form");
            console.log(target.attr("href"));

            Swal.fire({
                title: "Are you sure you want to delete this item ??",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    target.submit();
                }
            });
        });

        $(document).on("click", ".deleteTableItem", function () {
            var target = $(this).closest("form");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#34c38f",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Yes, delete it!",
            }).then(function (result) {
                // if (result.value) {
                //     Swal.fire(
                //         "Deleted!",
                //         "Your file has been deleted.",
                //         "success"
                //     );
                // }
                if (result.isConfirmed) {
                    target.submit();
                }
            });
        });

        $(".datetimepicker").datetimepicker();

        $(".date_input").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            orientation: "bottom auto",
            todayHighlight: true,
            toggleActive: true,
            clearBtn: true,
            dateFormat: "dd MM yy",
            onClose: function (dateText, inst) {
                $(this).datepicker(
                    "setDate",
                    new Date(inst.selectedYear, inst.selectedMonth, 1)
                );
            },
        });

        $(".date_input_disabled").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            orientation: "bottom auto",
            todayHighlight: true,
            toggleActive: true,
            clearBtn: true,
            endDate: "today",
            dateFormat: "dd MM yy",
            onClose: function (dateText, inst) {
                $(this).datepicker(
                    "setDate",
                    new Date(inst.selectedYear, inst.selectedMonth, 1)
                );
            },
        });

        $(".timepicker").timepicker({
            icons: {
                up: "mdi mdi-chevron-up",
                down: "mdi mdi-chevron-down",
            },
            minuteStep: 1,

            appendWidgetTo: ".timepicker_container",
        });
    }

    static ImageUpload() {
        $(".imageupload").on("change", function () {
            var input = this;
            var dataid = input.getAttribute("data-name");
            $(`#${dataid}holder`).show();
            GeneralConfig.readIMG(this);
        });
    }
    static readIMG(input) {
        var element = input.getAttribute("data-name");
        console.log(element);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(`#${element}holder`)
                    .attr("src", e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);

            $(`#${element}_remove`).show();
        }
    }

    static DoStatusChange(status = null, id = null, attribute = null) {
        var url = window.statuschange;
        console.log("status is : ".status);
        console.log("attribute is : ".attribute);
        axios
            .post(url, { status: status, id: id, attribute: attribute })
            .then((res) => {
                if (res.data.success == "success") {
                    console.log(res.data.success);

                    toastr.success("Status Changed");
                }
            })
            .catch((err) => {
                console.log(err);
            });
    }
}
