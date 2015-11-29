<?php

/**
 * Email form for the Rowan ACM
 * 
 * @author Richard Cerone
 * @group Web Development
 * @date 11/17/2015
 */

if(isset($_POST['email'])) //Check if email was entered.
{
    $emailTo = "bhaktaj7@students.rowan.edu";
    $email_subject = $_POST['subject'];

    $errorMessage = "";
    
    //Check for empty fields.
    if(!isset($_POST['name']))
    {
        $errorMessage .= "You left name empty!";
        $array = array('error' => $errorMessage);
        
        echo json_encode($array); //Send JSON.
    }
    else if(!isset($_POST['subject']))
    {
        $errorMessage .= "You left subject empty!";
        $array = array('error' => $errorMessage);
        
        echo json_encode($array); //Send JSON.
    }
    else if(!isset($_POST['comment']))
    {
        $errorMessage .= "You left comment empty!";
        $array = array('error' => $errorMessage);
        
        echo json_encode($array); //Send JSON.
    }
    else  //Otherwise continue.
    {
        $name = $_POST['name']; //Get name.
        $email = $_POST['email']; //Get email of subject.
        $subject = $_POST['subject']; //Get subject of email.
        $comment = $_POST['comment']; //Get comments of email.
        
        //Characters we don't want.
        $emailException = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if(!preg_match($emailException, $email))
        {
            $errorMessage .= "The email address you entered is not valid.";
            $array = array('error' => $errorMessage);
            
            echo json_encode($array); //Send JSON.
        }
        else if(!preg_match($emailException, $name))
        {
            $errorMessage .= 'The name you entered is not valid.';
            $array = array('error' => $errorMessage);
            
            echo json_encode($array); //Send JSON.
        }
         else if(!preg_match($emailException, $subject))
        {
            $errorMessage .= 'The subject you entered is not valid.';
            $array = array('error' => $errorMessage);
            
            echo json_encode($array); //Send JSON.
        }
         else if(!preg_match($emailException, $comment))
        {
            $errorMessage .= 'The comment you entered is not valid.';
            $array = array('error' => $errorMessage);
            
            echo json_encode($array); //Send JSON.
        }
        else //All checks out; continue...
        {
            /**
             * Scrubs string with any unwanted text.
             * 
             * @param type $string the string to be cleaned.
             * @return type a cleaned string.
             */
            function cleanString($string)
            {
                $badText = array("content-type", "bcc:", "cc:", "href"); //text to clean if found.

                return str_replace($badText, "", $string); //Return cleaned string.
            }

            //Prepare email.
            $emailMessage .= "Name: " . cleanString($name) . "\n";
            $emailMessage .= "Email: " . cleanString($email) . "\n";
            $emailMessage .= "Subject: " . cleanString($subject) . "\n";
            $emailMessage .= "Comment:\n" . cleanString($comment) . "\n";

            //Create email headers.
            $headers = "From: " . $email . "\r\n" .
                    "Reply-To: " . $email . "\r\n" . 
                    "X-Mailer: PHP/" . phpVersion();

            @mail($emailTo, $subject, $emailMessage, $headers); //Send email here.

            $array = array('submitted' => 'true'); //Send back true.

            echo json_encode($array); //Send JSON.
        }
    }
}
else
{
    $array = array('submitted' => 'false'); //Send back false.
    echo json_encode($array); //Send JSON.
}
?>