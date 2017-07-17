<?php
memory_get_peak_usage();
ini_set('memory_limit', '-1');
set_time_limit(0);
if (!isset($_GET['debug'])){
/*if (strtoupper($_GET['report_type']) == 'XLS') {
	header('Content-Type: application/vnd.ms-excel');
	$cont = 1;
} 
else*/ if (strtoupper($_GET['report_type']) == 'PDF') {
	header('Content-Type: application/pdf');
	$cont = 1;
}
else {
	if ($_GET['file'] || $_POST['file']) {
		header('Content-Type: application/pdf');
		$cont = 1;
	}
}

} else {
	$cont=1;
}
if ($cont == 1) {
	$tmp_file = '';
	$cont = 0;
	$post_data = '';
	
	$i = 1;
	do {
		$tmp_file = 'post' . md5(date(DATE_RFC822) . $i) . '.tmp';
		$i++;
	} while (file_exists($tmp_file));
	
	foreach ($_POST as $var => $val) {
		if ($post_data != '') $post_data .= '&';
		$post_data .= urlencode($var) . '=' . urlencode($val);
	}
	
	foreach ($_GET as $var => $val) {
		if ($post_data != '') $post_data .= '&';
		$post_data .= urlencode($var) . '=' . urlencode($val);
	}
	
	$handle = fopen($tmp_file,"w");
	fwrite($handle,$post_data);
	fclose($handle);
	
	//system('HOME=/var/www/ DISPLAY=:3 wine d:\\ReportServerConsole.exe test.tmp');
	//system('HOME=/var/www/ DISPLAY=:3 wine d:\\ReportServerConsole.exe '.$tmp_file.'');
	system('ReportServerConsole.exe '.$tmp_file.'');

	unlink($tmp_file);
}
else
	echo "Missing parameters";

?>
