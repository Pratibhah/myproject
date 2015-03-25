<?php 
session_start();
include('../includes/config.php');
include('../includes/header.php');
include('../includes/leftsidebar.php');
?>

<div class="col-md-4"></div>
<div class="col-md-5">
	<!-- general form elements disabled -->
    	<div class="box box-warning">
        	<div class="box-header">
            	<h3 class="box-title">Print Bill</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            	<form role="form" name="addneworder" method="post" action="invoice.php">
					<!-- Date range -->
                    <div class="form-group">
                        		<label>Date Range <span style="color: red">*</span></label>
                                <div class="input-group">
                                	<div class="input-group-addon">
                                    	<i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservation1" name="date-range" onFocus="run(this.value);"/>
									<small class="errfn1" id="errfn1" style="color:#FF0000;"></small>
                                </div><!-- /.input group -->
                   </div><!-- /.form group -->
 
				<div class="hidden-list" id="hidden-list"></div><!-- /.hidden-list -->
										
				<div class="box-footer"><button class="btn btn-primary" name="submit_button" type="submit" onclick="return myfunction()">Submit</button>
				
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
 
  	var data1 = document.getElementById('reservation1').value;
    //alert(data1);
   xmlhttp.open("POST","ajaxfile-printbill.php",true);
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