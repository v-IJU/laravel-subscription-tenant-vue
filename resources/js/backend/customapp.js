window._ = require("lodash");

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Echo from "laravel-echo";

window.Pusher = require("pusher-js");

const userId = document
    .querySelector('meta[name="user-id"]')
    .getAttribute("content");
// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: process.env.MIX_PUSHER_APP_KEY, // Defined in your .env
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER, // Defined in your .env
//     forceTLS: false, // Set true if using HTTPS
//     wsHost: window.location.hostname, // Use your app's hostname
//     wsPort: 6001, // Default WebSocket port
//     disableStats: true, // Prevents extra statistics reporting
//     debug: true,
// });

// console.log(userId, process.env.MIX_PUSHER_APP_KEY);

// //public channel
// window.Echo.channel("socket-channel-uniform-new-890000").listen(
//     "SocketEvent",
//     (notification) => {
//         const notificationList = document.getElementById("notification-list");
//         if (notificationList) {
//             const listItem = document.createElement("li");
//             listItem.textContent = notification.message;
//             notificationList.appendChild(listItem);
//         }
//     }
// );

// //private channel
// window.Echo.private(`App.Models.User.${userId}`).listen(
//     ".private-notification",
//     (data) => {
//         console.log(data, "private notification");
//     }
// );
import GeneralConfig from "./customApp/GeneralConfig";

window.GeneralConfig = GeneralConfig;
