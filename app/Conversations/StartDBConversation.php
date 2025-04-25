<?php
namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use cms\core\configurations\Models\BotmanModel;

class StartDBConversation extends Conversation
{
    protected $name;

    public function welcomeMainMenu()
    {
        $this->say("WELCOME TO VIVEK TAILORS");
        $this->loadMainMenuQuestion();
    }

    public function loadMainMenuQuestion()
    {

        $firstMenuOptions = BotmanModel::where("category", "main_menu")->get();
        $buttons          = [];

        foreach ($firstMenuOptions as $option) {
            $firstButtons[] = Button::create($option->name)->value($option->value);
        }
        $mainMenuQuestion = Question::create("PLEASE SELECT A OPTION FROM THE MAIN MENU")->addButtons($firstButtons);
        $this->ask($mainMenuQuestion, function ($answer) {

            $userSelectedOption = $answer->getValue();
            $secondMenuOptions  = BotmanModel::where("category", $userSelectedOption)->get();
            if ($secondMenuOptions->isEmpty()) {
                $this->say("Invalid selection.");
                return;
            }

            $secondButtons = [];
            foreach ($secondMenuOptions as $option) {
                $secondButtons[] = Button::create($option->name)->value($option->value);
            }
            $secondMenuQuestion = Question::create("Please select a sub-option")->addButtons($secondButtons);
            $this->ask($secondMenuQuestion, function ($thirdAnswer) {
                $userSelectedSecondOption = $thirdAnswer->getValue();
                $thirdMenuOptions         = BotmanModel::where("name", $userSelectedSecondOption)->first();

                if (!$thirdMenuOptions) {
                    $this->say("Invalid selection.");
                    return;
                }

                $this->say($thirdMenuOptions->value);

            });

        });

    }

    // Start the conversation by asking for the user's name
    public function run()
    {
        $this->welcomeMainMenu();
    }
}
