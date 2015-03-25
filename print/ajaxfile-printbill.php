<?php
session_start(); 
include('../includes/config.php');

?>
<p style="color:#CC0066">Please select users before submit unless all operations won't be done.</p>
<div class="form-group">
				<div class="checkbox">
					<div style="margin-left:20px; width:150px;float:left">
			<input id="allaboveattop" type="checkbox" onClick="return checkedvalue()" value="all" name="allaboveattop" />Select all
					</div>
					<div style="float:left">Total Amount</div>
				</div>
</div>	
<?php 
		$daterange = $_POST['data'];
		//echo $daterange;
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
		//echo $tot_days;		
		$start_date = new DateTime($stdt);
		$end_date = new DateTime($endt);
		
		$temp_date = '';
		$users_qty_array = array();
		for($j=0; $j<=$tot_days; $j++){
			$insert_date = date_format($start_date, 'Y-m-d');
			//echo $insert_date."<br/>";
			date_modify($start_date, '+1 day');
		$sql3 = "SELECT subscribe_sys_users.user_id, subscribe_sys_users.first_name, subscribe_sys_users.last_name, subscribe_sys_users.status,subscribe_sys_users.addr1, subscribe_sys_users.addr2, subscribe_sys_users.city, subscribe_sys_users.post_code, subscribe_sys_areas.area_name, subscribe_sys_orders.product_id, subscribe_sys_orders.product_price, subscribe_sys_orders.quantity, subscribe_sys_orders.order_date, subscribe_sys_products.product_name
FROM subscribe_sys_users, subscribe_sys_areas, subscribe_sys_orders, subscribe_sys_products
WHERE subscribe_sys_users.area_id = subscribe_sys_areas.area_id &&   subscribe_sys_users.status = 'active' && subscribe_sys_orders.product_id=subscribe_sys_products.product_id && subscribe_sys_orders.order_date='$insert_date'
ORDER BY subscribe_sys_users.first_name";
		//echo $sql3;
		$result3 = mysqli_query($conn,$sql3);
		
	 	$i=1;
		$temp_user_id = '';
		$tot_price = 0;
		$tot_pr=0;
		while($row3=mysqli_fetch_assoc($result3)){?>
		<?php 
				$name = $row3['first_name'].' '.$row3['last_name'];
				$address = $row3['addr1'].' '.$row3['addr2'].' '.$row3['area_name'].' '.$row3['city'].' '.$row3['post_code'];
				$user_id = $row3['user_id'];
				$product_id = $row3['product_id'];
				$product_name = $row3['product_name'];
				$product_price = $row3['product_price']; 
				$order_date = $row3['order_date'];
				$curr_users = $row3['quantity'];
				$curr_users_ids = $row3['user_id'];
				$curr_users_array = explode(',',$curr_users);
				/*if(($user_id!=$temp_user_id) && ($temp_date != $insert_date) &&($temp_date == '')){
					//echo "$name:$user_id";
					$product_quantity = 0;
					$tot_price = 0;
				}*/
				$temp_user_id = $user_id;
				for($i=0;$i<count($curr_users_array);$i++){
					$ind_elem = explode(':',$curr_users_array[$i]); 
					$individual_id = $ind_elem[0];
					$user_quantity = $ind_elem[1];
					if($user_id==$individual_id){
						//echo "&&&";
						//echo "<br/>User-qty ".$user_quantity."<br/>";
//						echo $user_quantity;
						if(isset($users_qty_array["$name:$address"]["$product_name"]))
						{
							$users_qty_array["$name:$address"]["$product_name"]+=$user_quantity;
							$users_qty_array["$name:$address"]["price_$product_name"]+=$user_quantity*$product_price;
$users_qty_array["$name:$address"]["total"]+=$user_quantity*$product_price;
						}
				
						else{
							$users_qty_array["$name:$address"]["$product_name"]=$user_quantity;
							$users_qty_array["$name:$address"]["price_$product_name"]=$user_quantity*$product_price;
							if(isset($users_qty_array["$name:$address"]["total"])){
								$users_qty_array["$name:$address"]["total"]+= $users_qty_array["$name:$address"]["price_$product_name"];
							}else{
								$users_qty_array["$name:$address"]["total"] = $users_qty_array["$name:$address"]["price_$product_name"];

							}							
							
						}	
					}
					
				}
				$i++; 
			}//end of while
			/*echo "<pre>";
			print_r($users_qty_array);
			echo "<pre>";*/
			$temp_date = $insert_date;
		}//for loop for no of days	
			//	Send necessary data to printbill.php in SESSION variable to avoid rewriting SELECT query. 
			$_SESSION['final_array']=$users_qty_array;
/*			echo "<pre>";
			print_r($users_qty_array);
			echo "</pre>";
			echo count($users_qty_array);
*/
?>	
<?php
	//$l=0;
	
	/*for(;$l<count($users_qty_array);)
	{
	echo $l++;
	}
	exit;*/?>
<div class="form-group">
<?php	foreach ($users_qty_array as $out_keys => $out_values) {?>
			<div class="checkbox">
				<div style="margin-left:20px; width:150px;float:left"><input type="checkbox" id="chk_<?php echo $out_keys?>" name="status[]" value="<?php echo $out_keys?>"/>
				<?php 
					$name_addr_array = explode(':',$out_keys); 
					echo $name_addr_array[0];
				?>
				</div>
				<small class="label label-primary"><?php echo $out_values['total']; ?></small>
			</div><!-- name="quantity[]" /.checkbox -->	
<?php   
		}
	?>				
</div><!-- /.form group -->


	