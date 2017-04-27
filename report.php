<?php # index.php
session_start();
if (!isset($_SESSION['Username'])){
    // Redirect:
    header("Location:login.php");
    exit();
}else{
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CD | CC</title>

    <!-- STYLESHEETs -->
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">

    <!-- FONTS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Arsenal" rel="stylesheet">
</head>
<!-- BODY CONTENT BELOW -->
<body>
<?php include('includes/header.html'); ?>
<?php include('includes/hero.html'); ?>

<!--<section class="main">-->
<div class="row" id="reports" style="width:95%; padding-left:15px;">
    <div class="large-24 columns">
<?php
require_once ('../../mysqli_connect.php');

// Check for a specific report request.
if (isset($_GET['type'])) {
	$type = $_GET['type'];
}
else if (isset($_POST['postType'])) {
    $type = $_POST['postType'];
}
else {
	$type = "";
}

if (isset($_POST["custNameFilter"])) {
    $custNameFilter = ($_POST["custNameFilter"]);
}
else {
    //nothing
}
if (isset($_GET['customer'])) {
	$customer = $_GET['customer'];
	$query = "SELECT CustName FROM CUSTOMER WHERE CustID = $customer";
	$result = @mysqli_query ($dbc, $query);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$custName = ($row['CustName']);
	}
	if (custName == "") {
		$custName = "Customer Not Found";
	}
	else {
		//nothing
	}
}
else {
	//nothing
}

if ( $type == "cancelled" ) {
	echo "<h2>Cancelled Bookings</h2>";

	if (isset($customer)) {
		echo "<h3>For: $custName</h3>";
		$custQuery = "AND c.CustID = $customer";
	}
	else if (isset($custNameFilter)) {
        echo "<h3>Filter By: $custNameFilter</h3>";
        $custQuery = "AND UPPER(c.CustName) LIKE UPPER(\"%$custNameFilter%\")";
	}
	else {
		$custQuery = "";
	}

    echo "<form action=\"report.php\" method=\"post\">";
    echo "<p> Filter by Customer Name: <input type=\"text\" name=\"custNameFilter\" value=\"$custNameFilter\">";
    echo "<input type=\"hidden\" name=\"postType\" value=\"cancelled\">";
    echo "<input type=\"submit\" class=\"button\" value=\"Submit\"></p>";

	//Query for Cancelled Bookings
	$query = "SELECT b.BookingID, c.CustName AS \"Customer Name\", co.Organization AS \"Customer Organization\", v.RoomName AS \"Room Booked\", ca.Business AS \"Caterer\", DATE_FORMAT(b.Start, '%b %d, %Y') AS \"Event Start\", DATE_FORMAT(b.End, '%b %d, %Y') AS \"Event End\"
	FROM CUSTOMER c
	INNER JOIN BOOKING b ON c.CustID = b.CustID
	LEFT JOIN VENUE v ON b.RoomID = v.RoomID
	LEFT JOIN CATERER ca ON b.CatererID = ca.CatererID
	LEFT JOIN CUSTORG co ON c.OrgID = co.OrgID
	WHERE Cancelled = 1
	$custQuery
	ORDER BY b.Start";
}
else if ( $type == "active" ) {
    echo "<h2>Active Bookings</h2>";
    if (isset($customer)) {
        echo "<h3>For: $custName</h3>";
        $custQuery = "AND c.CustID = $customer";
    }
    else if (isset($custNameFilter)) {
        echo "<h3>Filter By: $custNameFilter</h3>";
        $custQuery = "AND UPPER(c.CustName) LIKE UPPER(\"%$custNameFilter%\")";
    }
    else {
        $custQuery = "";
    }

    echo "<form action=\"report.php\" method=\"post\">";
    echo "<p> Filter by Customer Name: <input type=\"text\" name=\"custNameFilter\" value=\"$custNameFilter\">";
    echo "<input type=\"hidden\" name=\"postType\" value=\"active\">";
    echo "<input type=\"submit\" class=\"button\" value=\"Submit\"></p>";

    //Query for Not Cancelled (Active) Bookings
    $query = "SELECT b.BookingID, c.CustName AS \"Customer Name\", co.Organization AS \"Customer Organization\", v.RoomName AS \"Room Booked\", ca.Business AS \"Caterer\", DATE_FORMAT(b.Start, '%b %d, %Y') AS \"Event Start\", DATE_FORMAT(b.End, '%b %d, %Y') AS \"Event End\"
	FROM CUSTOMER c
	INNER JOIN BOOKING b ON c.CustID = b.CustID
	LEFT JOIN VENUE v ON b.RoomID = v.RoomID
	LEFT JOIN CATERER ca ON b.CatererID = ca.CatererID
	LEFT JOIN CUSTORG co ON c.OrgID = co.OrgID
	WHERE Cancelled = 0
	$custQuery
	ORDER BY b.Start";
}
else if ( $type == "customers") {
	echo "<h2>Customer List</h2>";

    if (isset($customer)) {
        echo "<h3>For: $custName</h3>";
        $custQuery = "WHERE CustID = $customer";
    }
    else if (isset($custNameFilter)) {
        echo "<h3>Filter By: $custNameFilter</h3>";
        $custQuery = "WHERE UPPER(CustName) LIKE UPPER(\"%$custNameFilter%\")";
    }
    else {
        $custQuery = "";
    }

    echo "<form action=\"report.php\" method=\"post\">";
    echo "<p> Filter by Customer Name: <input type=\"text\" name=\"custNameFilter\" value=\"$custNameFilter\">";
    echo "<input type=\"hidden\" name=\"postType\" value=\"customers\">";
    echo "<input type=\"submit\" class=\"button\" value=\"Submit\"></p>";

	$query = "SELECT CustID, CustName, co.Organization AS \"Organization\", Telephone, Email, Address, City, State, Zip 
              FROM CUSTOMER c 
              LEFT JOIN CUSTORG co ON c.OrgID = co.OrgID
              $custQuery";
}
else if ( $type == "byCustomer" ) {
    echo "<h2>Bookings By Customer</h2>";
    //Query for Bookings By Customer
    $query = "SELECT b.BookingID, c.CustName, co.Organization AS \"Customer Organization\", v.RoomName AS \"Room Booked\", ca.Business AS \"Caterer\", DATE_FORMAT(b.Start, '%b %d, %Y') AS \"Event Start\", DATE_FORMAT(b.End, '%b %d, %Y') AS \"Event End\", FORMAT(IFNULL(v.Fee * (DATEDIFF(b.End,b.Start) + 1),0),2) AS 'Cost'
	FROM CUSTOMER c
	INNER JOIN BOOKING b ON c.CustID = b.CustID
	LEFT JOIN VENUE v ON b.RoomID = v.RoomID
	LEFT JOIN CATERER ca ON b.CatererID = ca.CatererID
	LEFT JOIN CUSTORG co ON c.OrgID = co.OrgID
	WHERE Cancelled = 0
	ORDER BY c.CustName, b.Start";
}
else if ( $type == "all") {
	echo "<h2>All Bookings</h2>";
	if (isset($customer)) {
		echo "<h3>For: $custName</h3>";
		$custQuery = "WHERE c.CustID = $customer";
	}
    else if (isset($custNameFilter)) {
        echo "<h3>Filter By: $custNameFilter</h3>";
        $custQuery = "WHERE UPPER(c.CustName) LIKE UPPER(\"%$custNameFilter%\")";
    }
	else {
		$custQuery = "";
	}

    echo "<form action=\"report.php\" method=\"post\">";
    echo "<p> Filter by Customer Name: <input type=\"text\" name=\"custNameFilter\" value=\"$custNameFilter\">";
    echo "<input type=\"hidden\" name=\"postType\" value=\"all\">";
    echo "<input type=\"submit\" class=\"button\" value=\"Submit\"></p>";

	//Query for All Bookings
	$query = "SELECT b.BookingID, c.CustName AS \"Customer Name\", co.Organization AS \"Customer Organization\", v.RoomName AS \"Room Booked\", ca.Business AS \"Caterer\", DATE_FORMAT(b.Start, '%b %d, %Y') AS \"Event Start\", DATE_FORMAT(b.End, '%b %d, %Y') AS \"Event End\"
	FROM CUSTOMER c
	INNER JOIN BOOKING b ON c.CustID = b.CustID
	LEFT JOIN VENUE v ON b.RoomID = v.RoomID
	LEFT JOIN CATERER ca ON b.CatererID = ca.CatererID
	LEFT JOIN CUSTORG co ON c.OrgID = co.OrgID
	$custQuery
	ORDER BY b.Start";
}
else {
    echo "<h3>Please select a report type from the options above.</h3>";
    goto theEnd;
}
//echo "<h3>".$query."</h3>";
$result = @mysqli_query ($dbc, $query);

//Create a table to display the query results.  Table header first.
echo "<table class=\"hover\"><tr>";
// Old Styles: cellpadding=5 cellspacing=5 border=1
//Display all of the records returned in the table
if ( $type == "customers" ) {
    echo "<thead>";
    echo "<th>Customer ID</th><th>Customer Name</th><th>Customer Organization</th><th>Telephone</th><th>Email</th><th>Address</th><th>City</th><th>State</th><th>Zip</th></tr>";
    echo "</thead><tbody>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo "<tr><td>".$row['CustID']."</td>";
		echo "<td>".$row['CustName']."</td>";
		echo "<td>".$row['Organization']."</td>";
		echo "<td>".$row['Telephone']."</td>";
		echo "<td>".$row['Email']."</td>";
		echo "<td>".$row['Address']."</td>";
		echo "<td>".$row['City']."</td>";
		echo "<td>".$row['State']."</td>";
		echo "<td>".$row['Zip']."</td></tr>";
	}
}
else if ($type == "byCustomer") {
    echo "<thead>";
    echo "<th>Customer Name</th><th>Customer Organization</th><th>Booking ID</th><th>Room Booked</th><th>Caterer</th><th>Event Start</th><th>Event End</th><th>Total Cost</th></tr>";
    echo "</thead><tbody>";
    $currentCust = '';
    $prevCust = '';
    $rowNumCount = 1;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $currentCust = $row['CustName'];
        if ($currentCust <> $prevCust) {
            $prevCust = $row['CustName'];
            if ($rowNumCount <> 1) { echo "<tr><td align='center'>-----</td><td align='center'>-----</td><td align='center'>-----</td><td align='center'>-----</td><td align='center'>-----</td><td align='center'>-----</td><td align='center'>-----</td><td align='center'>-----</td></tr>"; }
            echo "<tr><td style='font-weight: bold;'>".$row['CustName']."</td><td style='font-weight: bold;'>".$row['Customer Organization']."</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
        }

        echo "<tr><td></td>";
        echo "<td></td>";
        echo "<td>".$row['BookingID']."</td>";
        echo "<td>".$row['Room Booked']."</td>";
        echo "<td>".$row['Caterer']."</td>";
        echo "<td>".$row['Event Start']."</td>";
        echo "<td>".$row['Event End']."</td>";
        echo "<td>$".$row['Cost']."</td></tr>";
        $rowNumCount = $rowNumCount + 1;
    }
}
else {
    echo "<thead>";
    echo "<th>Booking ID</th><th>Customer Name</th><th>Customer Organization</th><th>Room Booked</th><th>Caterer</th><th>Event Start</th><th>Event End</th></tr>";
    echo "</thead><tbody>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	    echo "<tr><td>".$row['BookingID']."</td>";
		echo "<td>".$row['Customer Name']."</td>";
		echo "<td>".$row['Customer Organization']."</td>";
		echo "<td>".$row['Room Booked']."</td>";
		echo "<td>".$row['Caterer']."</td>";
		echo "<td>".$row['Event Start']."</td>";
		echo "<td>".$row['Event End']."</td></tr>";
	}
}

echo "</tbody></table>";
mysqli_close($dbc); // Close the DB connection.

theEnd:

?>
    </div>
    </div>
    <!--</section>-->

<?php include('includes/footer.html'); ?>

<!-- JAVASCRIPT -->

<script src="js/vendor/jquery.js"></script>
<script src="js/vendor/what-input.js"></script>
<script src="js/vendor/foundation.js"></script>
<script src="js/app.js"></script>

</body>
</html>
<?php } ?>