<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link href="eventReg.css" rel="stylesheet" type="text/css">
</head>

<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <h1> Welcome <?= $_POST['userName']; ?> 
    <input class="button1" onclick="window.location.href = 'index.html'" type="submit" value="Sign Out"> </h1>
        <!-- Registered Events -->

<form method="POST" action="withdraw.php">
    <input id="userName" type="hidden" name="userName" value="<?php echo $_POST['userName']; ?>"/>
    <input id="userId" type="hidden" name="userId" value="<?php echo $_POST['userId']; ?>"/>
    <h2>Registered Events</h2>
    <p class="registeredEvents"></p>

    <input class="button" type="submit" value="Withdraw">
</form>
        
<form method="POST" action="register.php">
    <!-- Events available for Registration-->
    <input id="userName" type="hidden" name="userName" value="<?php echo $_POST['userName']; ?>"/>
    <input id="userId" type="hidden" name="userId" value="<?php echo $_POST['userId']; ?>"/>

    <h2>Events available for Registration</h2>
    <p class="events"></p>
    
    <input class="button" type="submit" value="Register">
</form>

<script>
    $(document).ready(function(){
        var userId = "<?php echo $_POST['userId']; ?>";
        $.ajax({
            method: "POST",
            url: "registeredEvents.php",
            data: { data: userId },
            success: function(response) {
                // Handle the response from the receiving page (if needed)
                console.log(response);
            },
            error: function(error) {
                // Handle errors (if any)
                console.error(error);
            }
        }).done(function(response) {
            $("p.registeredEvents").html(response);
        });
        
        $.ajax({
            method: "POST",
            url: "eventTable.php",
            data: { data: userId },
            success: function(response) {
                // Handle the response from the receiving page (if needed)
                console.log(response);
            },
            error: function(error) {
                // Handle errors (if any)
                console.error(error);
            }
        }).done(function(response) {
            $("p.events").html(response);
        });
    });

</script>

</body>
</html>
