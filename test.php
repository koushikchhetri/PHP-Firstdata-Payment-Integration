<?php
require('class.firstdata.php');
$firstdata=new Firstdata();
$firstdata->_amount=$_REQUEST['amount'];//Amount want to pay
$firstdata->_cardholdername=$_REQUEST['cardholdername'];//Card holder name
$firstdata->_cardnumber=$_REQUEST['cardnumber'];// Card number
$firstdata->_cardexpiry=$_REQUEST['emonth'].substr($_REQUEST['eyear'],2,2);// January 2014 will be 0115
$firstdata->_cvdcode=$_REQUEST['cvdcode'];//Three digit code reverse of card

	/**
	* Billing address
	*/
$firstdata->_baddress1=$_REQUEST['baddress1'];
$firstdata->_baddress2=$_REQUEST['baddress2']; 
$firstdata->_bcity=$_REQUEST['bstate']; 
$firstdata->_bzip=$_REQUEST['bzip']; 
$firstdata->_bstate=$_REQUEST['bstate']; 
	/**
	 * End
	 * Billing address
	*/
	
/*
* If you do not provide the following line $firstdata->setmode(1); then it will treated as real transaction
*/	
$firstdata->setmode(1);// argument 1 means debug mode and 0 means live mode


if($firstdata->makepayment()){
	$transaction_result=$firstdata->gettranactiondetails();
	//Do the database oriented code here
}else{
	echo json_encode($firstdata->geterror());
}
