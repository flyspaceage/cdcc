<?php
require_once ('../../mysqli_connect.php');

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
    $venuequery="INSERT INTO VENUE (AdjacentRoomID, RoomName, Fee, Size, Capacity, Projector, Kitchen, Restroom)
      Values ('$AdjacentRoomID', '$RoomName', '$Fee', '$Size', '$Capacity', '$Projector', '$Kitchen', '$Restroom')";
    $venueresult=@mysqli_query ($dbc, $venuequery);
    if ($venueresult) {
      echo "<div class='primary callout'><p><b>A new VENUE has been added.</b></p></div>";

    } else {
      echo "<div class='secondary callout'><p>The record could not be added due to a system error" . mysqli_error($dbc) . "</p></div>";
    }
    
    mysqli_close($dbc);
  } // only if submitted by the form
?>

<?php $adjvenuequery = "SELECT RoomID, RoomName
      FROM VENUE";
$adjvenueresult = @mysqli_query ($dbc, $adjvenuequery); ?>

<!-- VENUE SECTION -->

<div class="row">
  <div class="large-24 columns">
    <h3 id="newVenue">Enter New Venue</h3>  
<div class="row">
  <div class="large-12 medium-8 columns">
    <h5>Please fill in all relevant information:</h5>
    <hr />          
    <h5>Venue ~ Name | Fee | Size | Capacity | Projector | Kitchen | Restroom </h5>
    <form id="venue" action="<? echo $PHP_SELF;?>" method="post" name="venue">
      <div class="row">
        <div class="large-12 columns">
          <div class="primary callout">
            <label>Name</label>
            <input type="text" placeholder="Room Name" name="RoomName" id="RoomName"/></div>
        </div>
      </div>
      <div class="row">
        <div class="large-4 medium-4 columns">
            <div class="primary callout">
              <label>Rental Fee</label>
              <input type="text" placeholder="Amount" name="Fee"/>
            </div>
        </div>
        <div class="large-4 medium-4 columns">
            <div class="primary callout">
              <label>Size</label>
              <input type="text" placeholder="Size" name="Size"/>
            </div>
        </div>
        <div class="large-4 medium-4 columns">
            <div class="primary callout">
              <label>Capacity</label>
              <input type="text" placeholder="Capacity" name="Capacity"/>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="large-2 columns">
          <div class="primary callout">
            <label>Restroom</label>
            <input type="radio" name="Restroom" value="1" id="restroomYes"><label for="restroomYes">Yes</label>
            <input type="radio" name="Restroom" value="0" id="restroomNo"><label for="restroomNo">No</label>
          </div>
        </div>
        <div class="large-2 columns">
          <div class="primary callout">
            <label>Projector</label>
            <input type="radio" name="Projector" value="1" id="projectorYes"><label for="projectorYes">Yes</label>
            <input type="radio" name="Projector" value="0" id="projectorNo"><label for="projectorNo">No</label>
          </div>
        </div>
        <div class="large-2 columns">
          <div class="primary callout">
            <label>Kitchen</label>
            <input type="radio" name="Kitchen" value="1" id="kitchenYes"><label for="kitchenYes">Yes</label>
            <input type="radio" name="Kitchen" value="0" id="kitchenNo"><label for="kitchenNo">No</label>
          </div>
        </div>
        <div class="large-6 medium-4 columns">
          <div class="primary callout">
            <label>Adjacent Room</label>
            <select name="AdjacentRoom"/>
            <option value="None" selected>None</option>
            <?php
            while ($row = mysqli_fetch_array($adjvenueresult, MYSQLI_ASSOC)) {
              echo "<option value=\"".$row['RoomName']."\">".$row['RoomName']."</option>";
            }
            ?>
            </select>
        </div>
      </div>
      <div class="small-6 large-2 columns">
          <input type=hidden name=venue_submitted value=true>
          <input name="submit" type="submit" class="button expand">
      </div>                
    </div>
  </form>
</div>
</div>
