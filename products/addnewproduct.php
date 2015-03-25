<?php 
session_start();
include('../includes/config.php');
include('../includes/header.php');
include('../includes/leftsidebar.php');
$myid=0;
?>
<?php 
	if(isset($_GET['id'])){
		$myid = $_GET['id'];
		$sql1 = "SELECT * FROM subscribe_sys_products WHERE product_id = '$myid'";
		$result1 = mysqli_query($conn, $sql1);
		$row_selected_record = mysqli_fetch_row($result1);
	}
	//echo $myid;
?>
<?php 
	if(isset($_POST['submit_button'])){
		$product_name = $_POST['product_name'];
		$product_description = $_POST['product_description'];
		$product_price =$_POST['product_price'];
		
		if(isset($_FILES['product_pic'])){
			/*echo '<pre> ';
			print_r( $_FILES['product_pic']);
			echo '</pre>';
			exit;*/
			$product_pic_name = $_FILES['product_pic']['name'];
			$product_pic_tmp_name = $_FILES['product_pic']['tmp_name'];
			//echo $product_pic_tmp_name;
			$product_pic_type = $_FILES['product_pic']['type'];
			$product_pic_size = $_FILES['product_pic']['size'];
			
			$save_product_pic_path = "../../uploads/products/";
			
			if(!empty($_FILES['product_pic']['name'])){
			
			// Adding Timestamp to image name such as Tulip_9930003999.jpeg
				$path_parts = pathinfo($product_pic_name);
				$new_product_pic_name= $path_parts['filename'].'_'.time().'.'.$path_parts['extension'];
				
			// Validation for Type of file 	
				$allowed =  array('gif','png', 'jpg');
				//$ext = substring($product_pic_name, strpos($product_pic_name, '.'));
				$ext = pathinfo($product_pic_name, PATHINFO_EXTENSION);
				if(!in_array($ext,$allowed) ) {
				 echo 'ERROR !!!! Please select correct file type ';
			   }
		   
			// Validation for Size of file 	   
				if($product_pic_size < 900000){
				move_uploaded_file($product_pic_tmp_name, $save_product_pic_path . $new_product_pic_name );
				}else{
					echo "Enter file having small size";	
				} 
			}//end of if(!empty($_FILES['product_pic']['name']))
			else{
				$new_product_pic_name='NULL';
			}
				
		}//end of if(isset($_FILES['product_pic']))
		
		//echo "hi $myid hi";
		//echo $_POST['hid_id'];
		//echo $_GET['id'];
		//exit;
		if(!empty($_POST['hid_id'])){
			//echo "hi";
			//$id = $_GET['id'];
			// This if statement is for inserting product_pic into db while editing because by default No file is selected. 
			$my_id = $_POST['hid_id'];
			//echo $my_id;
			$sql2 = "SELECT * FROM subscribe_sys_products WHERE product_id = '$my_id'";
			//echo $sql2;
			$result2 = mysqli_query($conn, $sql2);
			$row_selected_record2 = mysqli_fetch_row($result2);
			//echo $row_selected_record2[4];
			if($product_pic_tmp_name==''){
			
				$new_product_pic_name=$row_selected_record2[4];
			}
			$sql = "UPDATE subscribe_sys_products SET product_name='$product_name', product_description='$product_description', product_price='$product_price', product_pic='$new_product_pic_name' WHERE product_id='$my_id'";
			//echo $sql;
			//exit;
		}//end of if(isset($_POST['hid_id'])){
		else{
			//echo "hello";

			$sql = "INSERT INTO subscribe_sys_products(product_name, product_description, product_price, product_pic) VALUES('$product_name','$product_description','$product_price', '$new_product_pic_name')";
		}
		$result = mysqli_query($conn,$sql);
		echo "<script>
window.location.href='viewallproducts.php';
</script>";
		//header("Location:viewallproducts.php");
		
	}//end of if(isset($_POST['submit_button']))
	
	

?>

<div class="col-md-4"></div>
<div class="col-md-5">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">Add Product</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form role="form" action="addnewproduct.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Product Name <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter ..." value="<?php if(isset($_GET['id'])){ echo $row_selected_record[1];}?>"/>
											<small class="errfn1" id="errfn1" style="color:#FF0000;"></small>
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Product Description</label>
                                            <textarea class="form-control" rows="3" name="product_description" placeholder="Enter ..."><?php if(isset($_GET['id'])){ echo $row_selected_record[2];}?></textarea>
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label>Product Price <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter ..." value="<?php if(isset($_GET['id'])){ echo $row_selected_record[3];}?>"/>
											<small class="errfn2" id="errfn2" style="color:#FF0000;"></small>
                                        </div><!-- /.form-group -->
										<div class="form-group">
                                            <label for="exampleInputFile">Product Pic</label>
                                            <?php if(isset($_GET['id'])){?> <img width=200 src="<?php echo "../../uploads/products/".$row_selected_record[4]; ?>"/><?php }?><input type="file" id="exampleInputFile"name="product_pic">
                                        </div>
										<div><input type="hidden" name="hid_id" id="hid_id" <?php if(isset($_GET['id'])){?> value="<?php echo $_GET['id'];?>" <?php }?>/></div>
										<div class="box-footer">
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
	if(document.getElementById('product_name').value == ""){
		document.getElementById('errfn1').innerHTML="Please enter product name";
		ok = false;
	}else{
		document.getElementById('errfn1').innerHTML="";
	}
	
	if(document.getElementById('product_price').value == ""){
		document.getElementById('errfn2').innerHTML="Please enter price";
		ok = false;
	}else{
		document.getElementById('errfn2').innerHTML="";
	}
	//alert(ok); 
	return ok;
}
</script>	
<?php include('../includes/footer.php'); ?>