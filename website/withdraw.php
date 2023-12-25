<?php
$servername = "167.99.227.133";
$username = "user12";
$password = "fish";
$dbname = "AgileExpG12";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check whether connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Checks whether connection was successful
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Save userId, eventId if found
    if (isset($_POST['userId']) && isset($_POST['eventId'])) {
        $userId = $_POST['userId'];
        $eventId = $_POST['eventId'];

        // Retrieve user's first name
        $getFName = "SELECT firstName FROM User WHERE id = '$userId'";
        $resultFName = $conn->query($getFName);

        if ($resultFName->num_rows > 0) {
            $row = $resultFName->fetch_assoc();
            $firstname = $row["firstName"];
        }

        // Retrieve user's last name
        $getLName = "SELECT lastName FROM User WHERE id = '$userId'";
        $resultLName = $conn->query($getLName);
        if ($resultLName->num_rows > 0) {
            $row = $resultLName->fetch_assoc();
            $lastname = $row["lastName"];
        }

        // Check if the event has available seats
        $checkAvailability = "SELECT availability, name, date, maxSeats FROM Event WHERE id = '$eventId'";
        $resultEvent = $conn->query($checkAvailability);

        if ($resultEvent->num_rows > 0) {
            $row = $resultEvent->fetch_assoc();
            $availability = $row["availability"];
            $eventName = $row["name"];
            $eventDate = $row["date"];
            $eventMaxSeats = $row["maxSeats"];
            $eventAvailability = $availability;

            // Check if the specific user event exists
            $checkUserEvent = "SELECT * FROM UserEvent WHERE userId = '$userId' AND eventId = '$eventId'";
            $resultUserEvent = $conn->query($checkUserEvent);

            if ($resultUserEvent->num_rows > 0) {
                // Delete user's event
                $deleteUserEvent = "DELETE FROM UserEvent WHERE userId = '$userId' AND eventId = '$eventId'";

                if ($conn->query($deleteUserEvent) === TRUE) {
                    //echo "User event deleted successfully.<br>";

                    // Update availability count in Event table
                    $updateAvailability = "UPDATE Event SET availability = availability + 1 WHERE id = '$eventId'";

                    if ($conn->query($updateAvailability) === TRUE) {
                        // Display confirmation
                        echo "<!DOCTYPE html>
                            <html lang='en'>
                            <head>
                                <meta charset='UTF-8'>
                                <title>Confirmation</title>
                                <link href='eventReg.css' rel='stylesheet' type='text/css'>
                            </head>
                            <body>
                                <h1>Summary</h1>
                                <p>User $firstname $lastname has been withdrawn from $eventName</p>
                                <p>which is scheduled for $eventDate</p>
                                <button class='button' onclick='history.back();'>Back</button>
                            </body>
                            </html>";
                    } else {
                        echo "Error updating availability: " . $conn->error;
                    }
                } else {
                    echo "Error deleting user event: " . $conn->error;
                }
            } else {
                echo "User event not found!";
            }
        } else {
            echo "Event not found!";
            echo "Error fetching event details: " . $conn->error;
        }
    }
}

// * link back to home page *
$conn->close();
?>