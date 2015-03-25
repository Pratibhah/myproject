<?php 
session_start();
include('../includes/config.php');
include('../includes/header.php');
include('../includes/leftsidebar.php');

?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Tables
                        <small>advanced tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Tables</a></li>
                        <li class="active">Data tables</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">All Orders</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sr. no</th>
												<th>Order Date</th>
                                                <th>Order Id</th>
                                                <th>Product Name</th>
                                                <th>User Name(Quantity)</th>
												<th>Area(Quantity)</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
	<?php 
		$sql = "SELECT subscribe_sys_orders.order_id, subscribe_sys_orders.user_ids, subscribe_sys_orders.quantity, subscribe_sys_orders.order_date, subscribe_sys_products.product_name FROM subscribe_sys_orders, subscribe_sys_products WHERE subscribe_sys_orders.product_id= subscribe_sys_products.product_id ORDER BY subscribe_sys_orders.order_date desc";
		$result = mysqli_query($conn, $sql);
		$j=1;
		while($row=mysqli_fetch_assoc($result)){
	?>

                                            <tr>
                                                <td><?php echo $j; ?></td>
												<?php date_default_timezone_set("Asia/Bangkok");?>
												<td><?php echo date("d-m-Y", strtotime($row['order_date'])); ?></td>
                                                <td><?php echo $row['order_id']; ?></td>
                                                <td><?php echo $row['product_name']; ?></td>
												<td>
			<?php   
					$sql2 = "SELECT * FROM subscribe_sys_areas";
								$result2 = mysqli_query($conn,$sql2);
								$l=0;
								$areas = array();
								while($row2 = mysqli_fetch_assoc($result2)){
									$areas[$l] = array('areaid'=>$row2['area_id'],'areaname'=>$row2['area_name'],'quantity'=>0);
									$l++;
								}
								
									/*echo "<pre>";
									print_r($areas);
									echo "<pre>";*/
			
					$userid = explode(',',$row['user_ids']);
					$quantity = explode(',',$row['quantity']);
					
					for($i=0;$i<count($userid);$i++){
						for($k=0;$k<count($quantity);$k++){
							//echo $quantity[$k];
							$var1 = explode(':',$quantity[$k]);
							//print_r($var1);
							if($userid[$i]==($var1[0])){
								$individual_quantity = $var1[1];
								$sql1 = "SELECT subscribe_sys_users.first_name, subscribe_sys_users.last_name, subscribe_sys_areas.area_id, subscribe_sys_areas.area_name FROM subscribe_sys_users, subscribe_sys_areas WHERE user_id=$userid[$i] && subscribe_sys_users.area_id=subscribe_sys_areas.area_id";
								
								$result1 = mysqli_query($conn, $sql1);
								$row1=mysqli_fetch_row($result1);
							 	echo "$row1[0] $row1[1]($individual_quantity)<br />"; 				
/*								$x=count($areas);
								echo "hi";
								echo $x;
								echo "hi";
								exit;*/
								for($m=0;$m<count($areas);$m++){
    
//									foreach($areas[$m] as $key=>$value){
										//echo $areas[$m]['areaid'];
										if($row1[2]==$areas[$m]['areaid']){
											$areas[$m]['quantity']=$areas[$m]['quantity']+$individual_quantity;
											break;
										}
										
//									}
									
								}
								
							}
							
						 }
						 
					 }
					 
									/*echo "<pre>";
									print_r($areas);
									echo "<pre>";*/
					 ?> 
					 							</td>
												<td>
		<?php 
			for ($r=0;$r<count($areas);$r++){
				if($areas[$r]["quantity"]!=0){
    				echo $areas[$r]["areaname"]."(".$areas[$r]["quantity"].")";
    				echo "<br />";
				}
			}
		?>
												</td>					
												<td><button class="btn btn-success btn-sm">Print</button> </td>
                                            </tr>
											<?php $j++; } ?>
										
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
			
			<script type="text/javascript">
            $(function() {
                //Datemask dd/mm/yyyy
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
                $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
                //Money Euro
                $("[data-mask]").inputmask();

                //Date range picker
                $('#reservation').daterangepicker();
                //Date range picker with time picker
                $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                        {
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                                'Last 7 Days': [moment().subtract('days', 6), moment()],
                                'Last 30 Days': [moment().subtract('days', 29), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                            },
                            startDate: moment().subtract('days', 29),
                            endDate: moment()
                        },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
                );

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal',
                    radioClass: 'iradio_minimal'
                });
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-red',
                    radioClass: 'iradio_flat-red'
                });

                //Colorpicker
                $(".my-colorpicker1").colorpicker();
                //color picker with addon
                $(".my-colorpicker2").colorpicker();

                //Timepicker
                $(".timepicker").timepicker({
                    showInputs: false
                });
            });
        </script>
<?php include('../includes/footer.php'); ?>