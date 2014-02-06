<?php
	$x = 'X-Powered-By: ';
	$rmfile = 'README.md';
	$hosts = file('hosts.txt');
	date_default_timezone_set("Asia/Kuala_Lumpur");	
	$rmheader = file_get_contents('rmheader.txt');
	file_put_contents($rmfile, "UPDATE: ".date("Y-m-d H:i:s e"));
	file_put_contents($rmfile, $rmheader, FILE_APPEND);

	$c = 0;
	foreach ($hosts as $h) {
		$c++;
		$h = trim($h);
		echo "checking $h\n";
		$result = shell_exec("curl -I $h");
		$lines = explode("\n",$result);
		//print_r($lines);
		
		$found = "$c.  $h - not found\n";
		foreach($lines as $l) {
			$xl = substr($l, 0, strlen($x));
			echo "checking $xl\n";
			if ( $xl == $x) {
				$powered = trim(str_replace($x, '', $l));
				$found = "$c.  $h - $powered\n";
			}
		}
		file_put_contents($rmfile, $found ,FILE_APPEND);
		echo $found;
		echo "----------------------------\n";
	}

?>