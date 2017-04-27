

<?php
require_once ('../../mysqli_connect.php');

?>
<div class="row" id="chkAvailDiv">
    <div class="large-24 columns">
        <h3>Check Room Availability</h3>
        <div class="row">
            <div class="large-12 medium-8 columns">
                <h5>Please enter dates to return a list of available rooms:</h5>
                <hr />
                <h5>Availability ~ Start Date | End Date</h5>
                <div class="row">
                    <form action="<?php echo $PHP_SELF;?>" method="post">
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Start Date</label>
                            <input type="date" name="availStartDate">
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>End Date</label>
                            <input type="date" name="availEndDate">
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div><br />
                            <?php
                            echo "<input type=\"submit\" class=\"button\" value=\"Check Availability\"></p>";
                            echo "</form>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
if (isset($_GET['availStartDate'])) {
	$availStartDate = $_GET['availStartDate'];
}
else if (isset($_POST['availStartDate'])) {
    $availStartDate = $_POST['availStartDate'];
}
else {
	$availStartDate = "";
}
if (isset($_GET['availEndDate'])) {
    $availEndDate = $_GET['availEndDate'];
}
else if (isset($_POST['availEndDate'])) {
    $availEndDate = $_POST['availEndDate'];
}
else {
    $availEndDate = "";
}

if ($availStartDate && $availEndDate) {
    $availquery = "SELECT v.RoomID, (SELECT COUNT(*) FROM BOOKING b WHERE RoomID = v.RoomID AND b.Start BETWEEN '$availStartDate' AND '$availEndDate' OR RoomID = v.RoomID AND b.End BETWEEN '$availStartDate' AND '$availEndDate'  GROUP BY b.RoomID) AS subquery, v.AdjacentRoomID, v.RoomName, v.Fee, v.Size, v.Capacity, v.Projector, v.Kitchen, v.Restroom
FROM VENUE v
LEFT JOIN BOOKING b ON b.RoomID = v.RoomID
GROUP BY v.RoomID
HAVING IFNULL(subquery,0) = 0";

    $availresult = @mysqli_query ($dbc, $availquery);

    echo "<h4 align='center'>Available Rooms</h4>";
    //Create a table to display the query results.  Table header first.
    echo "<table class=\"hover\"><tr>";
//Display all of the records returned in the table

    echo "<thead>";
    echo "<th>Room ID</th><th>Room Name</th><th>Adjacent Room ID</th><th>Fee</th><th>Size</th><th>Capacity</th><th>Projector</th><th>Kitchen</th><th>Restroom</th></tr>";
    echo "</thead><tbody>";
    while ($row = mysqli_fetch_array($availresult, MYSQLI_ASSOC)) {
        echo "<tr><td>".$row['RoomID']."</td>";
        echo "<td>".$row['RoomName']."</td>";
        echo "<td>".$row['AdjacentRoomID']."</td>";
        echo "<td>".$row['Fee']."</td>";
        echo "<td>".$row['Size']."</td>";
        echo "<td>".$row['Capacity']."</td>";
        echo "<td>".$row['Projector']."</td>";
        echo "<td>".$row['Kitchen']."</td>";
        echo "<td>".$row['Restroom']."</td></tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
    echo "</div>";
    //mysqli_close($dbc); // Close the DB connection.
}
else {
    //nothing
}

?>
<br />
<hr />
<br />
