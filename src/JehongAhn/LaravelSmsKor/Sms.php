<?php namespace JehongAhn\LaravelSmsKor;

class Sms {
	
	/**
	 * Send a message through the cafe24.
	 *
	 * @param  array  $data = [phone, message]
	 * @return array  [success, error]
	 */
	public static function send(array $data) {
		$sms_url = "http://sslsms.cafe24.com/sms_sender.php";
		$sms['user_id'] = base64_encode(\Config::get('laravel-sms-kor::cafe24.user_id'));
		$sms['secure'] = base64_encode(\Config::get('laravel-sms-kor::cafe24.secure'));
		$sms['msg'] = base64_encode(stripslashes($data['message']));

		$sms['rphone'] = base64_encode($data['phone']);
		$sms['sphone1'] = base64_encode(\Config::get('laravel-sms-kor::config.sender_phone1'));
		$sms['sphone2'] = base64_encode(\Config::get('laravel-sms-kor::config.sender_phone2'));
		$sms['sphone3'] = base64_encode(\Config::get('laravel-sms-kor::config.sender_phone3'));
		//$sms['rdate'] = base64_encode($_POST['rdate']);
		//$sms['rtime'] = base64_encode($_POST['rtime']);
		$sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.
		//$sms['returnurl'] = base64_encode($_POST['returnurl']);
		//$sms['testflag'] = base64_encode($_POST['testflag']);
		//$sms['destination'] = urlencode(base64_encode($_POST['destination']));
		//$returnurl = $_POST['returnurl'];
		//$sms['repeatFlag'] = base64_encode($_POST['repeatFlag']);
		//$sms['repeatNum'] = base64_encode($_POST['repeatNum']);
		//$sms['repeatTime'] = base64_encode($_POST['repeatTime']);
		//$sms['smsType'] = base64_encode($_POST['smsType']); // LMS일경우 L
		//$nointeractive = 1; //사용할 경우 : 1, 성공시 대화상자(alert)를 생략

		$host_info = explode("/", $sms_url, 4);
		$host = $host_info[2];
		$path = $host_info[3];

		srand((double)microtime()*1000000);
		$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
		
		$header = "POST /".$path ." HTTP/1.0\r\n";
		$header .= "Host: ".$host."\r\n";
		$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";
		
		$content = '';
		foreach($sms AS $index => $value){
			$content .="--$boundary\r\n";
			$content .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
			$content .= "\r\n".$value."\r\n";
			$content .="--$boundary\r\n";
		}
		
		$header .= "Content-length: " . strlen($content) . "\r\n\r\n";
		
		$fp = fsockopen($host, 80);
		
		if ($fp) { 
			fputs($fp, $header.$content);
			$rsp = '';
			while(!feof($fp)) { 
				$rsp .= fgets($fp,8192); 
			}
			fclose($fp);
			$msg = explode("\r\n\r\n",trim($rsp));
			$rMsg = explode(",", $msg[1]);
			$Result= $rMsg[0]; //발송결과
			$Count= $rMsg[1]; //잔여건수
		}
		else {
			return [
				'success'	=> false,
				'error' 	=> \Lang::get('laravel-sms-kor::sms.connection_failed', []),
			];
		}
		
		
		if($Result=="success") {
			return [
				'success'	=> true,
			];
		}
		else if($Result=="reserved") {
			return [
				'success'	=> true,
			];
		}
		else if($Result=="3205") {
			return [
				'success'	=> false,
				'error' 	=> \Lang::get('laravel-sms-kor::sms.wrong_number', []),
			];
		}

		else if($Result=="0044") {
			return [
				'success'	=> false,
				'error' 	=> \Lang::get('laravel-sms-kor::sms.blocked_as_spam', []),
			];
		}
		
		else {
			return [
				'success'	=> false,
				'error' 	=> \Lang::get('laravel-sms-kor::sms.unknown_error', ['code'=>$Result]),
			];
		}
	}
	
	
	
}
