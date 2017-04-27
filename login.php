<?php
// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
    require_once ('../../mysqli_connect.php'); // Connect to the db.
    $errors = array(); // Initialize error array.
    // Check for an email address.
    if (empty($_POST['username'])) {
        $errors[] = 'You must enter a username.';
    } else {
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    }
    // Check for a password.
    if (empty($_POST['password'])) {
        $errors[] = 'You must enter a password.';
    } else {
        $password = mysqli_real_escape_string($dbc, $_POST['password']);
    }
    if (empty($errors)) { // If everything's OK.
        /* Retrieve the user_id and first_name for
        that email/password combination. */
        $loginquery = "SELECT Username, Password, UserClass FROM USERS WHERE Username='$username' AND Password='$password'";
        $loginresult = @mysqli_query ($dbc, $loginquery); // Run the query.
        $row = mysqli_fetch_array ($loginresult, MYSQLI_NUM);
        if ($row) { // A record was pulled from the database.
            //Set the session data:
            session_start();
            $_SESSION['Username'] = $row[0];
            $_SESSION['Password'] = $row[1];
            $_SESSION['UserClass'] = $row[2];

            // Redirect:
            header("Location:index.php");
            exit(); // Quit the script.
        } else { // No record matched the query.
            $errors[] = 'Invalid username or password.'; // Public message.
        }
    } // End of if (empty($errors)) IF.
    mysqli_close($dbc); // Close the database connection.
} else { // Form has not been submitted.
    $errors = NULL;
} // End of the main Submit conditional.
?>

<?php
// Begin the page now.
$page_title = 'Login';
include ('includes/header.html');

?>
<!-- BODY CONTENT BELOW -->
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

    <body>

    <div class="row" id="reports" style="width:95%; padding-left:15px;">
    <div class="large-24 columns">
<?php

if (!empty($errors)) { // Print any error messages.
    echo "<br />";
    echo "<div class='row'>";
    echo "<div class='large-4 medium-4 columns'>";
    echo "<div class='primary callout'>";
    echo '<h1 id="mainhead">Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
    foreach ($errors as $msg) { // Print each error.
        echo " - $msg<br />\n";
    }
    echo '</p><p>Please try again.</p>';
    echo '</div></div></div>';
}

// Create the form.
?>

<h2>Please login here.</h2>
<form action="login.php" method="post">
    <p>Username: <input type="text" name="username" size="20" maxlength="40" /> </p>
    <p>Password: <input type="password" name="password" size="20" maxlength="20" /></p>
    <p><input type="submit" name="submit" value="Login" class="button"/></p>
    <input type="hidden" name="submitted" value="TRUE" />
</form>

            </div>
        </div>
<?php
include ('includes/footer.html');
?>