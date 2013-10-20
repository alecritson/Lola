<?php

include('kirby.php');

class install {

	public function __construct() {

	 	$this->docRoot = $_SERVER['DOCUMENT_ROOT'];

	 	$this->hostsDir = "../app/_vhosts/";

	 	$this->sites = "../app/websites.json";

	 	$this->status = dir::inspect($this->hostsDir);

	}
	public function checkDir($file) {

		echo "<td>";
		echo $file;
		echo "</td>";
		echo "<td>";
		echo substr(sprintf('%o', fileperms($file)), -4);
		echo "</td>";
		echo "<td>";
		if(is_writable($file)) {
			echo "<i class=\"icon-ok\"></i>";
		} else {
			echo "<i class=\"icon-remove\">&nbsp;</i>";
		}
		echo "</td>";

	}
}
$install = new install;
?>