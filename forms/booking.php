<?php
require_once ('../../mysqli_connect.php');

  if ($_POST['booking_submitted']){
      $CustID = $_POST['CustID'];
      $RoomID = $_POST['RoomID'];
      $CatererID = $_POST['CatererID'];
      $Start = $_POST['Start'];
      $End = $_POST['End'];

      $verifyQuery = "SELECT BookingID FROM BOOKING WHERE RoomID = $RoomID AND Start BETWEEN '$Start' AND '$End' OR RoomID = $RoomID AND End BETWEEN '$Start' AND '$End'";
      $verifyResult = @mysqli_query ($dbc, $verifyQuery);

      if (mysqli_num_rows($verifyResult) == 0 ) {
          $fail = false;
      } else {
          $fail = true; // The record(s) do exist
      }


      if ($fail == true) {
          echo "<p align='center'>Sorry, this room is not available during the dates requested!</p>";
          //echo "<p align='center'>Please click <a href=\"index.php\">here</a> to reload the page.</p>";
      } else {
          $newbookquery = "INSERT INTO BOOKING (CustID, RoomID, CatererID, Start, End, Cancelled)
                    VALUES ('$CustID', '$RoomID', '$CatererID', '$Start', '$End', 0)";
          $newbookresult = @mysqli_query ($dbc, $newbookquery);


          if ($newbookresult){
              echo "<center><p><b>Your booking has been added.</b></p>";
          } else {
              echo "<p>The record could not be added due to a system error" . mysqli_error($dbc) . "</p>";
          }
      }
      mysqli_close($dbc);
  } // only if submitted by the form
  else {
      //nothing
  }
?>
            <div class="row" id="newBooking">
              <div class="large-24 columns">
                <h3>Enter New Booking</h3>  
            <div class="row">
              <div class="large-12 medium-8 columns">
                <h5>Please fill in all relevant information:</h5>
                <hr />          
                <h5>Booking ~ Customer | Room | Caterer | Start | End | Cancel</h5>
                <!--<form id="booking" method="post" name="booking">-->
  <form id ="booking" action="<?php echo $PHP_SELF;?>" method="post" name="booking">


            <!-- BOOKING SECTION -->


      <?php $custquery = "SELECT CustID, CustName, City, State
      FROM CUSTOMER";
      $custresult = @mysqli_query ($dbc, $custquery); ?>

      <?php $venuequery = "SELECT RoomID, RoomName
      FROM VENUE";
      $venueresult = @mysqli_query ($dbc, $venuequery); ?>

      <?php $catererquery = "SELECT CatererID, Business
      FROM CATERER";
      $catererresult = @mysqli_query ($dbc, $catererquery); ?>

                  <div class="row">
                    <div class="large-4 medium-4 columns">
                        <div class="primary callout">
                          <label>Customer</label>
                          <select name="CustID"/>
                            <?php
                                while ($row = mysqli_fetch_array($custresult, MYSQLI_ASSOC)) {
                                echo "<option value=".$row['CustID'].">".$row['CustName']."-".$row['City'].",".$row['State']."</option>";
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
                                echo "<option value=".$row['RoomID'].">".$row['RoomName']."</option>";
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
                                echo "<option value=".$row['CatererID'].">".$row['Business']."</option>";
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
                          <input type="date" placeholder="Date" name="Start" id="Start"/>
                        </div>
                        <div class="large-4 medium-4 columns">
                          <label>End</label>
                          <input type="date" placeholder="Date" name="End" id="End"/>
                        </div>
                          <div class="large-4 medium-4 columns">
                          </div>
                      </div>
                    </div>
                    <div class="small-6 large-2 columns">
                        <input name="submit" type="submit" class="button expand">
                    </div> 

              </div>
            </div> 
            
            <input type="hidden" name="subject" value="Submission" />
            <input type="hidden" name="redirect" value="thankyou.html" />
                  <input type="hidden" name="booking_submitted" value=true>
  </form>

<?php ?>