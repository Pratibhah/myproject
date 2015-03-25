<?php 
include('../includes/config.php');

?>
<p style="color:#CC0066">Please select users and quantities before submit unless all operations won't be done.</p>	
<?php 
		$area = $_POST['data'];
		//echo $area;
		$sql3 = "SELECT subscribe_sys_users.user_id, subscribe_sys_users.first_name, subscribe_sys_users.last_name, subscribe_sys_users.status, subscribe_sys_areas.area_name FROM subscribe_sys_users, subscribe_sys_areas WHERE subscribe_sys_users.area_id=subscribe_sys_areas.area_id && area_name='$area' && subscribe_sys_users.status='active'";
		$result3 = mysqli_query($conn,$sql3);
		/*echo "<pre>";
		print_r($result3);
		echo "</pre>";*/
		$count=mysqli_num_rows($result3);
		if($count!=0){?>
			<div class="form-group">
				<div class="checkbox">
					<div style="margin-left:20px; width:150px;float:left">
			<input id="allaboveattop" type="checkbox" onClick="return checkedvalue()" value="all" name="allaboveattop" />Select all
					</div>
					<div style="float:left">Quantity</div>
				</div>
			</div>
			<?php $j=1;
			while($row3=mysqli_fetch_assoc($result3)){?>
				<div class="form-group">
					<div class="checkbox">
						<div style="margin-left:20px; width:150px;float:left"><input type="checkbox" id="chk_<?php echo $row3['user_id']?>" name="status[]" value="<?php echo $row3['user_id']?>"/><?php echo $row3['first_name'].' '.$row3['last_name']; ?>
						</div>
						<div style="float:left"><input type="text" size="5" id="qty_<?php echo $row3['user_id']?>" name="qty_<?php echo $row3['user_id']?>" onclick="CheckValue('qty_<?php echo $row3['user_id']?>','chk_<?php echo $row3['user_id']?>')" value="1"/>
						</div>
					</div><!-- name="quantity[]" /.checkbox -->	
				</div><!-- /.form group -->	
						
	<?php 
			$j++; }
			
		}	
	?>

