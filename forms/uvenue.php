<?php
require_once ('../../mysqli_connect.php');

if (isset($_POST['RoomID'])) {
    $RoomID = $_POST['RoomID'];
} else {
    //no booking id
    $RoomID = 0;
}

if ($_POST['venue_submitted']){
    $AdjacentRoom=$_POST['AdjacentRoom'];
    $RoomName=$_POST['RoomName'];
    $Fee=$_POST['Fee'];
    $Size=$_POST['Size'];
    $Capacity=$_POST['Capacity'];
    $Projector=$_POST['Projector'];
    $Kitchen=$_POST['Kitchen'];
    $Restroom=$_POST['Restroom'];

    if ($AdjacentRoom == "None") {
        $AdjacentRoomID = "";
    } else {

        $adjvenuequery2 = "SELECT RoomID, RoomName
      FROM VENUE WHERE RoomName = '$AdjacentRoom'";
        $adjvenueresult2 = @mysqli_query ($dbc, $adjvenuequery2);
        while ($row = mysqli_fetch_array($adjvenueresult2, MYSQLI_ASSOC)) {
            $AdjacentRoomID = $row['RoomID'];
        }
    }

    if ($RoomID > 0) {
            $venuequery="UPDATE VENUE 
                  SET AdjacentRoomID = '$AdjacentRoomID', RoomName = '$RoomName', Fee = '$Fee', Size = '$Size', Capacity = '$Capacity', Projector = '$Projector', Kitchen = '$Kitchen', Restroom = '$Restroom'
                  WHERE RoomID = $RoomID";
                $venueresult=@mysqli_query ($dbc, $venuequery);
        if ($venueresult) {
            echo "<div class='primary callout'><p><b>The venue has been updated.</b></p></div>";

        } else {
            echo "<div class='secondary callout'><p>The record could not be updated due to a system error" . mysqli_error($dbc) . "</p></div>";
        }
  } // only if submitted by the form

} // only if submitted by the form
?>

            <!-- VENUE SECTION -->
      <?php if ($RoomID > 0) {
    ?><form id ="venue" action="<?php echo $PHP_SELF;?>" method="post" name="venue"><?php
      $currentquery = "SELECT AdjacentRoomID, RoomName, Fee, Size, Capacity, Projector, Kitchen, Restroom
      FROM VENUE
      WHERE RoomID = $RoomID";
      $currentresult = @mysqli_query ($dbc, $currentquery);

      while ($row = mysqli_fetch_array($currentresult, MYSQLI_ASSOC)) {
          $AdjacentRoomID = $row['AdjacentRoomID'];
          $RoomName = $row['RoomName'];
          $Fee = $row['Fee'];
          $Size = $row['Size'];
          $Capacity = $row['Capacity'];
          $Projector = $row['Projector'];
          $Kitchen = $row['Kitchen'];
          $Restroom = $row['Restroom'];
        }
?>
    <?php $adjvenuequery = "SELECT RoomID, RoomName
      FROM VENUE";
    $adjvenueresult = @mysqli_query ($dbc, $adjvenuequery);

    $adjbookedquery = "SELECT RoomName FROM VENUE WHERE RoomID = $AdjacentRoomID";
    $adjbookedresult = @mysqli_query ($dbc, $adjbookedquery);

    while ($row = mysqli_fetch_array($adjbookedresult, MYSQLI_ASSOC)) {
        $AdjacentRoomName = $row['RoomName'];
    }
    ?>

    <div class="row">
    <div class="large-24 columns">
    <h3 id="newVenue">View/Modify Venue</h3>
    <div class="row">
        <div class="large-12 medium-8 columns">
            <h5>Please fill in/update all relevant information:</h5>
            <hr />
            <h5>Venue ~ Name | Fee | Size | Capacity | Projector | Kitchen | Restroom </h5>
            <form id="venue" action="<? echo $PHP_SELF;?>" method="post" name="venue">
                <div class="row">
                    <div class="large-12 columns">
                        <div class="primary callout">
                            <label>Name</label>
                            <input type="text" placeholder="Room Name" name="RoomName" value="<?php echo $RoomName ?>" id="RoomName"/></div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Rental Fee</label>
                            <input type="text" placeholder="Amount" name="Fee" value="<?php echo $Fee ?>"/>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Size</label>
                            <input type="text" placeholder="Size" name="Size" value="<?php echo $Size ?>"/>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                            <label>Capacity</label>
                            <input type="text" placeholder="Capacity" name="Capacity" value="<?php echo $Capacity ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-2 columns">
                        <div class="primary callout">
                            <label>Restroom</label>
                            <?php if ($Restroom == 1) {
                            $restroomval1 = "checked";
                            $restroomval0 = "";
                            } else {
                            $restroomval1 = "";
                            $restroomval0 = "checked";
                            } ?>
                            <input type="radio" name="Restroom" value="1" id="restroomYes" <?php echo $restroomval1; ?>><label for="restroomYes">Yes</label>
                            <input type="radio" name="Restroom" value="0" id="restroomNo" <?php echo $restroomval0; ?>><label for="restroomNo">No</label>
                        </div>
                    </div>
                    <div class="large-2 columns">
                        <div class="primary callout">
                            <label>Projector</label>
                            <?php if ($Projector == 1) {
                                $projectorval1 = "checked";
                                $projectorval0 = "";
                            } else {
                                $projectorval1 = "";
                                $projectorval0 = "checked";
                            } ?>
                            <input type="radio" name="Projector" value="1" id="projectorYes" <?php echo $projectorval1; ?>><label for="projectorYes">Yes</label>
                            <input type="radio" name="Projector" value="0" id="projectorNo" <?php echo $projectorval0; ?>><label for="projectorNo">No</label>
                        </div>
                    </div>
                    <div class="large-2 columns">
                        <div class="primary callout">
                            <label>Kitchen</label>
                            <?php if ($Kitchen == 1) {
                                $kitchenval1 = "checked";
                                $kitchenval0 = "";
                            } else {
                                $kitchenval1 = "";
                                $kitchenval0 = "checked";
                            } ?>
                            <input type="radio" name="Kitchen" value="1" id="kitchenYes" <?php echo $kitchenval1; ?>><label for="kitchenYes">Yes</label>
                            <input type="radio" name="Kitchen" value="0" id="kitchenNo" <?php echo $kitchenval0; ?>><label for="kitchenNo">No</label>
                        </div>
                    </div>
                    <div class="large-6 medium-4 columns">
                        <div class="primary callout">
                            <label>Adjacent Room</label>
                            <select name="AdjacentRoom"/>
                            <option value="None" selected>None</option>
                            <?php
                            while ($row = mysqli_fetch_array($adjvenueresult, MYSQLI_ASSOC)) {

                                if ($AdjacentRoomName == $row['RoomName']) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }

                                echo "<option $selected value='".$row['RoomName']."'>".$row['RoomName']."</option>";
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="small-6 large-2 columns">
                        <input type=hidden name=venue_submitted value=true>
                        <input type="hidden" name="RoomID" value=<?php echo $RoomID ?>>
                        <input name="submit" type="submit" class="button expand">
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php }
      else {
            $currentquery = "SELECT RoomID, AdjacentRoomID, RoomName, Fee, Size, Capacity, Projector, Kitchen, Restroom
                  FROM VENUE";
            $currentresult = @mysqli_query ($dbc, $currentquery); ?>
            <div class="row" id="viewvenues">
              <div class="large-24 columns">
                  <h3>Select a Venue to View/Modify:</h3>
                  <div class="row">
                  <div class="large-12 medium-8 columns">
            <table class="hover"><tr>
            <form id="uvenue" method="post" name="uvenue" action="<? echo $PHP_SELF;?>">
            <thead>
            <th>Select</th><th>Room Name</th><th>Adjacent Room ID</th><th>Fee</th><th>Size</th><th>Capacity</th><th>Projector</th><th>Kitchen</th><th>Restroom</th></tr>
            </thead><tbody>
<?php
            while ($row = mysqli_fetch_array($currentresult, MYSQLI_ASSOC)) {
                echo "<tr><td><input type='radio' name='RoomID' value='" . $row['RoomID'] . "'></td>";
                echo "<td>" . $row['RoomName'] . "</td>";
                echo "<td>" . $row['AdjacentRoomID'] . "</td>";
                echo "<td>" . $row['Fee'] . "</td>";
                echo "<td>" . $row['Size'] . "</td>";
                echo "<td>" . $row['Capacity'] . "</td>";
                echo "<td>" . $row['Projector'] . "</td>";
                echo "<td>" . $row['Kitchen'] . "</td>";
                echo "<td>" . $row['Restroom'] . "</td></tr>";
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