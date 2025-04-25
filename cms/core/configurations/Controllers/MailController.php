<?php
namespace cms\core\configurations\Controllers;

use Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\core\configurations\helpers\Configurations;
use cms\order\Mail\ShippingMessageEmail;
use Illuminate\Support\Facades\Log;
use cms\core\configurations\helpers\CmsMail;

class MailController extends Controller
{
    protected $details;

    public function setDetails($key, $value)
    {
        $this->details[$key] = $value;
    }
    public function getDetails($key)
    {
        return isset($this->details[$key]) ? $this->details[$key] : null;
    }

    public function sendWelcomeMessageEmail(Request $request)
    {
        //Add constants to setdetails array
        $this->setDetails("recipient", $request->school_email);
        $this->setDetails("recipient_name", $request->school_name);
        $this->setDetails("logo", Configurations::LOGO_PATH);
        $this->setDetails("message", Configurations::WELCOME_EMAIL);
        $this->setDetails("title", Configurations::WELCOME_EMAIL_TITLE);
        $this->setDetails("admin", Configurations::ADMIN_NAME);
        $details = $this->details;

        //email
        if (config("app.env") == "local") {
            \CmsMail::setMailTrapConfig();
        } else {
            \CmsMail::setMailConfig();
        }
        Mail::to($request->school_email)->send(
            new WelcomeMessageEmail($this->details)
        );
    }
    

    public function sendShippingNotification(Request $request, $pdf)
    {
        //Add constants to setdetails array        
        $this->setDetails("recipient", $request->customer_email);
        $this->setDetails("recipient_name", $request->customer_name);
        $this->setDetails("logo", Configurations::LOGO_PATH);
        $this->setDetails("message", $request->shipping_details);
        $this->setDetails("title", Configurations::SHIPPING_EMAIL_TITLE);
        $this->setDetails("admin", Configurations::ADMIN_NAME);
        $details = $this->details;
        

        //email
        if (config("app.env") == "local") {            
            CmsMail::setMailTrapConfig();
        } else {            
            CmsMail::setMailConfig();
        }
        Mail::to($request->customer_email)->send(
            new ShippingMessageEmail($this->details, $pdf)
        );
        
        
    }


    
}
