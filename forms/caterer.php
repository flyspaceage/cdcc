<?php

require_once ('../../mysqli_connect.php');

  if ($_POST['caterer_submitted']){
    $ContactName=$_POST['ContactName'];
    $Business=$_POST['Business'];
    $Telephone=$_POST['Telephone'];
    $Email=$_POST['Email'];
    $Address=$_POST['Address'];
    $City=$_POST['City'];
    $State=$_POST['State'];
    $Zip=$_POST['Zip'];
    $CostPerPlate=$_POST['CostPerPlate'];
    $query="INSERT INTO CATERER (ContactName, Business, Telephone, Email, Address, City, State, Zip, CostPerPlate)
      VALUES ('$ContactName', '$Business', '$Telephone', '$Email', '$Address', '$City', '$State', '$Zip', '$CostPerPlate')";
    $result=@mysqli_query ($dbc, $query);
    if ($result) {
      echo "<div class='primary callout'><p><b>A new CATERER has been added.</b></p></div>";

    } else {
      echo "<div class='secondary callout'><p>The record could not be added due to a system error" . mysqli_error($dbc) . "</p></div>";
    }
    mysqli_close($dbc);
  } // only if submitted by the form
?>

<!-- CATERER SECTION -->

<div class="row">
  <div class="large-24 columns">
    <h3 id="newCaterer">Enter New Caterer</h3></div>
</div> 
<div class="row">
  <div class="large-12 medium-8 columns">
    <h5>Please fill in all relevant information:</h5>
    <hr />          
    <h5>Caterer ~ Contact | Business | Telephone | Email | Address | City | State | Zip | Menu | Cost</h5>
    <form id="caterer" action="<?php echo $PHP_SELF;?>" method="post" name="caterer">
      <div class="row">
        <div class="large-4 medium-4 columns">
            <div class="primary callout">
              <label>Organization</label>
              <input type="text" placeholder="Business Name" name="Business"/>
            </div>
        </div>
        <div class="large-4 medium-4 columns">
            <div class="primary callout">
              <label>Name</label>
              <input type="text" placeholder="Full Name" name="ContactName"/>
            </div>
        </div>
        <div class="large-4 medium-4 columns">
            <div class="primary callout">
              <label>Email Address</label>
              <input type="text" placeholder="first.last@gmail.com" name="Email"/>
            </div>
        </div>
      </div>
       <div class="row">
        <div class="large-12 columns">
          <div class="primary callout">
            <label>Address</label>
            <input type="text" placeholder="Address" name="Address"/></div>
        </div>
      </div>
      <div class="row">
        <div class="large-4 medium-4 columns">
            <div class="primary callout">
              <label>City</label>
              <input type="text" placeholder="City" name="City"/>
            </div>
        </div>
        <div class="large-2 medium-4 columns">
            <div class="primary callout">
              <label>State</label>
              <input type="text" placeholder="State" name="State"/>
            </div>
        </div>
        <div class="large-2 medium-4 columns">
            <div class="primary callout">
              <label>Zip Code</label>
              <input type="text" placeholder="Zip Code" name="Zip"/>
            </div>
        </div>
        <div class="large-4 medium-4 columns">
          <div class="primary callout">
            <label>Telephone</label>
            <input type="text" placeholder="Phone Number" name="Telephone"/></div>
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
            <input type="text" placeholder="Amount per Person" name="CostPerPlate" id="CostPerPlate" /></div>
          </div>
        </div>
        <div class="small-6 large-2 columns">
          <input type=hidden name=caterer_submitted value=true>
          <input name="submit" type="submit" class="button expand">
      </div>                
    </form>
  </div>
</div>
