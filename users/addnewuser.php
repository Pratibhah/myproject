<?php 
session_start();
include('../includes/config.php');
include('../includes/header.php');
include('../includes/leftsidebar.php');
?>
<?php 
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$sql1 = "SELECT * FROM subscribe_sys_users WHERE user_id = '$id'";
		$result1 = mysqli_query($conn, $sql1);
		$row_selected_record = mysqli_fetch_row($result1);
	}
	//echo $myid;
?>
<?php 
	if(isset($_POST['submit_button'])){
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$spouse_name = $_POST['spouse_name'];
		//mb_convert_encoding($spouse_name, "UTF-8");
		$email_id = $_POST['email_id'];
		$mobile_no = $_POST['mobile_no'];
		$addr1 = $_POST['addr1'];
		$addr2 = $_POST['addr2'];
		if(isset($_POST['area_name'])){
			$area_name = $_POST['area_name'];
			$sql1 = "SELECT * FROM subscribe_sys_areas WHERE area_name='$area_name'";
			//echo $sql1;
			$result1 = mysqli_query($conn, $sql1);
			$row1 = mysqli_fetch_row($result1);
			$area_id = $row1[0];
		}

			$city = $_POST['city'];
			$post_code =$_POST['post_code'];
			if(isset($_POST['status'])){
				$status = $_POST['status'];
			}else{
				$status = 'active';
			}
			
			if(!empty($_POST['hid_id'])){
				$myid = $_POST['hid_id'];
				$sql2 = "UPDATE subscribe_sys_users SET first_name='$first_name', last_name='$last_name', spouse_name='$spouse_name', email_id='$email_id', mobile_no='$mobile_no', addr1='$addr1', addr2='$addr2', area_id='$area_id', city='$city', post_code='$post_code', status='$status' WHERE user_id='$myid' ";
			
			}else{
		
				$sql2 = "INSERT INTO subscribe_sys_users(first_name, last_name, spouse_name, email_id, mobile_no, addr1, addr2, area_id, city, post_code, status) VALUES('$first_name','$last_name', '$spouse_name', '$email_id','$mobile_no','$addr1','$addr2','$area_id','$city','$post_code','$status')"; 
			}
			$result2 = mysqli_query($conn,$sql2);
			echo "<script>
window.location.href='viewallusers.php';
</script>";
			//header("Location:viewallusers.php");
			
	}
?>

<div class="col-md-4"></div>
<div class="col-md-5">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">Add User</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form role="form" action="addnewuser.php" method="post">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>First Name <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter ..." <?php if(isset($_GET['id'])){?> value="<?php echo $row_selected_record[1]; ?>" <?php }?>/>
											<small class="errfn1" id="errfn1" style="color:#FF0000;"></small>
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Last Name <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter ..." <?php if(isset($_GET['id'])){?> value="<?php echo $row_selected_record[2]; ?>" <?php }?> />
											<small class="errfn2" id="errfn2" style="color:#FF0000;"></small>
										</div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Spouse Name</label>
                                            <input type="text" class="form-control" name="spouse_name" placeholder="Enter ..." <?php if(isset($_GET['id'])){?> value="<?php echo $row_selected_record[3]; ?>" <?php }?> />	
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Email Id</label>
                                            <input type="text" class="form-control" name="email_id" placeholder="Enter ..." <?php if(isset($_GET['id'])){?> value="<?php echo $row_selected_record[4]; ?>" <?php }?> />
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Mobile No <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter ..." <?php if(isset($_GET['id'])){?> value="<?php echo $row_selected_record[5]; ?>" <?php }?> />
											<small class="errfn3" id="errfn3" style="color:#FF0000;"></small>
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Address line1 <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="addr1" id="addr1" placeholder="Enter ..." <?php if(isset($_GET['id'])){?> value="<?php echo $row_selected_record[6]; ?>" <?php }?> />
											<small class="errfn4" id="errfn4" style="color:#FF0000;"></small>
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Address line2</label>
                                            <input type="text" class="form-control" name="addr2" placeholder="Enter ..." <?php if(isset($_GET['id'])){?> value="<?php echo $row_selected_record[7]; ?>" <?php }?> />
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Select Area <span style="color: red">*</span></label>
                                            <select class="form-control" name="area_name" id="area_name">
											<option value="select">Select an area</option>
	<?php 
		$sql = "SELECT * FROM subscribe_sys_areas";
		$result = mysqli_query($conn, $sql);
		$j=1;
		while($row=mysqli_fetch_assoc($result)){ ?>
										
                                                <option value="<?php echo $row['area_name']; ?>"<?php if(isset($_GET['id']) && $row_selected_record[8]==$row['area_id']){ echo 'selected="selected"'; } ?>><?php echo $row['area_name']; ?></option>
												
 <?php }?>                                               
                                            </select>
											<small class="errfn5" id="errfn5" style="color:#FF0000;"></small>
                                        </div>
										<div class="form-group">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="city" placeholder="Enter ..." <?php if(isset($_GET['id'])){?> value="<?php echo $row_selected_record[9]; ?>" <?php }?>/>
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Postcode</label>
                                            <input type="text" class="form-control" name="post_code" placeholder="Enter ..." <?php if(isset($_GET['id'])){?> value="<?php echo $row_selected_record[10]; ?>" <?php }?>/>
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Select status</label>
                                            <select class="form-control" name="status">
												<option value="">Select status</option>
                                                <option value="active" <?php if(isset($_GET['id']) && $row_selected_record[11]=='active'){echo 'selected="selected"';}?> >active</option>
												<option value="inactive"  <?php if(isset($_GET['id']) && $row_selected_record[11]=='inactive'){echo 'selected="selected"';}?> >inactive</option>
                                            </select>
                                        </div>
										<div><input type="hidden" name="hid_id" id="hid_id" <?php if(isset($_GET['id'])){?> value="<?php echo $_GET['id'];?>" <?php }?>/>
										</div>										<div class="box-footer">
<button class="btn btn-primary" type="submit" name="submit_button" onclick="return myfunction()">Submit</button>
</div>
									</form>
								</div><!-- /.box-body -->
							</div><!-- /box box-warning -->
</div>
						
<div class="col-md-3"></div>
<script>
			function myfunction(){
				 //alert('hi');
				 var ok = true;
				 if(document.getElementById('first_name').value == ""){
					 document.getElementById('errfn1').innerHTML="Please enter first name";
					 ok = false;
				 }else{
				 	document.getElementById('errfn1').innerHTML="";
				 }
				 if(document.getElementById('last_name').value == ""){
					 document.getElementById('errfn2').innerHTML="Please enter last name";
					 ok = false;
				 }else{
				 	document.getElementById('errfn2').innerHTML="";
				 }
				 
				 				 
				 if(document.getElementById('mobile_no').value == ""){
					 document.getElementById('errfn3').innerHTML="Please enter mobile no";
					 ok = false;
				 }else{
					 document.getElementById('errfn3').innerHTML="";
					 var y=document.getElementById('mobile_no').value;
					 if(isNaN(y))
			           {
						 document.getElementById('errfn3').innerHTML="Please enter numeric value";
			              ok = false; 
			           }
			           if (y.length>10 || y.length<10)
			           {
			        	   document.getElementById('errfn3').innerHTML="Please enter 10 digits";
			                ok = false;
			           }
				 }
				 if(document.getElementById('addr1').value == ""){
					 document.getElementById('errfn4').innerHTML="Please enter address";
					 ok = false;
				 }else{
				 	document.getElementById('errfn4').innerHTML="";
				 }
				 if(document.getElementById('area_name').value == "select"){
					 document.getElementById('errfn5').innerHTML="Please select an area";
					 ok = false;
				 }else{
				 	document.getElementById('errfn5').innerHTML="";
				}
				 
				 return ok;
			 }
</script>	
<?php include('../includes/footer.php'); ?>