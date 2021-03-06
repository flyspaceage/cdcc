<?php

require_once ('../../mysqli_connect.php');

  if ($_POST['customer_submitted']){

    $CustName = $_POST['CustName'];
    $Telephone = $_POST['Telephone'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $City = $_POST['City'];
    $State = $_POST['State'];
    $Zip = $_POST['Zip'];

    $query = "INSERT INTO CUSTOMER (CustName, Telephone, Email, Address, City, State, Zip)
      Values ('$CustName', '$Telephone', '$Email', '$Address', '$City', '$State', '$Zip')"; 
    
    $result = @mysqli_query ($dbc, $query); 
    
    if ($result) {
      echo "<div class='primary callout'><p><b>A new CUSTOMER has been added.</b></p></div>";

    } else {
      echo "<div class='secondary callout'><p>The record could not be added due to a system error" . mysqli_error($dbc) . "</p></div>";
    }
    mysqli_close($dbc);
  } // only if submitted by the form


?>

<!-- CUSTOMER SECTION -->

<div class="wrap row">
<div class="large-24 columns">
  <h3 id="newCustomer">Enter New Customer</h3>  
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
              <input type="text" placeholder="Full Name" name="CustName" id="CustName"/>
            </div>
        </div>
        <div class="large-4 medium-4 columns">
            <div class="primary callout">
            <label>Address</label>
            <input type="text" placeholder="Address" name="Address"/>
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
            <input type="text" placeholder="Phone Number" name="Telephone"/>
        </div>
      </div>
      <div class="small-6 large-2 columns">
        <input type=hidden name=customer_submitted value=true>
        <input name="submit" type="submit" class="button expand">
      </div>
    </form>
  </div>
</div> 
<br />
<hr />
<br />