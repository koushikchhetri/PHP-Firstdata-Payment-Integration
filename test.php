<?php
require('class.firstdata.php');
$firstdata=new Firstdata();
	$firstdata->_amount=$_REQUEST['amount'];
	$firstdata->_cardholdername=$_REQUEST['cardholdername'];
	$firstdata->_cardnumber=$_REQUEST['cardnumber'];
	$firstdata->_cardexpiry=$_REQUEST['emonth'].substr($_REQUEST['eyear'],2,2);
	$firstdata->_cvdcode=$_REQUEST['cvdcode'];
	$firstdata->_baddress1=$_REQUEST['baddress1']; 
	$firstdata->_baddress2=$_REQUEST['baddress2']; 
	$firstdata->_bcity=$_REQUEST['bstate']; 
	$firstdata->_bzip=$_REQUEST['bzip']; 
	$firstdata->_bstate=$_REQUEST['bstate']; 
	$firstdata->setmode(1);
	if($firstdata->makepayment()){
		$transaction_result=$firstdata->gettranactiondetails();
		//Do the database oriented code here
	}else{
		echo json_encode($firstdata->geterror());
	}
