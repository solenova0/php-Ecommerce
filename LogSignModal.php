<!-- Sign Up / Login Modal -->
<div class="modal fade" id="smyModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"></div>
      <div class="modal-body">
        <!-- Nav tabs -->
        <ul class="nav nav-pills">
          <li class="active">
            <a class="btn btn-default check_out" href="#home" data-toggle="tab">Login</a>
          </li>
          <li>
            <a class="btn btn-default check_out" href="#profile" data-toggle="tab">Sign Up</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Login Panel -->
          <div class="tab-pane fade in active" id="home">
            <div class="panel panel-pup">
              <div class="panel-heading">Login Details</div>
              <div class="panel-body">
                <form class="form-horizontal span6" action="login.php" method="POST" autocomplete="off">
                  <input class="proid" type="hidden" name="proid" id="proid" value="">
                  <div class="form-group">
                    <div class="col-md-10">
                      <label class="col-md-4 control-label" for="U_USERNAME">Username:</label>
                      <div class="col-md-8">
                        <input id="U_USERNAME" name="U_USERNAME" placeholder="Username" type="text" class="form-control input-sm" required autocomplete="username">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10">
                      <label class="col-md-4 control-label" for="U_PASS">Password:</label>
                      <div class="col-md-8">
                        <input name="U_PASS" id="U_PASS" placeholder="Password" type="password" class="form-control input-sm" required autocomplete="current-password">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10">
                      <div class="col-md-8 col-md-offset-4">
                        <button type="submit" id="modalLogin" name="modalLogin" class="btn btn-pup">
                          <span class="glyphicon glyphicon-log-in"></span> Login
                        </button>
                        <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- End Login Panel -->

          <!-- Sign Up Panel -->
          <div class="tab-pane fade" id="profile">
            <form class="form-horizontal span6" action="customer/controller.php?action=add" onsubmit="return personalInfo();" name="personal" method="POST" enctype="multipart/form-data" autocomplete="off">
              <div class="panel panel-pup">
                <div class="panel-heading">Customer Details</div>
                <div class="panel-body">
                  <input class="proid" type="hidden" name="proid" id="proid" value="">
                  <div class="form-group">
                    <div class="col-md-10">
                      <label class="col-md-4 control-label" for="FNAME">First Name:</label>
                      <div class="col-md-8">
                        <input class="form-control input-sm" id="FNAME" name="FNAME" placeholder="First Name" type="text" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10">
                      <label class="col-md-4 control-label" for="LNAME">Last Name:</label>
                      <div class="col-md-8">
                        <input class="form-control input-sm" id="LNAME" name="LNAME" placeholder="Last Name" type="text" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10">
                      <label class="col-md-4 control-label" for="GENDER">Gender:</label>
                      <div class="col-md-8">
                        <label><input id="GENDER_MALE" name="GENDER" type="radio" value="Male"> Male</label>
                        <label><input id="GENDER_FEMALE" name="GENDER" type="radio" value="Female"> Female</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10">
                      <label class="col-md-4 control-label" for="CITYADD">City:</label>
                      <div class="col-md-8">
                        <input class="form-control input-sm" id="CITYADD" name="CITYADD" placeholder="City Address" type="text" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10">
                      <label class="col-md-4 control-label" for="CUSUNAME">Username:</label>
                      <div class="col-md-8">
                        <input class="form-control input-sm" id="CUSUNAME" name="CUSUNAME" placeholder="Username" type="text" required autocomplete="username">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10">
                      <label class="col-md-4 control-label" for="CUSPASS">Password:</label>
                      <div class="col-md-8">
                        <input class="form-control input-sm" id="CUSPASS" name="CUSPASS" placeholder="Password" type="password" required autocomplete="new-password">
                        <span></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10">
                      <div class="col-md-8 col-md-offset-4">
                        <p>Note: Password must be 8-15 characters. Only letters, digits, underscores. First character must be a letter.</p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10">
                      <label class="col-md-4 control-label" for="PHONE">Contact Number:</label>
                      <div class="col-md-8">
                        <input class="form-control input-sm" id="PHONE" name="PHONE" placeholder="+251900000000 or 0900000000" type="tel" pattern="^(\+2519[0-9]{8}|09[0-9]{8})$">
                      </div>
                    </div>
                  </div>
                  <!-- Agreement section removed -->
                  <div class="form-group">
                    <div class="col-md-10">
                      <div class="col-md-8 col-md-offset-4">
                        <input type="submit" name="submit" value="Sign Up" class="submit btn btn-pup">
                        <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- End Sign Up Panel -->
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- end sign up modal -->

<script type="text/javascript">
function OpenPopupCenter(pageURL, title, w, h) {
    var left = (screen.width - w) / 2;
    var top = (screen.height - h) / 4;
    window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}
</script>