<?php
/*
 * Copyright (c) Codiad & Andr3as, distributed
 * as-is and without warranty under the MIT License.
 * See http://opensource.org/licenses/MIT for more information.
 * This information must remain intact.
 */

   include_once('config.php');

    class Ctf {
        public $resultArray;
        public $result;
        function __construct() {
        }
        public function doSubmit() {
            $projects = getConfig()["projects"];

            foreach($projects as $proj){
               if($proj["project"] == $_SESSION['project']){
                   $pr = $proj;
               }
            }
//file_put_contents( '/tmp/3.log', var_export("tar -zcf ".BASE_PATH."/workspace/".$pr["zip-name"] ." -C ". BASE_PATH."/workspace/".$pr["project"] ." .",true),FILE_APPEND);


            // zip src
            shell_exec("tar -zcf ".BASE_PATH."/workspace/".$pr["zip-name"] ." -C ". BASE_PATH."/workspace/".$pr["project"] ." .");
            // call platform file submit evaluation webservice + upload zip file
            $fullfilepath = realpath(BASE_PATH."/workspace/".$pr["zip-name"]);
	    $upload_url = getConfig()["upload-webservice"];
	    $pid = $pr["pid"];
	    $token = $pr["folder"];
	    $params = array(
		 'file'=>"@$fullfilepath",
		 'pid'=> $pid,
	         'folder' => $token
	    );
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_VERBOSE, 1);
	    // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: $cookie"));
	    curl_setopt($ch, CURLOPT_URL, $upload_url); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    $response = curl_exec($ch);
	    curl_close($ch);
            // make result
            $json = json_decode($response);
$json->{'project'} = $_SESSION['project'];
file_put_contents( '/tmp/3.log', var_export($json,true),FILE_APPEND);

$myfile = fopen($pr['result'], "w") or die("Unable to open file!");
fwrite($myfile, json_encode($json));
fclose($myfile);

            if($json->{'stat'} == 1){
            	return formatJSEND("success",$json->{'msg'});
            }else{
            	//return result in json format
            	return formatJSEND("error",$json->{'msg'});
            }
        }
 
        public function doReset($path, $repo) {
            // call platform reset webservice
            
			$upload_url = getConfig()["reset-webservice"];
			$pid = getConfig()["pid"];
			$token = getConfig()["token"];
			$params = array(
			 'pid'=> $pid,
			 'token' => $token
			);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: $cookie"));
			curl_setopt($ch, CURLOPT_URL, $upload_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			
			$response = curl_exec($ch);
			curl_close($ch);
            // make result
            $json = json_decode($response);
            if($json['status'] == 1){
            	return formatJSEND("success",array("message"=>$json['message']));
            }else{
            	//return result in json format
            	return formatJSEND("error",array("message"=>$json['message']));
            }
        }
        
    }
?>
