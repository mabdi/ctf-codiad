<?php


//			"zip-name" => "submit_".$_SESSION['project'].".tar" ,
//			"pid" => "PID_JA",
//			"folder" => "FOLDER_JA",

	function getConfig() {
        $json = file_get_contents("projects.php");
        $json = str_replace("|*/?>","",str_replace("<?php/*|","",$json));


        $json = json_decode($json,true);

		return array(
			"upload-webservice" => "https://ctf.behsazan.net/api/grade",
                        "projects" => $json,
		);
	}
?>
