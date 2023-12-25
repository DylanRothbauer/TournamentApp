
<?php
$servername = "167.99.227.133";
$username = "user12";
$password = "fish";
$dbname = "AgileExpG12";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['userId']) && isset($_POST['eventId']) && isset($_POST['userName'])) {
        $userId = $_POST['userId'];
        $eventId = $_POST['eventId'];
        $userName = $_POST['userName'];

        // Prepare and execute queries to retrieve user's first and last name
        $getFName = "SELECT firstName FROM User WHERE id = '$userId'";
        $result = $conn->query($getFName);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $firstname = $row["firstName"];
        }

        $getLName = "SELECT lastName FROM User WHERE id = '$userId'";
        $result = $conn->query($getLName);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastname = $row["lastName"];
        }

        // Check if the event has available seats
        $checkAvailability = "SELECT availability, name, date, maxSeats FROM Event WHERE id = '$eventId'";
        $result = $conn->query($checkAvailability);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $availability = $row["availability"];
            $eventName = $row["name"];
            $eventDate = $row["date"];
            $eventMaxSeats = $row["maxSeats"];

            if ($availability > 0) {
                // Insert the user's registration into UserEvent table
                $insertUserEvent = "INSERT INTO UserEvent (userId, eventId) VALUES ('$userId', '$eventId')";
                if ($conn->query($insertUserEvent) === TRUE) {
                    // Update availability count in Event table
                    $updateAvailability = "UPDATE Event SET availability = availability - 1 WHERE id = '$eventId'";
                    if ($conn->query($updateAvailability) === TRUE) {
                        // FOR DISPLAY
                        echo "<!DOCTYPE html>
                            <html lang='en'>
                            <head>
                                <meta charset='UTF-8'>
                                <title>Confirmation</title>
                                <link href='eventReg.css' rel='stylesheet' type='text/css'>
                            </head>
                            <body>
                                <h1>Summary</h1>
                                <p>User $firstname $lastname has been registered for $eventName</p>
                                <p>which is scheduled for $eventDate</p>
                                <button class='button' onclick='history.back();'>Back</button>
                                
                            </body>
                            
                            </html>";

                        // No need for another form here, the confirmation is already displayed
                    } else {
                        echo "Error updating availability: " . $conn->error;
                    }
                } else {
                    echo "Error inserting user event: " . $conn->error;
                }
            } else {
                echo "Event is full!";
            }
        } else {
            echo "Event not found!";
        }
    } else {
        echo "Missing data!";
    }
} else {
    echo "Form not submitted!";
}

// Close your database connection
$conn->close();
?>