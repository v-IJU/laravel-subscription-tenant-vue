<?php
namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class StartConversation extends Conversation
{
    protected $name;

    // Step 1: Ask for the user's name
    public function askName()
    {
        $this->ask("Hi! What is your name?", function ($answer) {
            $this->name = $answer->getText();
            $this->say("Hello " . $this->name . ", nice to meet you!");

            // Step 2: Ask the next question
            $this->askNextQuestion();
        });
    }

    public function welcomeMainMenu()
    {
        $this->say("WELCOME TO VIVEK TAILORS");
        $this->getMainMenuQuestion();
    }

    // Step 2: Ask the next question after display welcome menu
    public function getMainMenuQuestion()
    {
        $mainMenuQuestion = Question::create("PLEASE SELECT A OPTION FROM THE MENU BELOW")->addButtons([
            Button::create("STORE LOCATOR")->value("STORE LOCATOR"),
            Button::create("EXCHANGES")->value("EXCHANGES"),
            Button::create("RE-ORDERS")->value("RE-ORDERS"),
            Button::create("LOCATE MY SHIPMENT")->value("LOCATE MY SHIPMENT"),
            Button::create("FAQs")->value("FAQs"),
        ]);

        $this->ask($mainMenuQuestion, function ($answer) {
            // Handle the answer and provide an appropriate response
            switch ($answer->getValue()) {
                case "STORE LOCATOR":
                    $this->getlocationQuestion();
                    break;
                case "EXCHANGES":
                    $this->getExchangeQuestion();
                    break;
                case "RE-ORDERS":
                    $this->getOrderQuestion();
                    break;
                case "LOCATE MY SHIPMENT":
                    $this->getShipmentQuestion();
                    break;
                case "FAQs":
                    $this->getFAQQuestion();
                    break;
                default:
                    $this->say(
                        "Sorry, I didn't understand that. Can you try again?"
                    );
                    break;
            }
        });
    }

    public function getlocationQuestion()
    {
        $locationMenuQuestion = Question::create("PLEASE SELECT THE LOCATION")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create("RAJAJINAGAR")->value("RAJAJINAGAR"),
                Button::create("INDIRANAGAR")->value("INDIRANAGAR"),
                Button::create("WHITEFIELD")->value("WHITEFIELD"),
                Button::create("HOSUR ROAD")->value("HOSUR ROAD"),
                Button::create("go back")->value("go back"),
            ]);

        $this->ask($locationMenuQuestion, function ($answer) {
            switch ($answer->getValue()) {
                case "RAJAJINAGAR":
                    $question = Question::create("VIVEK TAILORS, RAJAJINAGAR")
                        ->addButtons([
                            Button::create("Location")->value("https://www.google.com/maps?q=VIVEK+TAILORS+RAJAJINAGAR"),
                            Button::create("Call")->value("08023302129"),
                        ]);

                    $this->say($question);
                    break;
                case "INDIRANAGAR":
                    $question = Question::create("VIVEK TAILORS, INDIRANAGAR")
                        ->addButtons([
                            Button::create("Location")->value("https://www.google.com/maps?q=VIVEK+TAILORS+INDIRANAGAR"),
                            Button::create("Call")->value("08023302129"),
                        ]);

                    $this->say($question);
                    break;
                case "WHITEFIELD":
                    $question = Question::create("VIVEK TAILORS, WHITEFIELD")
                        ->addButtons([
                            Button::create("Location")->value("https://www.google.com/maps?q=VIVEK+TAILORS+WHITEFIELD"),
                            Button::create("Call")->value("080-40980683"),
                        ]);

                case "HOSUR ROAD":
                    $question = Question::create("VIVEK TAILORS, HOSUR ROAD")
                        ->addButtons([
                            Button::create("Location")->value("https://www.google.com/maps?q=VIVEK+TAILORS+HOSUR ROAD"),
                            Button::create("Call")->value("080-40980683"),
                        ]);

                case "go back":
                    $this->getMainMenuQuestion();
                    break;
                default:
                    $this->say("Invalid Selection");
                    break;
            }
        });

    }

    public function getExchangeQuestion()
    {
        $exchangeMenuQuestion = Question::create("Exchange Type")->addButtons([
            Button::create("ORDERED ONLINE")->value("ORDERED ONLINE"),
            Button::create("ORDERED AT SCHOOL CAMPUS")->value("ORDERED AT SCHOOL CAMPUS"),
            Button::create("BOUGHT AT A STORE")->value("BOUGHT AT A STORE"),
            Button::create("go back")->value("go back"),
        ]);

        $this->ask($exchangeMenuQuestion, function ($answer) {
            switch ($answer->getValue()) {

                case "ORDERED ONLINE":
                    $this->say("1. PLEASE CALL XXXXXX TO REQUEST AN EXCHANGE.
                                2. PLEASE NOTE THAT EXCHANGE IS POSSIBLE WITHIN 7 DAYS OF PURCHASE.
                                3. HOWEVER, NO EXCHANGE OF WHITE UNIFORMS.
                                4. ITEMS WILL BE EXCHANGED ONLY IF BROUGHT BACK IN UNUSED, UNWASHED AND ORIGINAL CONDITION.
                                5. EXCHANGE POSSIBLE FOR SAME TYPE OF PRODUCT ONLY. CROSS EXCHANGE WILL NOT BE ENTERTAINED.");
                    break;

                case "ORDERED AT SCHOOL CAMPUS":
                    $this->say("1. PLEASE CALL PH.NO. XXXXX TO REQUEST AN EXCHANGE
                                2. PLEASE KEEP YOUR ORDER NUMBER HANDY TO FACILITATE A QUICK RESPONSE.");
                    break;

                case "BOUGHT AT A STORE":
                    $this->say("   1. PLEASE VISIT OR INITIATE AN EXCHANGE BY YOUR REPRESENTATIVE LIKE SWIGGY/DUNZO ETC.
                                    2. PLEASE NOTE THAT EXCHANGE NOT POSSIBLE IF YOU BOUGHT AFTER TRYING THE UNIFORMS.
                                    3. ALSO WHITE UNIFORMS NO EXCHANGE.
                                    4. EXCHANGES ENTERTAINED IF ACCOMPANIED WITH BILL AND WITHIN 7DAYS OF PURCHASE.
                                    5. EXCHANGE WILL BE DONE ONLY FOR THE SAME ITEM THAT IS BROUGHT IN, FOR DEFECTS, SIZE ISSUES ETC. IT WILL NOT BE EXCHANGED FOR A DIFFERENT PRODUCT.");
                    break;
                case "go back":
                    $this->getMainMenuQuestion();
                    break;
            }
        });

    }

    public function getOrderQuestion()
    {
        $orderMenuQuestion = Question::create("Re-Orders")->addButtons([
            Button::create("ONLINE PURCHASE")->value("ONLINE PURCHASE"),
            Button::create("SCHOOL CAMPUS PURCHASE")->value("SCHOOL CAMPUS PURCHASE"),
            Button::create("BOUGHT AT A STORE")->value("BOUGHT AT A STORE"),
            Button::create("go back")->value("go back"),
        ]);

        $this->ask($orderMenuQuestion, function ($answer) {
            switch ($answer->getValue()) {
                case "ONLINE PURCHASE":
                    $this->say("1. PLEASE VISIT THE WEBSITE AND LOGIN TO YOUR ACCOUNT TO VIEW YOUR ORDER LOGS. YOU CAN ORDER YOUR REORDERS FROM THERE EFFORTLESSLY.
                                2. HOWEVER, IF YOU WOULD LIKE TO BUY YOUR  REORDERS AT ANY OF OUR STORES YOU CAN EITHER VISIT PERSONALLY OR SEND A REPRESENTATIVE  OR INITIATE A SWIGGY/DUNZO PICKUP BY MENTIONING THE SIZE AND QUANTITY OF THE REQUIRED PRODUCT FROM YOUR ONLINE ORDER LOG. WE MAY NOT HAVE THE RECORDS OF YOUR ORDERS AT THE OUTLETS SO WE WILL NOT BE ABLE TO ASSIST YOU IN THAT. ");
                    break;
                case "ORDERED AT SCHOOL CAMPUS":
                    $this->say("1. PLEASE CALL XXXXX TO GET ASSISTANCE.
                                2. DO MENTION YOUR SCHOOL NAME, ORDER NUMBER AND OTHER DETAILS TO EXPEDIATE THE PROCESS.
                                3. HOWEVER, IF YOU WOULD LIKE TO BUY YOUR  REORDERS AT ANY OF OUR STORES YOU CAN EITHER VISIT PERSONALLY OR SEND A REPRESENTATIVE  OR INITIATE A SWIGGY/DUNZO PICKUP BY MENTIONING THE SIZE AND QUANTITY OF THE REQUIRED PRODUCT FROM YOUR SCHOOL  ORDER. WE MAY NOT HAVE THE RECORDS OF YOUR ORDERS AT THE OUTLETS SO WE WILL NOT BE ABLE TO ASSIST YOU IN THAT. ");
                    break;
                case "BOUGHT AT A STORE":
                    $this->say("1. IF YOU WOULD LIKE TO BUY  REORDERS BOUGHT AT ANY OF OUR STORES, YOU ARE MOST WELCOME TO EITHER VISIT PERSONALLY OR SEND A REPRESENTATIVE  OR INITIATE A SWIGGY/DUNZO PICKUP BY MENTIONING THE SIZE AND QUANTITY OF THE REQUIRED PRODUCT BY REFERRING TO THE SIZES MENTIONED ON THE PRODUCTS BOUGHT EARLIER THROUGH THIS REPRESENTATIVE.");
                    break;
                case "go back":
                    $this->getMainMenuQuestion();
                    break;
            }
        });

    }

    public function getShipmentQuestion()
    {
        $shipmentMenuQuestion = Question::create("Exchange Type")->addButtons([
            Button::create("LOCATE MY SHIPMENT")->value("LOCATE MY SHIPMENT"),
        ]);

        $this->ask($shipmentMenuQuestion, function ($answer) {
            switch ($answer->getValue()) {
                case "LOCATE MY SHIPMENT":
                    $this->say("WE THANK YOU FOR YOUR ORDER.
                                1. GENERALLY UNIFORMS WILL REACH YOU IN 5 DAYS TIME AFTER WE HAVE DESPACTHED THEM. WE WOULD ALSO BE SENDING YOU THE AIRWAY BILL NUMBER (DOCKET NO.)  OF YOUR PACKAGE THROUGH YOUR REGISTERED EMAIL ID. PLEASE CHECK FOR THIS IN YOUR MAILBOX/SPAM FOLDER ONCE.
                                2. HOWEVER, IF DUE TO HEAVY TRAFFIC DURNG THE PEAK SEASON THIS INFORMATION MIGHT GET DELAYED.
                                3. SO WE REQUEST YOU TO PLEASE SEND A MESSAGE TO XXXXX MENTIONING YOUR ORDER NUMBER AND WE WILL REVERT BACK WITH THE STATUS AT THE EARLIEST. YOU CAN ALSO SEND AN EMAIL TO VIVGRP@GMAIL.COM MENTIONING THESE DETAILS.");
                    break;
            }
        });

    }

    public function getFAQQuestion()
    {
        $FAQMenuQuestion = Question::create("Frequently Asked Questions (FAQs)")->addButtons([
            Button::create("HOW DO I MEASURE MY CHILD TO ORDER ONLINE?")->value("MEASURE"),
            Button::create("HOW MANY DAYS WILL IT TAKE TO DELIVER THE UNIFORMS IF I ORDER ONLINE??")->value("DELIVER"),
            Button::create("CAN I EXCHANGE MY UNIFORMS?")->value("EXCHANGE"),
            Button::create("HOW WILL I KNOW IF MY UNIFORM REQUIREMENTS ARE IN STOCK??")->value("STOCK"),
            Button::create("HOW DO I KNOW WHAT IS THE BEST TIME TO COME TO THE STORE TO BUY THE UNIFORMS?")->value("BUY"),
            Button::create("MY QUERY IS NOT LISTED HERE?")->value("QUERY"),

        ]);

        $this->ask($shipmentMenuQuestion, function ($answer) {
            switch ($answer->getValue()) {
                case "MEASURE":
                    $this->say("YOU CAN LOGIN TO OUR WEBSITE WWW.SHOPFORUNIFORMS.COM AND REGISTER YOUR CHILD'S DETAILS. YOU CAN THEN VIEW ALL THE PRESCRIBED UNIFORM PRODUCTS. YOU WILL FIND A TAB HOW TO MEASURE FOR THIS NEXT TO EVERY PRODUCT. CLICK ON IT TO FIND DETAILED INFOGRAM AND LINK TO DIY VIDEOS TO MEASURE YOUR CHILD FOR THAT PERFECT FIT.");
                    break;
                case "DELIVER":
                    $this->say("GENERALLY IT TAKES AROUND 7 WORKING DAYS TO RECEIVE YOUR ONLINE ORDER. HOWEVER, DURING THE PEAK SEASON TIMES THESE DELIVERY TIMELINES MAY GET EXTENDED. YOU CAN MESSAGE XXXXX YOUR REQUIREMENTS  TO GET A ESTIMATED DELIVERY TIME BEFORE YOU PROCEED TO ORDER.");
                    break;
                case "EXCHANGE":
                    $this->say("YES, YOU ARE WELCOME TO EXCHANGE YOUR UNIFORMS FOR SIZE DIFFERENCES, DEFECTS, DAMAGES,ETC,.  WITHIN 7  DAYS OF YOUR PURCHASE. HOWEVER, YOU WILL HAVE TO CARRY THE BILL AS PROOF OF PURCHASE AND THE ITEMS WILL HAVE TO BE UNUSED, UNWASHED AND IN ORIGINAL CONDITION. MANAGER'S DESCISION IN THIS REGARD WILL BE FINAL.
                            ADDITIONALLY, NOTE THAT THE EXCHANGE WILL BE ENTERTAINED FOR THE SAME CATEGORY OF PRODUCT. NO CROSS EXCHANGES WILL BE DONE.
                            RETURN/REFUND OF THE PRODUCT WILL NOT BE DONE UNDER ANY CIRCUMSTANCES. ");
                    break;
                case "STOCK":
                    $this->say(" WE HAVE A USP OF HAVING ALL YOUR UNIFORM REQUIREMENTS IN STOCK ALL YEAR ROUND. HOWEVER, DURING THE PEAK SCHOOL OPENING SEASON, SOME ITEMS DO RUN OUT OF STOCK INSPITE OF OUR INTENSE PLANNING. WE PUT IN  ALL EFFORTS TO REPLENISH THESE OUT OF STOCK ITEMS AT THE EARLIEST, BUT IT MAY SOMETIMES TAKE CLOSE TO 2-3 WEEKS TO HAVE THEM BACK IN THE SHELVES. YOU CAN PLACE A REQUEST WITH YOUR PHONE NUMBER AT THE STORE NEAREST TO YOU AND WE WILL HAVE YOU NOTIFIED THE MOMENT WE HAVE THE STOCKS BACK. WE APPRECIATE YOUR PATIENCE IN THIS REGARD.");
                    break;
                case "BUY":
                    $this->say(" IT IS ADVISED THAT YOU MAKE YOUR PURCHASES DURING THE EARLY DAYS OF THE SCHOOL VACATIONS EG., END OF APRIL OR FIRST WEEK OF MAY. THE CROWDS ARE FAR LESSER AND YOU CAN BUY YOUR REQUIREMENTS ");
                    break;
                case "QUERY":
                    $this->say("PLEASE SEND IN A MESSAGE WITH YOUR QUERY  TO XXXXX AND WE WILL REVERT TO YOU AT THE EARLIEST. THANK YOU FOR YOUR PATIENCE.");
                    break;
            }
        });

    }

    // Start the conversation by asking for the user's name
    public function run()
    {
        $this->welcomeMainMenu();
    }
}
