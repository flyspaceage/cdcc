<?php
require_once ('../../mysqli_connect.php');

if (isset($_POST['CatererID'])) {
    $CatererID = $_POST['CatererID'];
} else {
    //no caterer id
    $CatererID = 0;
}

if ($_POST['caterer_submitted']) {
    $ContactName = $_POST['ContactName'];
    $Business = $_POST['Business'];
    $Telephone = $_POST['Telephone'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $City = $_POST['City'];
    $State = $_POST['State'];
    $Zip = $_POST['Zip'];
    $CostPerPlate = $_POST['CostPerPlate'];

    if ($CatererID > 0) {
        $catererquery = "UPDATE CATERER 
                  SET ContactName = '$ContactName', Business = '$Business', Email = '$Email', Address = '$Address', City = '$City', State = '$State', Zip = '$Zip', CostPerPlate = '$CostPerPlate'
                  WHERE CatererID = $CatererID";
        $catererresult = @mysqli_query($dbc, $catererquery);

        if ($catererresult) {
            echo "<div class='primary callout'><p><b>The caterer has been updated.</b></p></div>";
        } else {
            echo "<div class='secondary callout'><p>The record could not be updated due to a system error" . mysqli_error($dbc) . "</p></div>";
        }
    } // only if submitted by the form
}
    ?>

    <!-- CATERER SECTION -->
    <?php if ($CatererID > 0) {
        ?><form id ="caterer" action="<?php echo $PHP_SELF;?>" method="post" name="caterer"><?php
        $currentquery = "SELECT ContactName, Business, Telephone, Email, Address, City, State, Zip, CostPerPlate
      FROM CATERER
      WHERE CatererID = $CatererID";
        $currentresult = @mysqli_query ($dbc, $currentquery);

        while ($row = mysqli_fetch_array($currentresult, MYSQLI_ASSOC)) {
            $ContactName = $row['ContactName'];
            $Business = $row['Business'];
            $Telephone = $row['Telephone'];
            $Email = $row['Email'];
            $Address = $row['Address'];
            $City = $row['City'];
            $State = $row['State'];
            $Zip = $row['Zip'];
            $CostPerPlate = $row['CostPerPlate'];
        }
     ?>

    <div class="row">
        <div class="large-24 columns">
            <h3 id="newCaterer">View/Modify Caterer</h3></div>
    </div>
    <div class="row">
        <div class="large-12 medium-8 columns">
            <h5>Please fill in/update all relevant information:</h5>
            <hr />
            <h5>Caterer ~ Contact | Business | Telephone | Email | Address | City | State | Zip | Cost</h5>
            <form id="caterer" action="<?php echo $PHP_SELF;?>" method="post" name="caterer">
                <div class="row">
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Organization</label>
                            <input type="text" value="<?php echo $Business ?>"placeholder="Business Name" name="Business"/>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Name</label>
                            <input type="text" value="<?php echo $ContactName ?>"placeholder="Full Name" name="ContactName"/>
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
                    <div class="large-12 columns">
                        <div class="primary callout">
                            <label>Address</label>
                            <input type="text" value="<?php echo $Address ?>"placeholder="Address" name="Address"/></div>
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
                            <input type="text" value="<?php echo $Zip ?>" placeholder="Zip Code" name="Zip"/>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Telephone</label>
                            <input type="text" value="<?php echo $Telephone ?>" placeholder="Phone Number" name="Telephone"/></div>
                    </div>
                </div>
                <div class="primary callout">
                    <div class="row">
                        <div class="large-6 medium-4 columns">
                            <!--<label>Menu</label>
                            <select id="MenuType" name="MenuType">
                              <option name="husker">American</option>
                              <option name="starbuck">Latin</option>
                              <option name="hotdog">Asian</option>
                              <option name="apollo">Mediterranean</option>
                            </select>-->
                        </div>
                        <div class="large-6 medium-4 columns">
                            <label>Cost Per Plate</label>
                            <input type="text" value="<?php echo $CostPerPlate ?>" name="CostPerPlate" id="CostPerPlate" /></div>
                    </div>
                </div>
                <div class="small-6 large-2 columns">
                    <input type=hidden name=caterer_submitted value=true>
                    <input type="hidden" name="CatererID" value=<?php echo $CatererID ?>>
                    <input name="submit" type="submit" class="button expand">
                </div>
            </form>
        </div>
    </div>

<?php }
else {
    $currentquery = "SELECT CatererID, ContactName, Business, Telephone, Email, Address, City, State, Zip, FORMAT(IFNULL(CostPerPlate,0),2) AS CostPerPlate
                  FROM CATERER";
    $currentresult = @mysqli_query ($dbc, $currentquery); ?>
    <div class="row" id="viewcaterers">
        <div class="large-24 columns">
            <h3>Select a Caterer to View/Modify:</h3>
            <div class="row">
                <div class="large-12 medium-8 columns">
                    <table class="hover"><tr>
                            <form id="ucaterer" method="post" name="ucaterer" action="<? echo $PHP_SELF;?>">
                                <thead>
                                <th>Select</th><th>Contact Name</th><th>Business</th><th>Telephone</th><th>Email</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Cost Per Plate</th></tr>
                                </thead><tbody>
                                <?php
                                while ($row = mysqli_fetch_array($currentresult, MYSQLI_ASSOC)) {
                                    echo "<tr><td><input type='radio' name='CatererID' value='" . $row['CatererID'] . "'></td>";
                                    echo "<td>" . $row['ContactName'] . "</td>";
                                    echo "<td>" . $row['Business'] . "</td>";
                                    echo "<td>" . $row['Telephone'] . "</td>";
                                    echo "<td>" . $row['Email'] . "</td>";
                                    echo "<td>" . $row['Address'] . "</td>";
                                    echo "<td>" . $row['City'] . "</td>";
                                    echo "<td>" . $row['State'] . "</td>";
                                    echo "<td>" . $row['Zip'] . "</td>";
                                    echo "<td>$" . $row['CostPerPlate'] . "</td></tr>";
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