<?php 
session_start();
include('../includes/config.php');
include('../includes/header.php');
include('../includes/leftsidebar.php');
?>
<?php 
$individual_quantity = 0;
	if(isset($_POST['submit_button'])){
		//here we are setting product_id to value of product_name
		$product_id = $_POST['product'];
		$sql4 = "SELECT product_price FROM subscribe_sys_products WHERE product_id='$product_id'";
		$result4 = mysqli_query($conn,$sql4);
		$row4 = mysqli_fetch_row($result4);
		$product_price = $row4[0];
		
		//$user_ids will be an array of user ids.
		if(!empty($_POST['status'])){
				$user_ids = $_POST['status'];
				$userids='';
				$count = count($user_ids);
				for($i=0;$i<$count;$i++){
					$individual_id=$user_ids[$i];
					//echo "individualid=$individual_id<br/>";
					$userids.="$individual_id";
					if($i!=($count-1)){
						$userids.= ',';
					}
					//echo $userids.'<br />';
				}
				
				//echo "$userids<br />";
				
			
			//$individual_quantity will be an quantity of selected user.
			if(isset($_POST['status'])){
				$user_ids = $_POST['status'];
				//$quantity = $_POST['quantity'];
				$userwithquantitystr='';
				//echo $count = count($user_ids);
				//echo " ".count($user_ids);
				for($i=0;$i<count($user_ids);$i++){
					$individual_id=$user_ids[$i];
					$qty_var = "qty_".$individual_id;
					//print_r($_POST);
					$individual_quantity=$_POST[$qty_var];
					//echo "individualqty=$individual_quantity<br/>";
					$userwithquantitystr.="$individual_id:$individual_quantity";
					if($i!=($count-1)){
						$userwithquantitystr.= ',';
					}
					//echo $userwithquantitystr.'<br />';
				}
				//echo $userwithquantitystr.'<br />';
			}
			
			if(isset($_POST['date-range'])){
			
				$daterange = $_POST['date-range'];
				$mydate = explode('-',$daterange);
				
				$mydate1 = explode('/',$mydate[0]);
				$dd1 = $mydate1[0];
				$mm1 = $mydate1[1];
				$yy1 = $mydate1[2];
				
				$mydate2 = explode('/',$mydate[1]);
				$dd2 = $mydate2[0];
				$mm2 = $mydate2[1];
				$yy2 = $mydate2[2];
				
				$stdt="$dd1-$mm1-$yy1";
				$endt="$dd2-$mm2-$yy2";
				date_default_timezone_set("Asia/Bangkok");
				$time1 = strtotime($stdt);
				$time2 = strtotime($endt);
				
				$datediff = $time2 - $time1;
				$tot_days = floor($datediff/(60*60*24));
				
				$start_date = new DateTime($stdt);
				$end_date = new DateTime($endt);
			
				//$diff=date_diff($start_date,$end_date);
				//echo "Difference is: ".$diff->d."<br/>";
				//echo $diff->format('%a');
				//print_r($diff);
				//exit;
				//$diff = $diff->d;
				for($j=0; $j<=$tot_days; $j++){
					$insert_date = date_format($start_date, 'Y-m-d');
					date_modify($start_date, '+1 day');
					//date_add($start_date,date_interval_create_from_date_string("1 day"));
					//echo $insert_date;
					//Check if orderdate is present already for a product.  
					$sql3 = "SELECT order_date, product_id, user_ids, quantity FROM subscribe_sys_orders WHERE order_date='$insert_date' && product_id='$product_id'";
					$result3 = mysqli_query($conn,$sql3);
					$row3 = mysqli_fetch_row($result3);
					/*echo "<pre>";
					print_r($row3);
					echo "</pre>";*/
					$rec_count = mysqli_num_rows($result3);
					//echo $rec_count;
					if($rec_count==0){
						$sql = "INSERT INTO subscribe_sys_orders(product_id, product_price, user_ids, quantity, order_date)VALUES('$product_id','$product_price','$userids','$userwithquantitystr','$insert_date')";
						$result = mysqli_query($conn,$sql);
					
					}else{
						//echo "order date is already present for this product<br/>";
			//So check next condition if user_id is already present in user_ids string.
						$curr_users = $row3[3];
						//print_r($curr_users);
						$curr_users_array = explode(",",$curr_users);
						//$user_ids = $_POST['status'];
						//print_r($curr_users_array);
	
						$tot_user_str = $curr_users;
						$all_user_str = $row3[2]; 
						//echo $tot_user_str."<br/>";
						//echo $all_user_str."<br/>";
						$user_ids = $_POST['status'];
						$count = count($user_ids);
						for($i=0;$i<$count;$i++){
							$individual_id=$user_ids[$i];
							$qty_var1 = "qty_".$individual_id;
							//$individual_quantity=$_POST[$qty_var];
							//echo "ST1 ".$string1 = $row3[2].'<br/>';
							//echo "ST2 ".$string2 = $row3[3].'<br/>';
							//print_r($_POST);
							$qty_var1 = strip_tags($qty_var1);
							$qty_v = $_POST[$qty_var1];
							//echo $_POST[$qty_var1];
						
							/*preg_match('/ .*$individual_id:.* /', $string2, $matches, PREG_OFFSET_CAPTURE);
							var_dump($matches).'<br/>';*/
							$srch_str = "$individual_id";
							//print_r($curr_users_array);
							//echo $srch_str."<br/>";
							//$input = preg_quote( $srch_str, ':~'); 
							//$pos = array_search($srch_str,$curr_users_array);
							//$pos = preg_filter('~' .$srch_str . '~', null, $curr_users_array);
							//$pos = preg_grep ("/^$srch_str(.)*/i", $curr_users_array);
							for($z=0;$z<count($curr_users_array);$z++){
								//echo $curr_users_array[$z];	
								$ind_elem = explode(":",$curr_users_array[$z]);
								//print_r($ind_elem);
								//echo "<br/>".$ind_elem[0];
								//echo "<br/>".$individual_id;
								if((int)$individual_id == (int)$ind_elem[0])
								{
									$pos = TRUE;
								}
								else{
									$pos = FALSE;
									if($z+1 == count($curr_users_array))
										{
											$qty_var1 = strip_tags($qty_var1);
											$qty_v = $_POST[$qty_var1];
											$non_existing_user = ",$individual_id:$qty_v";
											$non_existing_user = strip_tags($non_existing_user);
											$tot_user_str.= $non_existing_user;
											$tot_user_str=strip_tags($tot_user_str);
											$all_user_str.= ",$individual_id";
											$all_user_str=strip_tags($all_user_str);
											//echo $tot_user_str."<br/>";
									}
								}
								
								//echo "Pos = $pos 111111";
		
								if($pos === FALSE){
								//echo "Pos - False <br/>";
								//print_r($pos);
								//$tot_user_str.= $individual_id.":".$qty_v;
								//echo $tot_user_str."<br/>";
								}
								else{
									//echo "Pos - True <br/>";
									//print_r($pos);
									//$temparr= explode($curr_users_array[$pos],":");
									//extract($_POST);
									//echo $qty_var1;
									$qty_var1 = strip_tags($qty_var1);
									$individual_quantity = $_POST[$qty_var1];
									if($individual_quantity!=0){
				//						$newqty = $ind_elem[1] + $individual_quantity;
										$newqty = $individual_quantity;
									}else{
										$newqty =0;
									}
									$newusr = "$individual_id:$newqty";
									$newusr = strip_tags($newusr);
			//						str_replace('\n','',$newusr);
									//echo $newqty."<br/>";
									//echo $newusr."<br/>";
									//echo $tot_user_str."<br/>";
									$tot_user_str = str_replace(strip_tags($individual_id.":".$ind_elem[1]),$newusr,$tot_user_str);
									//$tot_user_str.= $individual_id.":".$qty_v;
									$tot_user_str."<br/>";
									break;
								}
		
							}				
					}
						
						$upd_sql = "UPDATE subscribe_sys_orders SET product_price='$product_price', user_ids = '$all_user_str', quantity = '$tot_user_str'  where product_id = '$product_id' and order_date = '$insert_date' ";
						//echo $upd_sql;
						$upd_result = mysqli_query($conn,$upd_sql);
						
					}//end of else
				}//end of for loop for date
			}//end of isset($_POST['date-range'])
		}//end of isset($_POST['status'])
		echo "<script>
window.location.href='viewallorders.php';
</script>";
	}//end of isset($_POST['submit_button'])
	

?>
<div class="col-md-4"></div>
<div class="col-md-5">
	<!-- general form elements disabled -->
    	<div class="box box-warning">
        	<div class="box-header">
            	<h3 class="box-title">Add order</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            	<form role="form" name="addneworder" method="post" action="addneworder.php">
					<!-- Date range -->
                    <div class="form-group">
                        		<label>Date Range <span style="color: red">*</span></label>
                                <div class="input-group">
                                	<div class="input-group-addon">
                                    	<i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservation1" name="date-range"/>
									<small class="errfn1" id="errfn1" style="color:#FF0000;"></small>
                                </div><!-- /.input group -->
                   </div><!-- /.form group -->
               	<div class="form-group">
                	<label>Product <span style="color: red">*</span></label>
					<select class="form-control" name="product" id="product">
							   <option value="Please select a product">Please select a product</option>
					<?php 
						$sql1 = "SELECT DISTINCT product_id, product_name FROM subscribe_sys_products ORDER BY product_name ASC";
						$result1 = mysqli_query($conn,$sql1);
						$i=1;
						while($row1=mysqli_fetch_assoc($result1)){?>
							<option value="<?php echo $row1['product_id']; ?>"><?php echo $row1['product_name']; ?></option>
					<?php $i++; }?>		
					</select>
					<small class="errfn2" id="errfn2" style="color:#FF0000;"></small>
                </div><!-- /.form group -->
				
				<div class="form-group">
                	<label>Area <span style="color: red">*</span></label>
                    <select class="form-control" id="area_name" name="area_name" onchange="run(this.value);">
                       <option value="Please select an area">Please select an area</option>
                       <?php 
						$sql2 = "SELECT DISTINCT area_name FROM subscribe_sys_areas ORDER BY area_name ASC";
						$result2 = mysqli_query($conn,$sql2);
						$j=1;
						while($row2=mysqli_fetch_assoc($result2)){?>
							<option value="<?php echo $row2['area_name']; ?>"><?php echo $row2['area_name']; ?></option>
					<?php $j++; }?>	
                    </select>
					<small class="errfn3" id="errfn3" style="color:#FF0000;"></small>
					
                </div><!-- /.form group -->
				<div class="hidden-list" id="hidden-list"></div><!-- /.hidden-list -->
										
				<div class="box-footer"><button class="btn btn-primary" name="submit_button" type="submit" onclick="return myfunction()">Submit</button>
				<small class="errorText" style="color:#CC0033;"><?php if(isset($_POST['submit_button']) && empty($_POST['status'])){ echo "Please select users and quantities."; }?></small>
</div>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /box box-warning -->
</div><!-- /.col-md-5-->
						
<div class="col-md-3"></div>
<script>

function CheckValue(txtbxid,chkbxid) {
document.getElementById(chkbxid).checked = true;
}


function run(str) {
  //alert(str);
  if (str=="") {
    document.getElementById("hidden-list").innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("hidden-list").innerHTML=xmlhttp.responseText;
    }
  }
 
  	var data1 = document.getElementById('area_name').value;
    //alert(data1);
   xmlhttp.open("POST","ajaxfileaddneworder.php",true);
   xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   xmlhttp.send("data=" + data1);
}


//Functoin is used to select or unselect all records
function checkedvalue()
{
	//alert("hi");
	var chkvalue=document.addneworder.elements['status[]'];
	var chkAllattop = document.getElementById('allaboveattop');
	if(chkvalue.tagName != 'INPUT'){
		var length = chkvalue.length;
		//alert(chkvalue);
		if ( chkAllattop.checked == true) 
		{  
			for ( i=0; i < length; i++ )
			{
				
				chkvalue[i].checked = true;
			}
		} 
			 else {
			  for ( i=0; i < length; i++ )
			   {
				chkvalue[i].checked = false;
			  }
			}
	
	}
	else{
		//alert('2');
		if ( chkAllattop.checked == true) 
		{ 
			//alert('hey') ;
			//alert(chkvalue);
			//alert(chkvalue.value);
			//alert(chkvalue.checked);
			
			chkvalue.checked=true;
		}
		else{
			chkvalue.checked=false;
		}
	}
 
}

function myfunction(){
	//alert('hi');
	//var ok = true;
	if(document.getElementById('reservation1').value == "" || document.getElementById('reservation1').value == "01/01/0000 - 01/01/0000" ){
		alert("Please enter a valid date range");
		//ok = false;
		return false;
	}
	//alert(document.getElementById('product').value);		 
	if(document.getElementById('product').value == "Please select a product"){
		//alert('1');
		//document.getElementById('errfn2').innerHTML="Please select a product";
		alert("Please select a product");
		//ok = false;
		return false;
	}

	if(document.getElementById('area_name').value == "Please select an area"){
		//alert('1');
		//document.getElementById('errfn3').innerHTML="Please select a area";
		alert("Please select an area");
		//ok = false;
		return false;
	}

	return true;
}
function myfunction1(){
	//alert('hi');
	var ok = true;
	if(document.getElementById('reservation1').value == ""){
		document.getElementById('errfn1').innerHTML="Please enter product name";
		ok = false;
	}else{
		document.getElementById('errfn1').innerHTML="";
	}
	
	if(document.getElementById('product').value == "Please select a product"){
		document.getElementById('errfn2').innerHTML="Please select a product";
		ok = false;
	}else{
		document.getElementById('errfn2').innerHTML="";
	}
	if(document.getElementById('area_name').value == "Please select an area"){
		document.getElementById('errfn3').innerHTML="Please select an area";
		ok = false;
	}else{
		document.getElementById('errfn3').innerHTML="";
	}
	alert(ok); 
	return ok;
}

</script>


<?php include('../includes/footer.php'); ?>