<?php
/*
   __       _
  / /  ___ | | __ _
 / /  / _ \| |/ _` |
/ /__| (_) | | (_| |
\____/\___/|_|\__,_|
					v1.0
*/
/**
 * Lola by Alec Ritson
 *
 * @package   Lola
 * @author    Alec Ritson
 * @copyright Copyright (c) 2013, Alec Ritson.
 * @license	  Creative Commons Attribution 3.0 Unported License.
 * @link      http://heylola.co.uk
 */


$path = 'app/index.php';

if (!is_file($path))
{
	exit('Could not find your lola/ folder. Please ensure that <strong><code>$lolaPath</code></strong> is set correctly in '.__FILE__);
}
elseif(file_exists('install')){
	require_once('install/index.php');
}else {
  require_once $path;
}
