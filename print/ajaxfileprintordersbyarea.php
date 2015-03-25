<?php 
session_start();
include('../includes/config.php');
?>
<?php 
	$area_id = $_POST['area_id'];
	//echo $area_id;
	$area_name = $_POST['area_name'];
	$daterange = $_POST['daterange'];

?>
<div class="row">
	<div class="col-xs-12">
    	<div class="box">
        	<div class="box-header1">
				<h3 class="box-title">Area-wise Summary Sheet of <span id="area_name" style="color:#CC0000"><?php echo $area_name;?></span> for date-range <span id="daterange" style="color:#CC0000"><?php echo $daterange;?></h3></span>
            </div><!-- /.box-header -->
        	<div class="box-body table-responsive no-padding">
            	<table class="table table-hover">
                	<tr>
                    	<!--<th>ID</th>-->
			<?php	if($area_id=='viewallarea'){?>
						<th>Area Name</th>
			<?php   } ?>
                        <th>User</th>
                        <th>Address</th>
                        <th>Products(Quantity)</th>
				
						
                    </tr>
                                        
<?php 

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
		//$user_quantity='';
		for($j=0; $j<=$tot_days; $j++){
			$insert_date = date_format($start_date, 'Y-m-d');
			//echo $insert_date."<br/>";
			date_modify($start_date, '+1 day');
			//date_add($start_date,date_interval_create_from_date_string("1 day"));
			if($area_id=='viewallarea'){
				$sql = "SELECT o.order_date, o.user_ids, o.quantity, p.product_name, u.user_id, u.first_name, u.last_name, u.addr1, u.addr2, u.city, u.post_code, a.area_name FROM subscribe_sys_orders o, subscribe_sys_products p,  subscribe_sys_users u, subscribe_sys_areas a WHERE  (u.area_id=a.area_id) && (o.order_date='$insert_date') && (o.product_id=p.product_id) ORDER BY a.area_name, u.user_id ASC ";
			}else{
				$sql = "SELECT o.order_date, o.user_ids, o.quantity, p.product_name, u.user_id, u.first_name, u.last_name, u.addr1, u.addr2, u.city, u.post_code, a.area_name FROM subscribe_sys_orders o, subscribe_sys_products p,  subscribe_sys_users u, subscribe_sys_areas a WHERE (u.area_id='$area_id') && (u.area_id=a.area_id) && (o.order_date='$insert_date') && (o.product_id=p.product_id) order by u.user_id asc";
			}
			//echo $sql;
			$result = mysqli_query($conn,$sql);
			/*$row = mysqli_fetch_assoc($result);
			echo '<pre>';
			print_r($row);
			echo '</pre>';*/
			$k=1;
			$tempDate="";
			$temp_user_id='';
			//$firstrow=0;
			?>
                           
			<?php 
			while($row = mysqli_fetch_assoc($result)){
				//echo 'area'.$row['area_name'];
				
				$originalDate = $row['order_date'];
				if($tempDate==''||$tempDate!=$originalDate){?>
					<tr>
						<td colspan="4" align="center">
						<div style="color:#CC0000;font-weight:bold">Date : 
					<?php 
						$newDate = date("d-m-Y", strtotime($originalDate));
						echo $newDate; 
					?>
						</div>
						</td>
					</tr>
					<?php }
						//$tempDate = $originalDate;
						/*echo "<pre>";
						print_r($row3);
						echo "</pre>"; */
						$curr_users = $row['quantity'];
						$curr_users_ids = $row['user_ids'];
					/*		$oldusr_id = "";
						$oldusr_id_qty = "";
					*/
						
						$curr_users_array = explode(',',$curr_users);
						/*echo "<pre>";
						print_r($curr_users_array);
						echo "</pre>";*/
						for($i=0;$i<count($curr_users_array);$i++){
							$user_id =$row['user_id'];
							$product_name = $row['product_name'];  
							$full_name = $row['first_name'].' '.$row['last_name'] ;
							$full_addr = $row['addr1'].', '.$row['addr2'].', '. $row['area_name'].', '.$row['city'].'- '.$row['post_code']; 
							$individual_area = $row['area_name'];
									
							$ind_elem = explode(':',$curr_users_array[$i]); 
							/*echo "<pre>";
							print_r($ind_elem);
							echo "</pre>";*/
							if($ind_elem[0]==$row['user_id']){
								$individual_id = $ind_elem[0];
								$user_quantity = $ind_elem[1];
								
								if($temp_user_id=='' || $temp_user_id!=$user_id){
								//$firstrow=1;
								//echo $temp_user_id.' '.$user_id.'-----';
								?>								
								<tr>
									<?php if($area_id=='viewallarea'){?>
									<td style="color:#CC0000;"><?php echo $individual_area;?></td>
								<?php } ?>
                                	
                                    <td><?php echo $full_name;?></td>
                                    <td><?php echo $full_addr;?></td>
									<td><?php echo $product_name.'('.$user_quantity.')';?>
									
							<?php 
								}else{
									echo $product_name.'('.$user_quantity.')';
									if($temp_user_id!=$user_id){
							?>
									</td>
									
									</tr>
						  <?php 	}?>
									  
					<?php 	  }  ?>	
						 
<?php
//								if(($temp_user_id!='' || $temp_user_id!=$user_id)  && ($temp_product_name!='' || $temp_product_name!=$product_name)){
	//									echo $user_id.' '.$full_name.' '.$full_addr.' '.$product_name.' '.$user_quantity.'<br/>';
//								}
								$temp_user_id = $user_id;// $user_id shold be stored inside for loop
							}
						}
				$tempDate = $originalDate;//$originalDate should be stored inside while loop.
				$k++;
			}//end of while loop
			
		}//end of for loop of days
	?>
	</table>
	 </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
	<?php
?>