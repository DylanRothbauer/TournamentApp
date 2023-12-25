<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmation</title>
    <link href="eventReg.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
    if ($_POST["action"] && $_POST["firstname"] && $_POST["lastname"] && $_POST["eventName"] && $_POST["eventDate"] && $_POST["eventMaxSeats"] && $_POST["eventAvailability"]) {
        $action = $_POST["action"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $eventName = $_POST["eventName"];
        $eventDate = $_POST["eventDate"];
        $eventMaxSeats = $_POST["eventMaxSeats"];
        $eventAvailability = $_POST["eventAvailability"];
    } else {
        echo '<a href="EventRegistration.php">Missing information, go back and complete the form again</a>';
        // Use echo to display HTML content within PHP block
    }
    ?>

    <h1>Summary</h1>
    <p>User <?= $firstname ?> <?= $lastname ?></p>
    <p>has been
        <?php
        if ($action == "withdraw") {
            $message = "withdrawn from";
        } else {
            $message = $action . "ed for"; // Changed + to .
        }
        ?>
        <?= $message ?>
        <?= $eventName ?></p>
    <p>which is scheduled for <?= $eventDate ?></p>
    <form method="post" action="/index.html"> <!-- Form to submit on button click -->
        <button type="submit">Sign Out</button>
    </form>
</body>
</html>
