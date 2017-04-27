<?php
require_once ('../../mysqli_connect.php');

if (isset($_POST['CustID'])) {
    $CustID = $_POST['CustID'];
} else {
    //no caterer id
    $CustID = 0;
}

if ($_POST['customer_submitted']) {
    $CustName = $_POST['CustName'];
    $Telephone = $_POST['Telephone'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $City = $_POST['City'];
    $State = $_POST['State'];
    $Zip = $_POST['Zip'];


    if ($CustID > 0) {
        $custquery = "UPDATE CUSTOMER 
                  SET CustName = '$CustName', Telephone = '$Telephone', Email = '$Email', Address = '$Address', City = '$City', State = '$State', Zip = '$Zip'
                  WHERE CustID = $CustID";
        $custresult = @mysqli_query($dbc, $custquery);

        if ($custresult) {
            echo "<div class='primary callout'><p><b>The customer has been updated.</b></p></div>";
        } else {
            echo "<div class='secondary callout'><p>The record could not be updated due to a system error" . mysqli_error($dbc) . "</p></div>";
        }
    } // only if submitted by the form
}
?>

    <!-- CUSTOMER SECTION -->
<?php if ($CustID > 0) {
    ?><form id ="customer" action="<?php echo $PHP_SELF;?>" method="post" name="customer"><?php
    $currentquery = "SELECT CustName, OrgID, Telephone, Email, Address, City, State, Zip
      FROM CUSTOMER
      WHERE CustID = $CustID";
    $currentresult = @mysqli_query ($dbc, $currentquery);

    while ($row = mysqli_fetch_array($currentresult, MYSQLI_ASSOC)) {
        $CustName = $row['CustName'];
        $Telephone = $row['Telephone'];
        $Email = $row['Email'];
        $Address = $row['Address'];
        $City = $row['City'];
        $State = $row['State'];
        $Zip = $row['Zip'];
    }
    ?>

    <div class="wrap row">
    <div class="large-24 columns">
        <h3 id="newCustomer">View/ModifyCustomer</h3>
        <div class="row">
            <div class="large-12 medium-8 columns">
                <h5>Please fill in all relevant information:</h5>
            </div>
            <h5>Customer ~ Organization | Name | Telephone | Email | Address | City | State | Zip</h5>
            <form id="customers" method="post" name="customers" action="<? echo $PHP_SELF;?>">
                <div class="row">
                    <!-- <div class="large-12 columns">
                      <div class="primary callout">
                        <label>Organization</label>
                        <input type="text" placeholder="Group Name" name="OrgName"/></div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Customer Name</label>
                            <input type="text" value="<?php echo $CustName ?>"placeholder="Full Name" name="CustName" id="CustName"/>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Address</label>
                            <input type="text" value="<?php echo $Address ?>"placeholder="Address" name="Address"/>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Email Address</label>
                            <input type="text" value="<?php echo $Email ?>"placeholder="first.last@gmail.com" name="Email"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>City</label>
                            <input type="text" value="<?php echo $City ?>"placeholder="City" name="City"/>
                        </div>
                    </div>
                    <div class="large-2 medium-4 columns">
                        <div class="primary callout">
                            <label>State</label>
                            <input type="text" value="<?php echo $State ?>"placeholder="State" name="State"/>
                        </div>
                    </div>
                    <div class="large-2 medium-4 columns">
                        <div class="primary callout">
                            <label>Zip Code</label>
                            <input type="text" value="<?php echo $Zip ?>"placeholder="Zip Code" name="Zip"/>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Telephone</label>
                            <input type="text" value="<?php echo $Telephone ?>"placeholder="Phone Number" name="Telephone"/>
                        </div>
                    </div>
                    <div class="small-6 large-2 columns">
                        <input type=hidden name=customer_submitted value=true>
                        <input type="hidden" name="CustID" value=<?php echo $CustID ?>>
                        <input name="submit" type="submit" class="button expand">
                    </div>
            </form>
        </div>
    </div>

<?php }
else {
    $currentquery = "SELECT c.CustID, c.CustName, co.Organization, c.OrgID, c.Telephone, c.Email, c.Address, c.City, c.State, c.Zip
      FROM CUSTOMER c
      LEFT JOIN CUSTORG co ON c.OrgID = co.OrgID";
    $currentresult = @mysqli_query ($dbc, $currentquery);
?>

    <div class="row" id="viewcustomers">
        <div class="large-24 columns">
            <h3>Select a Customer to View/Modify:</h3>
            <div class="row">
                <div class="large-12 medium-8 columns">
                    <table class="hover"><tr>
                            <form id="ucustomer" method="post" name="ucustomers" action="<? echo $PHP_SELF;?>">
                                <thead>
                                <th>Select</th><th>Customer Name</th><th>Organization</th><th>Telephone</th><th>Email</th><th>Address</th><th>City</th><th>State</th><th>Zip</th></tr>
                                </thead><tbody>
                                <?php
                                while ($row = mysqli_fetch_array($currentresult, MYSQLI_ASSOC)) {
                                    echo "<tr><td><input type='radio' name='CustID' value='" . $row['CustID'] . "'></td>";
                                    echo "<td>" . $row['CustName'] . "</td>";
                                    echo "<td>" . $row['Organization'] . "</td>";
                                    echo "<td>" . $row['Telephone'] . "</td>";
                                    echo "<td>" . $row['Email'] . "</td>";
                                    echo "<td>" . $row['Address'] . "</td>";
                                    echo "<td>" . $row['City'] . "</td>";
                                    echo "<td>" . $row['State'] . "</td>";
                                    echo "<td>" . $row['Zip'] . "</td>";
                                } ?>
                    </table>
                    <input type="submit" class="button" value="View Record"></p>
    </form>
    </div>
    </div>
    </div>
    </div>
    <?php
}
theEnd:
mysqli_close($dbc);
?>