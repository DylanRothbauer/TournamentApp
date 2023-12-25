<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
th, td {
    text-align: center;
    padding: 10px;
}
th {
    background-color:#2A4494;
}
table{
    border-collapse: collapse;
    margin-left: auto;
    margin-right:auto;
}
</style>
</head>
<body>

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

$userId = $_POST['data'];

$sql = "SELECT Event.id, Event.name, Event.date, Event.maxSeats, Event.availability
        FROM Event
        JOIN UserEvent ON Event.id = UserEvent.eventId
        WHERE UserEvent.userId = $userId";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
    <tr>
        <th>ID</th>
        <th>Event Name</th>
        <th>Event Date</th>
        <th>Max Seats</th>
        <th>Availability</th>
        <th>Select</th>
    </tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>".$row["id"]."</td>
            <td>" . $row["name"]. "</td>
            <td>" . $row["date"]. "</td>
            <td>" . $row["maxSeats"]. "</td>
            <td>" . $row["availability"]. "</td>
            <td><input type='radio' name='eventId' value='" . $row["id"] . "'></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}


$conn->close();
?>

</body>
</html>
