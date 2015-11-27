/**
 * Returns status of email submition.
 * 
 * @author Richard Cerone
 * @group Web Development
 * @date 11/17/2015
 */

function submitForm()
{
    var name = document.getElementById("name");
    var email = document.getElementById("email");
    var subject = document.getElementById("subject");
    var comment = document.getElementById("comment");
    
    $.post("php/email.php", {name: name, email: email, subject: subject, comment: comment}, function(data)
    {
        if(data.submitted === true)
        {
            
        }
        else
        {
            var error = data.error;
        }
    });
}

//Check for browser support.
var button = document.getElementById("submit");

if (button.addEventListener) //Not IE.
{
    button.addEventListener("click", submitForm, false);
}
else //Is IE -_-
{
    button.attachEvent("onclick", submitForm);
}