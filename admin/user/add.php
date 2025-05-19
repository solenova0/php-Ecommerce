<?php 
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}
?> 
<form class="form-horizontal span6" action="controller.php?action=add" method="POST">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add New User</h1>
        </div>
    </div> 

    <div class="form-group">
        <div class="col-md-8">
            <label class="col-md-4 control-label" for="U_NAME">Name:</label>
            <div class="col-md-8">
                <input name="deptid" type="hidden" value="">
                <input class="form-control input-sm" id="U_NAME" name="U_NAME" placeholder="Account Name" type="text" value="">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8">
            <label class="col-md-4 control-label" for="U_USERNAME">Username:</label>
            <div class="col-md-8">
                <input name="deptid" type="hidden" value="">
                <input class="form-control input-sm" id="U_USERNAME" name="U_USERNAME" placeholder="Email Address" type="text" value="">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8">
            <label class="col-md-4 control-label" for="U_PASS">Password:</label>
            <div class="col-md-8">
                <input name="deptid" type="hidden" value="">
                <input class="form-control input-sm" id="U_PASS" name="U_PASS" placeholder="Account Password" type="Password" value="" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8">
            <label class="col-md-4 control-label" for="U_ROLE">Role:</label>
            <div class="col-md-8">
                <select class="form-control input-sm" name="U_ROLE" id="U_ROLE">
                    <option value="Administrator">Administrator</option>
                    <option value="Staff">Staff</option>
                    <option value="Operator">Operator</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8">
            <label class="col-md-4 control-label" for="idno"></label>
            <div class="col-md-8">
                <button class="btn btn-primary btn-sm" name="save" type="submit">
                    <span class="fa fa-save fw-fa"></span> Save
                </button>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="rows">
            <div class="col-md-6">
                <label class="col-md-6 control-label" for="otherperson"></label>
                <div class="col-md-6"></div>
            </div>
            <div class="col-md-6" align="right"></div>
        </div>
    </div>
</form>