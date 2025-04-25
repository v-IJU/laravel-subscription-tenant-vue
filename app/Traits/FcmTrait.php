<?php

namespace App\Traits;
use GuzzleHttp\Client;
use Google_Client;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\RegistrationTokens;
use App\Notifications\FirebasePushNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Http;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;

trait FcmTrait
{
    public function MultiCast($tokens = [], $notificationdata)
    {
        $client = new Client();

        foreach ($tokens as $token) {
            try {
                $response = $client->post(
                    "https://fcm.googleapis.com/v1/projects/rareflowers-3c204/messages:send",
                    [
                        "headers" => [
                            "Authorization" =>
                                "Bearer " . $this->getAccessToken(),
                            "Content-Type" => "application/json",
                        ],

                        "json" => [
                            "message" => [
                                "notification" => [
                                    "title" => $notificationdata->notifytitle,
                                    "body" => $notificationdata->notifytxt,
                                    "image" => $notificationdata->image
                                        ? asset($notificationdata->image)
                                        : null,
                                ],
                                "token" => $token, // Single token per request
                            ],
                        ],
                    ]
                );

                $responseBody = $response->getBody()->getContents();
                // \Log::channel("notification")->info(
                //     "Success for token: " . $token
                // );
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $response = $e->getResponse();

                $errorResponse = $e->getResponse()
                    ? $e
                        ->getResponse()
                        ->getBody()
                        ->getContents()
                    : "Unknown error";
                // \Log::channel("notification")->error(
                //     "Error with token: " . $token . " - " . $errorResponse
                // );

                // Continue with the next token
                continue;
            }
        }
    }

    public function Indivudual()
    {
        // $message = CloudMessage::withTarget(
        //     "token",
        //     $customersQuery[0]
        // )
        //     ->withNotification(
        //         FcmNotification::create(
        //             "Order Allotment",
        //             "New Order Allotment"
        //         )
        //     )
        //     ->withData([
        //         "route" => "notification",
        //         "type" => "global",
        //     ]);

        // try {
        //     // Send the message
        //     $messaging->send($message);
        //     \Log::channel("notification")->info(
        //         "FCM message sent to token: " . $customersQuery[0]
        //     );
        // } catch (\Kreait\Firebase\Exception\MessagingException $e) {
        //     \Log::channel("notification")->error(
        //         "Error sending FCM message: " . $e->getMessage()
        //     );
        // } catch (\Exception $e) {
        //     \Log::channel("notification")->error(
        //         "Unexpected error: " . $e->getMessage()
        //     );
        // }

        // return "ok";
        // Build the notification message
    }

    public function OldMultiCast()
    {
        //$messaging = app("firebase.messaging");
        // $validationResults = $messaging->validateRegistrationTokens(
        //     $tokens
        // );

        // $message = CloudMessage::new();

        // $fcmOptions = FcmOptions::create()->withAnalyticsLabel(
        //     "my-analytics-label"
        // );

        // $message = $message->withFcmOptions($fcmOptions);
        // $message = $message->withNotification([
        //     "title" => $this->notificationdata->notifytitle,
        //     "body" => $this->notificationdata->notifytxt,
        //     "image" => $this->notificationdata->image
        //         ? asset($this->notificationdata->image)
        //         : null,
        // ]);
        // $message = $message->withData([
        //     "route" => "notification",
        //     "type" => "global",
        // ]);

        // $report = $messaging->sendMulticast($message, $tokens);

        // \Log::channel("notification")->info(
        //     "Successful sends: " . $report->successes()->count()
        // );
        // \Log::channel("notification")->info(
        //     "Failed sends: " . $report->failures()->count()
        // );
    }

    public function FireBaseNotificationTrait($florist_info)
    {
        $NotificationError = null;
        try {
            Notification::sendNow(
                $florist_info,
                new FirebasePushNotification(
                    "Order Allotment",
                    "New Order Allotment",
                    null,
                    [
                        "route" => "notification",
                        "type" => "received_order",
                    ],
                    null
                )
            );
        } catch (CouldNotSendNotification $exception) {
            $fcmErrorResponse = $exception->getMessage();

            \Log::channel("debug")->error("FCM Error: " . $fcmErrorResponse);
            $NotificationError = $fcmErrorResponse;

            if (
                strpos($fcmErrorResponse, "InvalidRegistration") !== false ||
                strpos($fcmErrorResponse, "NotRegistered") !== false
            ) {
                \Log::channel("debug")->info(
                    "Invalid or expired token for florist {$florist_info->id}"
                );
            }
        } catch (\Exception $e) {
            $NotificationError = $e->getMessage();
            \Log::channel("debug")->info($e->getMessage());
        }

        return $NotificationError;
    }

    public function getAccessToken()
    {
        $credentialsPath = base_path(".config/pushnotification.json"); // Path to your service account file

        $client = new Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope("https://www.googleapis.com/auth/firebase.messaging");

        $token = $client->fetchAccessTokenWithAssertion();
        return $token["access_token"];
    }
}
