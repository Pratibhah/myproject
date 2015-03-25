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
                                    <h3 class="box-title">All Products</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sr. no</th>
                                                <th>Product Id</th>
                                                <th>Product Name</th>
                                                <th>Product Description</th>
                                                <th>Product Price(in Rs)</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
	<?php 
		$sql = "SELECT * FROM subscribe_sys_products ORDER BY product_name";
		$result = mysqli_query($conn, $sql);
		$j=1;
		while($row=mysqli_fetch_assoc($result)){ ?>

                                            <tr>
                                                <td><?php echo $j; ?></td>
                                                <td><?php echo $row['product_id']; ?></td>
                                                <td><?php echo $row['product_name']; ?></td>
                                                <td><?php echo $row['product_description']; ?></td>
                                                <td><?php echo $row['product_price']; ?></td>
												<td><a href="addnewproduct.php?id=<?php echo $row['product_id']; ?>"><button class="btn btn-success btn-sm">Edit</button></a> &nbsp <button class="btn btn-danger btn-sm">Delete</button></td>
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