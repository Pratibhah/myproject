<?php 
session_start();
include('../includes/config.php');
include('../includes/header.php');
include('../includes/leftsidebar.php');
?>
<style>
@media print {
.box-footer{ display:block;}
}

@media print
{
  .box-footer,.bt-border{ display:none;}
}
logo.{
page-break-before: always;
}
.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  /*text-decoration: underline;*/
}

body {
  position: relative;
  width: 100%;  
  height: 100%; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 200px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(../../img/dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 115px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  /*text-align: right;*/
}

#project div,
#company div {
  /*white-space: nowrap;*/        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-top: 1px solid #C1CED9;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  /*vertical-align: top;*/
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: relative;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}

</style>

<?php 
	if(!(isset($_POST['submit_button'])) || !(empty($_POST['status']))){
		$daterange = $_POST['date-range'];
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		
		echo "<pre>";
		echo "Final in session<br/>";
		print_r($_SESSION['final_array']);
		echo "</pre>";*/
		$post_detailed_bill_array = $_POST['status'];
		$sess_detailed_bill_array = $_SESSION['final_array'];
		
?>
		
<?php	

foreach ($sess_detailed_bill_array as $out_keys => $out_values) {
	if(in_array($out_keys,$post_detailed_bill_array)){?>
     <div id="logo" style="page-break-before: always;">
        <img src="../../img/nutrotop-logo.jpg">
      </div>
      <h1>INVOICE</h1>
      <div id="company" class="clearfix">
        <div>NutroTop</div>
        <div>455 Foggy Heights,<br /> Hadapsar,Pune</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:nutrotop@yahoo.com">nutrotop@yahoo.com</a></div>
      </div>
      <div id="project">
        <div><span>PROJECT: </span>NutroTop Juices</div>
        <div><span>CLIENT: </span>
		<?php 
			$name_addr_array = explode(':',$out_keys);
			echo $name_addr_array[0]; 
		?>
		</div>
        <div><span>ADDRESS: </span>
		<?php 
			echo $name_addr_array[1];
		?>
		</div>
        <div><span>INVOICE DATE RANGE: </span><?php echo $daterange; ?></div>
      </div>
    <main>
	<div style="clear:both"></div>
      <table>
        <thead>
          <tr>
            <th class="service">SR No</th>
            <th class="desc">PRODUCTS</th>
            <th class="desc">QUANTY</th>
            <th class="desc">TOTAL</th>
          </tr>
        </thead>
		<?php 
		$p=1;
		foreach ($out_values as $in_keys => $in_values) {
		?>
        <tbody>
            <?php if((strpos($in_keys,"price_")!==0) && (strpos($in_keys,"total")!==0)){?>
          <tr>
            <td class="service"><?php echo $p; ?></td>
			<td class="desc"><?php echo $in_keys; ?></td>
			<td class="desc"><?php echo $in_values; ?></td>
            <td class="desc"><?php echo $out_values["price_$in_keys"]; ?></td>
          </tr>
			<?php 			
			$p++;
			} 
 			?>
		<?php
		} ?>
			
			<tr>
            <td colspan="3" class="grand total">GRAND TOTAL</td>
            <td class="grand total"><?php echo 'Rs '.$out_values['total'];?></td>
          </tr>
        </tbody>
      </table>
	  <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
	<div style="page-break-after:always">
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
	</div>
<?php }//in_array
}//for
?>
<div class="bt-border" style="border-top:solid; border-color:#3399CC; margin-bottom:15px;"></div>
<div class="row">
	<div class="col-md-6"></div>
	<div class="col-md-6">
		<div class="box-footer"><button class="btn btn-primary" name="button" type="button"  onClick="window.print();">Print</button>
		</div>
	</div>
</div>		
<?php }//if(!(isset($_POST['submit_button'])) && !(empty($_POST['status'])))
		else{?>
		<div style="color:#CC0033;margin-left:240px;">
		<?php 	echo "Please select users to create invoices.";
		}?>
		</div>
<?php include('../includes/footer.php'); ?>