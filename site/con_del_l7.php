<?php
	include_once("../include/class.mysqldb.php");
	include_once("../include/config.inc.php");
	include_once('../config/routeros_api.class.php');			
	include_once('conn.php');
	echo "<meta charset='utf-8'>" ;	
	
	$layer = $_GET['name'];
		
	if($num=='0'){
		echo "<script>alert('Default profile can not be removed.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=index.php?opt=firewall_info' />";
		exit;
	}else{		
		$ARRAY = $API->comm("/ip/firewall/layer7-protocol/remove", array(
								"numbers" => $layer,
							));	
		//mysql_query("DELETE FROM mt_profile WHERE pro_name = '".$profile."' ");
		echo "<script>alert('ทำการลบ Layer7 Protocols เรียบร้อยแล้ว.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=index.php?opt=firewall_info' />";
		exit;
	}
?>