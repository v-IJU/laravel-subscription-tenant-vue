const mix = require("laravel-mix");

mix.js(
    "resources/js/backend/customapp.js",
    "public/js/backend/customapp.js"
).version();

mix.js(
    [
        "resources/js/backend/adminpages/helper.js",
        "resources/js/backend/adminpages/popup-service-create-edit.js",
        "resources/js/backend/adminpages/popup-shipping-create-edit.js",
        "resources/js/backend/adminpages/popup-industries-create-edit.js",
        "resources/js/backend/adminpages/popup-feedback-create-edit.js",
        "resources/js/backend/adminpages/popup-associator-create-edit.js",
        "resources/js/backend/adminpages/popup-aboutusshop-create-edit.js",
        "resources/js/backend/adminpages/product-create-edit.js",
        "resources/js/backend/adminpages/popup-coupon-create-edit.js",
    ],
    "public/js/backend/pages.js"
).version();

mix.js("resources/js/frontend/vue/app.js", "public/js/frontend/vue.js")
    .vue()
    .version();
mix.styles(
    [
        "resources/css/websitevuecss/style.css",
        "resources/css/websitevuecss/theme.css",
    ],
    "public/css/websitevuecss/style.css"
).version();

mix.js("resources/js/backend/adminvue/app.js", "public/js/backend/adminvue.js")
    .vue()
    .version();
