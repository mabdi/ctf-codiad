<?php

    error_reporting(1);
    require_once('../../common.php');
    require_once('class.ctf.php');
    
    checkSession();
    set_time_limit(0);
    
    $ctf = new Ctf();
    
    if(isset($_POST['action'])){
	    switch($_POST['action']) {
	        
	        case 'submit':
	        	echo $ctf->doSubmit();
	            break;
	        
	        case 'reset':
	        	echo $ctf->doReset();
	            break;
	            
	        default:
	            echo '{"status":"error","message":"No Type"}';
	            break;
	    }
    }else{
    	echo '{"status":"error","message":"No action"}';
    }
    
    
    
?>