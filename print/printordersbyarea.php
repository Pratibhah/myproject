<?php 
session_start();
include('../includes/config.php');
include('../includes/header.php');
include('../includes/leftsidebar.php');
?>
<style type="text/css">
/* all devices */
@media all
{
  .nonPrintable,.hidden-list,.box-footer,.box-header{ display:block;}
}

/* printer specific CSS */
@media print
{
  .nonPrintable,.box-footer,.box-header{ display:none;}
  .box.box box-warning{ border-top-color: #ffffff;}
  #area_name, #daterange{color:#CC0000;}
  .hidden-list{ display:block;}
  .hidden-list table {width:1200px; font-size:12px;}
}
</style>
<div class="col-md-4"></div>
<div class="col-md-5">
	<!-- general form elements disabled -->
    	<div class="box box-warning">
        	<div class="box-header">
            	<h3 class="box-title">Print orders by area</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
				<div class="nonPrintable">
            	<form role="form" name="cancelordersbyarea" method="post" action="cancelordersbyarea.php">
					<!-- Date range -->
                    <div class="form-group">
                        		<label>Date Range <span style="color: red">*</span></label>
                                <div class="input-group">
                                	<div class="input-group-addon">
                                    	<i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservation1" name="date-range"/>
									
                                </div><!-- /.input group -->
								<small class="errfn1" id="errfn1" style="color:#FF0000;"></small>
                   </div><!-- /.form group -->
               	<div class="form-group">
                	<label>Area <span style="color: red">*</span></label>
                    <select class="form-control" id="area_name" name="area_name" onchange="run(this.value);">
                       <option value="Please select an area">Please select an area</option>
					   <option value="viewallarea">All area </option>
                       <?php 
						$sql2 = "SELECT DISTINCT area_id, area_name FROM subscribe_sys_areas ORDER BY area_name ASC";
						$result2 = mysqli_query($conn,$sql2);
						$j=1;
						while($row2=mysqli_fetch_assoc($result2)){?>
							<option value="<?php echo $row2['area_id']; ?>"><?php echo $row2['area_name']; ?></option>
					<?php $j++; }?>	
                    </select>
					<small class="errfn2" id="errfn2" style="color:#FF0000;"></small>
					
                </div><!-- /.form group -->
			</div><!-- /.nonPrintable -->
				<div class="hidden-list" id="hidden-list" style="width:100%"></div><!-- /.hidden-list from ajax file -->
										
				<div class="box-footer"><button class="btn btn-primary" name="submit_button" type="button"  onClick=" return myfunction()">Print</button>
				
</div>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /box box-warning -->
</div><!-- /.col-md-5-->
						
<div class="col-md-3"></div>
<script>
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
 
  	var area_id = document.getElementById('area_name').value;
  	var area_id_pos = document.getElementById('area_name').selectedIndex;
	var area_name = document.getElementById('area_name').options[area_id_pos].text;
	//alert(area_name);
	var daterange = document.getElementById('reservation1').value;
	var data1 = 'area_id='+area_id+'&area_name='+area_name+'&daterange='+daterange;
   xmlhttp.open("POST","ajaxfileprintordersbyarea.php",true);
   xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   xmlhttp.send(data1);
   //alert(data1);
}
function myfunction(){
	//alert('hi');
	var ok = true;
	if(document.getElementById('reservation1').value == "" || document.getElementById('reservation1').value == "01/01/0000 - 01/01/0000" ){
		document.getElementById('errfn1').innerHTML="Please enter date range";
		ok = false;
		//alert(ok); 
	}else{
		document.getElementById('errfn1').innerHTML="";
	}
	if(document.getElementById('area_name').value == "Please select an area"){
		document.getElementById('errfn2').innerHTML="Please select an area";
		ok = false;
	}else{
		document.getElementById('errfn2').innerHTML="";
	}

	//alert(ok);
	if(ok==true){
		window.print();
		//return ok;
	}else{
		return ok;
	}
	
}
</script>
<?php include('../includes/footer.php'); ?>