<?php

return [
    "razorpay" => [
        "key" =>
            config("app.env") != "local"
                ? env("RAZOR_KEY")
                : env("RAZOR_KEY_DEV"),
        "secret" =>
            config("app.env") != "local"
                ? env("RAZOR_SECRET")
                : env("RAZOR_SECRET_DEV"),
    ],

    "razorpayApi" => [
        "key" => env("RAZOR_KEY_DEV"),
        "secret" => env("RAZOR_SECRET_DEV"),
    ],
];
