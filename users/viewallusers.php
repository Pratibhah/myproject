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
                                    <h3 class="box-title">All Users</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sr. no</th>
                                                <th>User Id</th>
                                                <th>User Name</th>
                                                <th>Email Id</th>
                                                <th>Mobile</th>
												<th>Address</th>
												<th>Status</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sql = "SELECT subscribe_sys_users.user_id, subscribe_sys_users.first_name, subscribe_sys_users.last_name, subscribe_sys_users.email_id, subscribe_sys_users.mobile_no, subscribe_sys_users.addr1, subscribe_sys_users.email_id, subscribe_sys_users.addr2, subscribe_sys_users.city, subscribe_sys_users.post_code, subscribe_sys_users.status, subscribe_sys_areas.area_name  FROM subscribe_sys_users, subscribe_sys_areas WHERE subscribe_sys_users.area_id = subscribe_sys_areas.area_id ORDER BY subscribe_sys_users.first_name";
								
$result = mysqli_query($conn, $sql);
$j=1;
	while($row=mysqli_fetch_assoc($result)){ ?>

                                            <tr>
                                                <td><?php echo $j; ?></td>
                                                <td><?php echo $row['user_id']; ?></td>
                                                <td><?php echo $row['first_name'];?> &nbsp <?php echo $row['last_name']; ?></td>
                                                <td><?php echo $row['email_id']; ?></td>
                                                <td><?php echo $row['mobile_no']; ?></td>
												<td><?php echo $row['addr1'];?> , &nbsp <?php echo $row['addr2']; ?> <br /> <?php echo $row['area_name'];?> , <?php echo $row['city']; ?> &nbsp <?php echo $row['post_code']; ?></td>
												<td><?php echo $row['status']; ?></td>
												<td><a href="addnewuser.php?id=<?php echo $row['user_id'];  ?>"><button class="btn btn-success btn-sm">Edit</button></a> &nbsp <button class="btn btn-danger btn-sm">Delete</button></td>
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
			
<?php include('../includes/footer.php'); ?>