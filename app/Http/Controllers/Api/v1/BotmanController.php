<?php
namespace App\Http\Controllers\Api\v1;

use App\Conversations\StartConversation;
use App\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Http\Request;

class BotmanController extends Controller
{
    public function index(Request $request)
    {
        $config = [];
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $botman = BotManFactory::create($config, new LaravelCache());

        // Greet and start the conversation
        $botman->hears("hello|hi", function (BotMan $bot) {
            $bot->startConversation(new StartConversation());
        });

        // Fallback for unknown input
        $botman->fallback(function (BotMan $bot) {
            $bot->reply("Sorry, I didn't understand that. Can you rephrase?");
        });

        // Listen for incoming messages
        $botman->listen();
    }
    private function askNextQuestion(BotMan $bot)
    {
        $question = Question::create("What can I help you with?")->addButtons([
            Button::create("Product Categories")->value("Product Categories"),
            Button::create("Order Status")->value("Order Status"),
            Button::create("Support")->value("Support"),
        ]);

        $bot->reply($question);
    }
    public function index1()
    {
        $config = [];
        // DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $botman = BotManFactory::create($config);

        // Start conversation
        $botman->hears("hello|hi", function (BotMan $bot) {
            $bot->reply("Hi! Please tell me your name.");
            $bot->listen();
        });

        // Capture user's name
        $botman->hears("{name}", function (BotMan $bot, $name) {
            $bot->userStorage()->save(["name" => $name]);
            $bot->reply("Hello $name, nice to meet you!");

            // Display predefined options
            $this->showOptions($bot);
        });

        // Handle predefined options
        $botman->hears("Product Categories", function (BotMan $bot) {
            $bot->reply(
                "We have categories like Electronics, Fashion, and Home Appliances."
            );
        });

        $botman->hears("Order Status", function (BotMan $bot) {
            $bot->reply("Please enter your order number to check the status.");
        });

        $botman->hears("Support", function (BotMan $bot) {
            $bot->reply(
                "You can contact our support team at support@example.com."
            );
        });

        // Fallback
        $botman->fallback(function (BotMan $bot) {
            $bot->reply("Sorry, I didn't understand that. Can you rephrase?");
        });

        $botman->listen();
    }
}
