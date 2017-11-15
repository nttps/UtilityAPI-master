<?php
header('Content-type: text/html; charset=utf-8');


function curl_connects($service_url,$method="POST",$curl_post_data) {
$ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $service_url);
    curl_setopt($ch, CURLOPT_REFERER, $service_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;	
}
 
$user = base64_encode("2i1NMrqwOwo+dIvqF9hdsssnAwdBr7f2RLEPrO93R1Q=");
$pass = base64_encode("P7EAl0g+LEk9gXZFjQQfb7VkYlCL0Xzs4Uaa3nqrT60=");
 

$curl_post_data['func'] = "InquiryTransaction";
$curl_post_data['key'] = "nxZvx0pbc3tb";
$curl_post_data['username'] = $user;
$curl_post_data['password'] = $pass;
$curl_post_data['account'] = "068-7-18915-9";
$curl_post_data['d_start'] = date('Y-m-d');
$curl_post_data['d_end'] = date('Y-m-d');
$curl_post_data['domain'] = "www.nagieos.com";
$curl_post_data['license'] = "nagieos";
$curl_post_data['folder_domain'] = "nagieos";


 

 
$get_params = "";
foreach($curl_post_data as $key=>$value){
	$get_params .= $key."=".$value."&";
}
$get_params .="aa=aa";
 


  $service_url = 'https://www.nagieos.com/BBLMX.php?'.$get_params;
   $api_get_data = curl_connects($service_url,$method="POST",$curl_post_data);

  
$api_array = json_decode($api_get_data);
var_dump($api_array);

 




?>
