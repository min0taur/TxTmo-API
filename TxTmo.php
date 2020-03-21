<?php
// Txtmo Information
define('_USER', 'txtmo'); // replace txtmo with your TxTmo username
define('_PASS', 'password'); // replace password with your TxTmo password

define('_URL', 'https://api.mat.ph/sms/'); // API base URL

Class TxTmo {	
	// required params
	public $to, $message, $id;
	
	// private
	private $url, $data;
	
    /*/ --------------------
    Send SMS
    */
	public function _send() {
		$this->url = _URL.'send.php';
		$this->data['to'] = $this->to;
		$this->data['message'] = $this->message;
		return $this->_curl();
	}
    /*/ --------------------
    SMS Status
    */
	public function _status() {
		$this->url = _URL.'status.php';
		$this->data['id'] = $this->id;
		return $this->_curl();
	}
    /*/ --------------------
    Curl
    */
	private function _curl() {
		$ch = curl_init($this->url);
		$this->data['user'] = _USER;
		$this->data['pass'] = _PASS;
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->data));
		curl_setopt($ch,CURLOPT_TIMEOUT,5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);
		curl_close($ch);
		if( !$response ) return curl_error($ch);
		return $response;
	}
}