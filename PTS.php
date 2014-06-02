<?php
namespace PTSAPI;

class PTS {
		
	/**
	 * Get operator name for phone number
	 *
	 * @param string $phone_number phone number
	 * @return string Operator name or (bool)false on error
	 */
	public function getOperator($phone_number)
	{
		//Extract number data
		if (preg_match("~07[0-9]{2}-[0-9]{6}$~", $phone_number)) {
			$ndc = substr($phone_number, 1, 2);
			$number = substr($phone_number, 3, 1) . substr($phone_number, 5, 6);			
		} elseif (
			preg_match("~^\+?46(?<ndc>7[0-9]{1})(?<number>[0-9]+)$~", $phone_number, $matches) || 
			preg_match("~^0?(?<ndc>[0-9]+)[\- ](?<number>[0-9]+)$~", $phone_number, $matches)
		) {
			$ndc = $matches['ndc'];
			$number = $matches['number'];		
		} else {
			return false;
		}

		$url = "http://api.pts.se/PTSNumberService/Pts_Number_Service.svc/json/SearchByNumber?number=" . $ndc . "-" . $number;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);	
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		if ($http_code != 200) {
			return false;
		}

		if ($response === false) {
			return false;
		}
		
		$result = json_decode($response);
		
		if ($result === false) {
			return false;
		}
		
		return $result->d->Name;
	}			
}
