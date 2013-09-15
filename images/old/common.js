function ConfirmMessage(msg)
{
    if(confirm(msg) === TRUE) {
        return true;
    } else {
        alert("You clicked cancel.");
        window.location = "index2.php";
    }
}