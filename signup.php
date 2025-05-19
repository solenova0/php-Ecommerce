<?php

  $customer = new customer();
  $res = $customer->single_customer($_SESSION['CUSID']);
?>  
<h3>Your Account</h3>
<form class="form-horizontal span6" action="customer/controller.php?action=edit" onsubmit="return personalInfo();" name="personal" method="POST" enctype="multipart/form-data"> 
  <div class="row">
    <div class="col-lg-6"> 
      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4 control-label" for="PHONE">Contact#:</label>
          <div class="col-md-8">
            <input class="form-control input-sm" id="PHONE" name="PHONE" placeholder="+251900000000" type="text" value="<?php echo htmlspecialchars($res->PHONE); ?>">
          </div>
        </div>
      </div> 
    </div> 

    <div class="col-lg-6">
      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4 control-label" for="CUSUNAME">Username:</label>
          <div class="col-md-8">
            <input class="form-control input-sm" id="CUSUNAME" name="CUSUNAME" placeholder="Username" type="text" value="<?php echo htmlspecialchars($res->CUSUNAME); ?>">
          </div>
        </div>
      </div> 
    </div>  

    <div class="col-lg-6">
      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4 control-label" for="GENDER">Gender:</label>
          <div class="col-lg-8"> 
            <?php
              $gender = isset($res->GENDER) ? $res->GENDER : 'Male';
            ?>
            <input id="GENDER" name="GENDER" type="radio" value="Male" <?php echo ($gender == 'Male') ? 'checked' : ''; ?> /> <b>Male</b>
            <input id="GENDER" name="GENDER" type="radio" value="Female" <?php echo ($gender == 'Female') ? 'checked' : ''; ?> /> <b>Female</b>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6"> 
      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4" align="right" for="btn"></label>
          <div class="col-md-8">
            <input type="submit" name="save" value="Save" class="submit btn btn-primary btn-lg" />
          </div>
        </div>
      </div>
    </div>     
  </div>
</form>