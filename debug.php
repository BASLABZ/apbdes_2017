<?php
session_start();
define('BASEPATH', 1);
define('ENVIRONMENT', 1);
require 'application/app.php';

$type = empty($_GET['type']) ? null : $_GET['type'];

if ($type !== 'info') {
	echo "<style>body {background-color:#222;color:#fff;zoom:.8;}</style><pre><h1>";
}

switch ($type) {
	case 'session':
		print_r($_SESSION);
	break;
	case 'server':
		require('application/config/database.php'); $db = $db['default'];
		$fdb = ibase_connect($db['hostname'] . ':' . $db['database'], $db['username'], $db['password']);
	break;
	case 'banyak-kd':
		// =================================================================
		$kd1 = '1.20.12.|1.20.16.|1.20.32.';
		$kd2 = '1.20.12.18|1.20.16.02|1.20.32.03|1.20.12.21';

		$debug_hasil = array();

		function a($kd, &$res)
		{
			$res = array('kec' => array(), 'desa' => array());
			$kd = explode('|', $kd);
			for ($i=0; $i < count($kd); $i++) {
				$a_kd = explode('.', $kd[$i]);
				$res['kec'][] = $a_kd[2];
				$res['desa'][] = $a_kd[3];
			}
			$res['kec'] = array_unique($res['kec']); // hanyak 1
			$res['desa'] = array_filter($res['desa']);
		}

		a($kd1, $debug_hasil['kd1']);
		a($kd2, $debug_hasil['kd2']);

		debug($debug_hasil);
		// =================================================================
	break;
	case 'number':
		$n = '1111111.219988';
		$nn = round($n,2);
		echo $n, "\n";
		echo $nn, "\n";
		var_dump($nn);
	break;
	case 'info':
		phpinfo();
		break;
}


/*// 201606241136
$d = "22-05-1996";
echo preg_replace('/(\d+)\-(\d+)\-(\d+)/', '$3/$2/$1', $d);
*/
