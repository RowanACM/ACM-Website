/**
 * Returns status of email submition.
 * 
 * @author Richard Cerone
 * @group Web Development
 * @date 11/17/2015
 */

function submitForm()
{
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var subject = document.getElementById("subject").value;
    var comment = document.getElementById("comment").value;
    
    $.ajax({
            url: 'php/email.php',
            type: 'post',
            data: {'name': name, 'email': email, 'subject': subject, 'comment': comment},
            success: function(data)
            {
                data = $.parseJSON('[' + data + ']'); //Parse to JSON array.
                if(data[0].submitted === true) //Email sent.
                {
                   var n = noty(
                    {
                        layout: 'topRight',
                        theme: 'relax',
                        type: 'success',
                        text: "We got your email and we'll get back to you ASAP!",
                        animation:
                        {
                            open: 'animated rollIn',
                            close: 'animated rollOut'
                        },
                        maxVisible: 5,
                        closeWith: ['click'],
                        timeout: 2500,    //2500ms
                        buttons: false
                    });
                }
                else //Print error
                {
                    var n = noty(
                    {
                        layout: 'topRight',
                        theme: 'relax',
                        type: 'error',
                        text: data[0].error,
                        animation:
                        {
                            open: 'animated rollIn',
                            close: 'animated rollOut'
                        },
                        maxVisible: 5,
                        closeWith: ['click'],
                        timeout: 2500,    //2500ms
                        buttons: false
                    });
                }
            },
            error: function(err)
            {
                console.log(err);
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