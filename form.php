<?php
header('Access-Control-Allow-Origin: *');
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	if(!empty($_POST['field_details']) && !empty($_POST['field_email'])) {
		$pdetails = "<b>Raw RFT Data:</b> \r\n";
		foreach($_POST['rft-data'] as $rftdata) $pdetails .= $rftdata . "\r\n";
		$pdetails .= "\r\n<b>Issue Details:</b> \r\n" . $_POST['field_details'];
		$data = array(
			'instid' => $_POST['instid'],
			'quid' => $_POST['quid'],
			'qlog' => $_POST['qlog'],
			'source' => $_POST['source'],
			'pquestion' => $_POST['pquestion'],
			'pdetails' => $pdetails,
			'pemail' => $_POST['field_email'],
			'pname' => $_POST['field_name']
		);
		$curl = curl_init('https://api2.libanswers.com/1.0/form/submit');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST , TRUE); 
		curl_setopt($curl, CURLOPT_POSTFIELDS , http_build_query($data)); 
		$result = curl_exec($curl);
		if(curl_getinfo($curl)['http_code'] === 200) echo $result;
		else echo '{"message":"There was an error submitting the form. Please check your information and try again."}';
		curl_close($curl);
	} else if(empty($_POST['field_details'])) echo '{"message":"There was an error submitting the form. Please fill out the details section of the form."}';
	else if(empty($_POST['field_email'])) echo '{"message":"There was an error submitting the form. Please enter a valid email."}';
}
?>