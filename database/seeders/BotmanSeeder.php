<?php
namespace Database\Seeders;

use cms\core\configurations\Models\BotmanModel;
use Illuminate\Database\Seeder;

class BotmanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "category" => "main_menu",
                "name"     => "STORE LOCATOR",
                "value"    => "STORE LOCATOR",
                "type"     => 1,
            ],
            [
                "category" => "main_menu",
                "name"     => "EXCHANGES",
                "value"    => "EXCHANGES",
                "type"     => 1,
            ],
            [
                "category" => "main_menu",
                "name"     => "STORE LOCATOR",
                "value"    => "STORE LOCATOR",
                "type"     => 1,
            ],
            [
                "category" => "main_menu",
                "name"     => "RE-ORDERS",
                "value"    => "REORDERS",
                "type"     => 1,
            ],
            [
                "category" => "main_menu",
                "name"     => "LOCATE MY SHIPMENT",
                "value"    => "LOCATE MY SHIPMENT",
                "type"     => 1,
            ],
            [
                "category" => "main_menu",
                "name"     => "FAQs",
                "value"    => "FAQs",
                "type"     => 1,
            ],
            [
                "category" => "STORE LOCATOR",
                "name"     => "RAJAJINAGAR",
                "value"    => "VIVEK TAILORS, RAJAJINAGAR
                            (LOCATION PIN CLICKABLE)
                            PH. NO. 08023302129
                            CLICK TO DIAL",
                "type"     => 2,
            ],
            [
                "category" => "STORE LOCATOR",
                "name"     => "INDIRANAGAR",
                "value"    => "VIVEK TAILORS, INDIRANAGAR
                            (LOCATION PIN CLICKABLE)
                            PH. NO. 080 41540536",
                "type"     => 2,
            ],
            [
                "category" => "STORE LOCATOR",
                "name"     => "WHITEFIELD",
                "value"    => " VIVEK TAILORS, WHITEFIELD
                            (LOCATION PIN CLICKABLE)
                            PH. NO. 080 40980683",
                "type"     => 2,
            ],
            [
                "category" => "STORE LOCATOR",
                "name"     => "HOSUR ROAD",
                "value"    => "VIVEK TAILORS, HOSUR ROAD
                                (LOCATION PIN CLICKABLE)
                                PH.NO. ",
                "type"     => 2,
            ],
            [
                "category" => "EXCHANGES",
                "name"     => "ORDERED ONLINE",
                "value"    => " 1.PLEASE CALL XXXXXX TO REQUEST AN EXCHANGE.
                                2. PLEASE NOTE THAT EXCHANGE IS POSSIBLE WITHIN 7 DAYS OF PURCHASE.
                                3. HOWEVER, NO EXCHANGE OF WHITE UNIFORMS.
                                4. ITEMS WILL BE EXCHANGED ONLY IF BROUGHT BACK IN UNUSED, UNWASHED AND ORIGINAL CONDITION.
                                5. EXCHANGE POSSIBLE FOR SAME TYPE OF PRODUCT ONLY. CROSS EXCHANGE WILL NOT BE ENTERTAINED.",
                "type"     => 3,
            ],
            [
                "category" => "EXCHANGES",
                "name"     => "ORDERED AT SCHOOL CAMPUS",
                "value"    => " PLEASE CALL PH.NO. XXXXX TO REQUEST AN EXCHANGE.
                                PLEASE KEEP YOUR ORDER NUMBER HANDY TO FACILITATE A QUICK RESPONSE",
                "type"     => 3,
            ],
            [
                "category" => "EXCHANGES",
                "name"     => "BOUGHT AT A STORE",
                "value"    => " 1. PLEASE VISIT OR INITIATE AN EXCHANGE BY YOUR REPRESENTATIVE LIKE SWIGGY/DUNZO ETC.
                                2. PLEASE NOTE THAT EXCHANGE NOT POSSIBLE IF YOU BOUGHT AFTER TRYING THE UNIFORMS.
                                3. ALSO WHITE UNIFORMS NO EXCHANGE.
                                4. EXCHANGES ENTERTAINED IF ACCOMPANIED WITH BILL AND WITHIN 7DAYS OF PURCHASE.
                                5. EXCHANGE WILL BE DONE ONLY FOR THE SAME ITEM THAT IS BROUGHT IN, FOR DEFECTS, SIZE ISSUES ETC. IT WILL NOT BE EXCHANGED FOR A DIFFERENT PRODUCT.",
                "type"     => 3,
            ],
            [
                "category" => "REORDERS",
                "name"     => "ONLINE PURCHASE",
                "value"    => " 1. PLEASE VISIT THE WEBSITE AND LOGIN TO YOUR ACCOUNT TO VIEW YOUR ORDER LOGS. YOU CAN ORDER YOUR REORDERS FROM THERE EFFORTLESSLY.
                                2. HOWEVER, IF YOU WOULD LIKE TO BUY YOUR  REORDERS AT ANY OF OUR STORES YOU CAN EITHER VISIT PERSONALLY OR SEND A REPRESENTATIVE  OR INITIATE A SWIGGY/DUNZO PICKUP BY MENTIONING THE SIZE AND QUANTITY OF THE REQUIRED PRODUCT FROM YOUR ONLINE ORDER LOG. WE MAY NOT HAVE THE RECORDS OF YOUR ORDERS AT THE OUTLETS SO WE WILL NOT BE ABLE TO ASSIST YOU IN THAT. ",
                "type"     => 3,
            ],
            [
                "category" => "REORDERS",
                "name"     => "SCHOOL CAMPUS PURCHASE",
                "value"    => " 1. PLEASE CALL XXXXX TO GET ASSISTANCE.
                                2. DO MENTION YOUR SCHOOL NAME, ORDER NUMBER AND OTHER DETAILS TO EXPEDIATE THE PROCESS.
                                3. HOWEVER, IF YOU WOULD LIKE TO BUY YOUR  REORDERS AT ANY OF OUR STORES YOU CAN EITHER VISIT PERSONALLY OR SEND A REPRESENTATIVE  OR INITIATE A SWIGGY/DUNZO PICKUP BY MENTIONING THE SIZE AND QUANTITY OF THE REQUIRED PRODUCT FROM YOUR SCHOOL  ORDER. WE MAY NOT HAVE THE RECORDS OF YOUR ORDERS AT THE OUTLETS SO WE WILL NOT BE ABLE TO ASSIST YOU IN THAT. ",
                "type"     => 3,
            ],
            [
                "category" => "REORDERS",
                "name"     => "BOUGHT AT A STORE",
                "value"    => " 1. IF YOU WOULD LIKE TO BUY  REORDERS BOUGHT AT ANY OF OUR STORES, YOU ARE MOST WELCOME TO EITHER VISIT PERSONALLY OR SEND A REPRESENTATIVE  OR INITIATE A SWIGGY/DUNZO PICKUP BY MENTIONING THE SIZE AND QUANTITY OF THE REQUIRED PRODUCT BY REFERRING TO THE SIZES MENTIONED ON THE PRODUCTS BOUGHT EARLIER THROUGH THIS REPRESENTATIVE. ",
                "type"     => 3,
            ],
            [
                "category" => "LOCATE MY SHIPMENT",
                "name"     => "LOCATE MY SHIPMENT",
                "value"    => "WE THANK YOU FOR YOUR ORDER.
                                1. GENERALLY UNIFORMS WILL REACH YOU IN 5 DAYS TIME AFTER WE HAVE DESPACTHED THEM. WE WOULD ALSO BE SENDING YOU THE AIRWAY BILL NUMBER (DOCKET NO.)  OF YOUR PACKAGE THROUGH YOUR REGISTERED EMAIL ID. PLEASE CHECK FOR THIS IN YOUR MAILBOX/SPAM FOLDER ONCE.
                                2. HOWEVER, IF DUE TO HEAVY TRAFFIC DURNG THE PEAK SEASON THIS INFORMATION MIGHT GET DELAYED.
                                3. SO WE REQUEST YOU TO PLEASE SEND A MESSAGE TO XXXXX MENTIONING YOUR ORDER NUMBER AND WE WILL REVERT BACK WITH THE STATUS AT THE EARLIEST. YOU CAN ALSO SEND AN EMAIL TO VIVGRP@GMAIL.COM MENTIONING THESE DETAILS.",
                "type"     => 3,
            ],
            [
                "category" => "FAQs",
                "name"     => "HOW DO I MEASURE MY CHILD TO ORDER ONLINE?",
                "value"    => "YOU CAN LOGIN TO OUR WEBSITE WWW.SHOPFORUNIFORMS.COM AND REGISTER YOUR CHILD'S DETAILS. YOU CAN THEN VIEW ALL THE PRESCRIBED UNIFORM PRODUCTS. YOU WILL FIND A TAB HOW TO MEASURE FOR THIS NEXT TO EVERY PRODUCT. CLICK ON IT TO FIND DETAILED INFOGRAM AND LINK TO DIY VIDEOS TO MEASURE YOUR CHILD FOR THAT PERFECT FIT.",
                "type"     => 3,
            ],
            [
                "category" => "FAQs",
                "name"     => "HOW MANY DAYS WILL IT TAKE TO DELIVER THE UNIFORMS IF I ORDER ONLINE?",
                "value"    => "GENERALLY IT TAKES AROUND 7 WORKING DAYS TO RECEIVE YOUR ONLINE ORDER. HOWEVER, DURING THE PEAK SEASON TIMES THESE DELIVERY TIMELINES MAY GET EXTENDED. YOU CAN MESSAGE XXXXX YOUR REQUIREMENTS  TO GET A ESTIMATED DELIVERY TIME BEFORE YOU PROCEED TO ORDER. ",
                "type"     => 3,
            ],
            [
                "category" => "FAQs",
                "name"     => "CAN I EXCHANGE MY UNIFORMS?",
                "value"    => "YES, YOU ARE WELCOME TO EXCHANGE YOUR UNIFORMS FOR SIZE DIFFERENCES, DEFECTS, DAMAGES,ETC,.  WITHIN 7  DAYS OF YOUR PURCHASE. HOWEVER, YOU WILL HAVE TO CARRY THE BILL AS PROOF OF PURCHASE AND THE ITEMS WILL HAVE TO BE UNUSED, UNWASHED AND IN ORIGINAL CONDITION. MANAGER'S DESCISION IN THIS REGARD WILL BE FINAL.
                                ADDITIONALLY, NOTE THAT THE EXCHANGE WILL BE ENTERTAINED FOR THE SAME CATEGORY OF PRODUCT. NO CROSS EXCHANGES WILL BE DONE.
                                RETURN/REFUND OF THE PRODUCT WILL NOT BE DONE UNDER ANY CIRCUMSTANCES.
                                WHITE UNIFORMS WILL NOT BE EXCHANGED, SO PLEASE BE SURE OF YOUR PURCHASE BEFORE YOU BUY THEM.",
                "type"     => 3,
            ],
            [
                "category" => "FAQs",
                "name"     => "HOW WILL I KNOW IF MY UNIFORM REQUIREMENTS ARE IN STOCK?",
                "value"    => "WE HAVE A USP OF HAVING ALL YOUR UNIFORM REQUIREMENTS IN STOCK ALL YEAR ROUND. HOWEVER, DURING THE PEAK SCHOOL OPENING SEASON, SOME ITEMS DO RUN OUT OF STOCK INSPITE OF OUR INTENSE PLANNING. WE PUT IN  ALL EFFORTS TO REPLENISH THESE OUT OF STOCK ITEMS AT THE EARLIEST, BUT IT MAY SOMETIMES TAKE CLOSE TO 2-3 WEEKS TO HAVE THEM BACK IN THE SHELVES. YOU CAN PLACE A REQUEST WITH YOUR PHONE NUMBER AT THE STORE NEAREST TO YOU AND WE WILL HAVE YOU NOTIFIED THE MOMENT WE HAVE THE STOCKS BACK. WE APPRECIATE YOUR PATIENCE IN THIS REGARD.",
                "type"     => 3,
            ],
            [
                "category" => "FAQs",
                "name"     => "HOW DO I KNOW WHAT IS THE BEST TIME TO COME TO THE STORE TO BUY THE UNIFORMS?",
                "value"    => "IT IS ADVISED THAT YOU MAKE YOUR PURCHASES DURING THE EARLY DAYS OF THE SCHOOL VACATIONS EG., END OF APRIL OR FIRST WEEK OF MAY. THE CROWDS ARE FAR LESSER AND YOU CAN BUY YOUR REQUIREMENTS EFFORTLESSLY.",
                "type"     => 3,
            ],
            [
                "category" => "FAQs",
                "name"     => "MY QUERY IS NOT LISTED HERE.",
                "value"    => "PLEASE SEND IN A MESSAGE WITH YOUR QUERY  TO XXXXX AND WE WILL REVERT TO YOU AT THE EARLIEST. THANK YOU FOR YOUR PATIENCE.",
                "type"     => 3,
            ],

        ];

        foreach ($data as $item) {
            BotmanModel::updateOrCreate(
                ["category" => $item["category"], "name" => $item["name"],
                    "value"     => $item["value"], "type"    => $item["type"]]
            );
        }
    }
}
