<?php
class Firstdata{
	private $_url='';
	private $_gatewayid='';//Your Firstdata gatewayid
	private $_gatewaypassword='';//Your Firstdata gateway password
	public $_transaction_type='00';
	public $_amount=0;
	public $_cardholdername='';
	public $_cardnumber='';
	public $_cardexpiry='';//0614
	public $_cvdcode='';//Optional for test mode
	
	/**
	Billing info
	*/
	public $_baddress1='';//Optional for test mode
	public $_baddress2='';//Optional for test mode
	public $_bcity='';//Optional for test mode
	public $_bzip='';//Optional for test mode
	public $_bstate='';//Optional for test mode
	
	private $_mode=0;//0=Live mode,1=Test Mode
	
	private $_payment_success_response='';
	private $_payment_error_response='';
	
	public function __destruct(){
		$this->_transaction_type='00';
		$this->_amount=0;
		$this->_cardholdername='';
		$this->_cardnumber='';
		$this->_cardexpiry='';
		$this->_cvdcode='';
		$this->_baddress1='';//Optional for test mode
		$this->_baddress2='';//Optional for test mode
		$this->_bcity='';//Optional for test mode
		$this->_bzip='';//Optional for test mode
		$this->_bstate='';//Optional for test mode
		
		
		$this->_mode=0;//0=Live mode,1=Test Mode
		
		$this->_payment_success_response='';
		$this->_payment_error_response='';
	}
	
	
	public function setmode($mode=1){
		$this->_mode=$mode;
	}
	
	public function makepayment(){
		// Initializing curl
		if($this->_mode==1){
			$this->_url='https://api.demo.globalgatewaye4.firstdata.com/transaction/v11';
		}else{
			$this->_url='https://api.globalgatewaye4.firstdata.com/transaction/v11';
		}
		$ch = curl_init($this->_url);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($this->getpostdata()));
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=UTF-8;','Accept: application/json'));
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
		
		// Getting results
		$result = curl_exec($ch);
		curl_close($ch);
		$obj_response=json_decode($result);
		if(!$obj_response){
			$this->_payment_error_response=$result;
			return FALSE;
		}else{
			if($obj_response->bank_resp_code=='100')
				$this->_payment_success_response=$obj_response;
			return TRUE;
		}
	}
	
	public function gettranactiondetails(){
		return array('authorization_num'=>$this->_payment_success_response->authorization_num,'transaction_tag'=>$this->_payment_success_response->transaction_tag,'retrieval_refno'=>$this->_payment_success_response->retrieval_ref_no,'receiptcopy'=>$this->_payment_success_response->ctr);
	}
	public function geterror(){
		return $this->_payment_error_response;
	}
	
	private function getpostdata(){
		$data = array("gateway_id" => $this->_gatewayid, "password" => $this->_gatewaypassword, "transaction_type" => $this->_transaction_type, "amount" => $this->_amount, "cardholder_name" => $this->_cardholdername, "cc_number" => str_replace(" ","",$this->_cardnumber), "cc_expiry" => $this->_cardexpiry,'CVDCode'=>$this->_cvdcode,"Address" => array("Address1" => $this->_baddress1, "Address2" => $this->_baddress2, "City" => $this->_bcity, "Zip" => $this->_bzip, "State" => $this->_bstate));
		return $data;
	}
}
?>
