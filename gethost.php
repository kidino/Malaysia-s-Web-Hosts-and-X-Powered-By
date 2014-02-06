<?php
	$x = 'X-Powered-By: ';
	$rmfile = 'README.md';
	$hosts = file('hosts.txt');
	file_put_contents($rmfile, "UPDATE: ".date("Y-m-d H:i:s"));
	file_put_contents($rmfile, "\n\nMalaysia-s-Web-Hosts-and-X-Powered-By\n=====================================\n\nThis repo shows X-Powered-By header information of web hosting companies in Malaysia. I simply run the script and it will update the README.md in this repo.\n\n", FILE_APPEND);

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