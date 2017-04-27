<?php
require_once ('../../../mysqli_connect.php');

if (isset($_GET['BookingID'])) {
	$BookingID = $_GET['BookingID'];
} else if (isset($_POST['BookingID'])) {
    $BookingID = $_POST['BookingID'];
} else {
    //no booking id
}

  if ($_POST['booking_submitted']){
      $CustID = $_POST['CustID'];
      $RoomID = $_POST['RoomID'];
      $CatererID = $_POST['CatererID'];
      $Start = $_POST['Start'];
      $End = $_POST['End'];
      $Cancelled = $_POST['Cancelled'];

      $verifyQuery = "SELECT BookingID FROM BOOKING WHERE RoomID = $RoomID AND BookingID <> $BookingID AND Cancelled <> 1 AND Start BETWEEN '$Start' AND '$End' OR RoomID = $RoomID AND BookingID <> $BookingID AND Cancelled <> 1 AND End BETWEEN '$Start' AND '$End'";
      $verifyResult = @mysqli_query ($dbc, $verifyQuery);

      if (mysqli_num_rows($verifyResult) == 0 ) {
          $fail = false;
      } else {
          $fail = true; // The record(s) do exist
      }


      if ($fail == true) {
          echo "<p align='center'>Sorry, this room is not available during the dates requested!</p>";
          //echo "<p align='center'>Please click <a href=\"index.php\">here</a> to reload the page.</p>";
      } else if ($BookingID > 0) {
          $newbookquery = "UPDATE BOOKING 
                           SET CustID = $CustID, RoomID = $RoomID, CatererID = $CatererID, Start = '$Start', End = '$End', Cancelled = $Cancelled
                           WHERE BookingID = $BookingID";
          $newbookresult = @mysqli_query ($dbc, $newbookquery);

          if ($newbookresult){
              echo "<p align='center'><b>Your booking has been updated.</b></p>";
          } else {
              echo "<p>The record could not be updated due to a system error" . mysqli_error($dbc) . "</p>";
          }
      }
      else {
          //No booking specified to update.
      }

  } // only if submitted by the form
  else {
      //nothing
  }
?>
  <form id ="booking" action="<?php echo $PHP_SELF;?>" method="post" name="booking">


            <!-- BOOKING SECTION -->
      <?php if ($BookingID > 0) {
      $currentquery = "SELECT CustID, RoomID, CatererID, DATE_FORMAT(Start, '%Y-%m-%d') AS 'Start', DATE_FORMAT(End, '%Y-%m-%d') AS 'End', Cancelled
      FROM BOOKING
      WHERE BookingID = $BookingID";
      $currentresult = @mysqli_query ($dbc, $currentquery);

      while ($row = mysqli_fetch_array($currentresult, MYSQLI_ASSOC)) {
          $CustID = $row['CustID'];
          $RoomID = $row['RoomID'];
          $CatererID = $row['CatererID'];
          $Start = $row['Start'];
          $End = $row['End'];
          $Cancelled = $row['Cancelled'];
        }

      } else {
      // nothing
      } ?>

      <?php $custquery = "SELECT CustID, CustName, City, State
      FROM CUSTOMER";
      $custresult = @mysqli_query ($dbc, $custquery); ?>

      <?php $venuequery = "SELECT RoomID, RoomName
      FROM VENUE";
      $venueresult = @mysqli_query ($dbc, $venuequery); ?>

      <?php $catererquery = "SELECT CatererID, Business
      FROM CATERER";
      $catererresult = @mysqli_query ($dbc, $catererquery); ?>

            <div class="row" id="newBooking">
              <div class="large-24 columns">
                <h3>Enter New Booking</h3>  
            <div class="row">
              <div class="large-12 medium-8 columns">
                <h5>Please fill in all relevant information:</h5>
                <hr />          
                <h5>Booking ~ Customer | Room | Caterer | Start | End | Cancel</h5>
                <!--<form id="booking" method="post" name="booking">-->
                  <div class="row">
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                          <label>Customer</label>
                          <select name="CustID"/>
                            <?php
                                while ($row = mysqli_fetch_array($custresult, MYSQLI_ASSOC)) {
                                    if ($CustID == $row['CustID']) {
                                        $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                echo "<option $selected value=".$row['CustID'].">".$row['CustName']."-".$row['City'].",".$row['State']."</option>";
                                }
                            ?>
                          </select>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                          <label>Room</label>
                          <select name="RoomID"/>
                            <?php
                            while ($row = mysqli_fetch_array($venueresult, MYSQLI_ASSOC)) {
                                if ($RoomID == $row['RoomID']) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo "<option $selected value=".$row['RoomID'].">".$row['RoomName']."</option>";
                            }
                            ?>
                          </select>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                          <label>Caterer</label>
                            <select name="CatererID"/>
                            <?php
                            while ($row = mysqli_fetch_array($catererresult, MYSQLI_ASSOC)) {
                                if ($CatererID == $row['CatererID']) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo "<option $selected value=".$row['CatererID'].">".$row['Business']."</option>";
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="primary callout">
                      <div class="row">
                        <!--<div class="large-2 medium-4 columns">
                        </div>-->

                        <div class="large-4 medium-4 columns">
                          <label>Start</label>
                            <input type="date" name="Start" id="Start" value="<?php echo($Start);?>"/>
                        </div>
                        <div class="large-4 medium-4 columns">
                          <label>End</label>
                            <input type="date" name="End" id="End" value="<?php echo($End);?>"/>
                        </div>
                          <div class="large-4 medium-4 columns">
                              <label>Cancelled?</label>
                              <select name="Cancelled"/>
                              <?php
                              if ($Cancelled == 1) {
                                  $selected1 = "selected";
                                  $selected2 = "";
                              } else {
                                  $selected1 = "";
                                  $selected2 = "selected";
                              }
                              echo "<option $selected1 value=1>Cancelled</option>";
                              echo "<option $selected2 value=0>Not Cancelled</option>";
                              ?>
                              </select>
                          </div>
                      </div>
                    </div>
                    <div class="small-6 large-2 columns">
                        <input name="submit" type="submit" class="button expand">
                    </div> 

              </div>
            </div>
            <input type="hidden" name="BookingID" value="$BookingID" />

            <input type="hidden" name="booking_submitted" value=true>
  </form>

<?php mysqli_close($dbc);?>