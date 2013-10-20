<?php
/**
 * Lola by Alec Ritson
 *
 * @package   Lola
 * @author    Alec Ritson
 * @copyright Copyright (c) 2013, Alec Ritson.
 * @license	  Creative Commons Attribution 3.0 Unported License.
 * @link      http://heylola.co.uk
 */

include('lola.php');

/*
---------------------------------
Start building the API

Available actions:

action=add - Add website
action=rem - Remove website
action=avt - Active website (also updates v-hosts)


URL to add website:

index.php?action=add&name=My%website&location=My/location/is/here


---------------------------------
*/

// Check if there are any GET requests being made
if (!empty($_GET)) {

   /*
   ----------------------------------------
   Check if an action is being passed.

   Available methods:
   	action=add - Add website
	action=rem - Remove website
	action=avt - Active website (also updates v-hosts)

   ----------------------------------------
   */

	if(isset($_GET['action'])) {

		/*
		---------------------------------------
		Store our action into a variable;
		---------------------------------------
		*/

		$a = $_GET['action'];


		/*
		---------------------------------------
		If you want to add a website

		Requires:
			name
			location
		---------------------------------------
		*/

		if($a == "add")
		{
			// Do some checks.
			if(isset($_GET['name']) && isset($_GET['location'])) {

				$siteName = $_GET['name'];
				$location = $_GET['location'];
				$lola->addWebsite($siteName, $location);

			} else {
				echo "Error: Make sure you specify both a name and location";
			}
		}

		/*
		---------------------------------------
		If you want to Remove a website

		Requires:
			ID
		---------------------------------------
		*/

		elseif($a == "rem")
		{
			// Do some checks.
			if(isset($_GET['id'])) {

				$siteID = $_GET['id'];
				$lola->deleteWebsite($siteID);

			} else {
				echo "Error: Make sure you specify the ID of the website you want to delete";
			}
		}

		/*
		---------------------------------------
		If you want to activate a website

		Requires:
			ID
			Directory
		---------------------------------------
		*/

		elseif($a == "avt")
		{
			if(isset($_GET['location']) && isset($_GET['id'])) {

				$siteID = $_GET['id'];
				$location = $_GET['location'];
				$lola->updateVhosts($location, $siteID);

			} else {
				echo "Error: Make sure you specify the ID and location of the website you want to activate";
			}
		}

		// No appropriate action has been set.
		else
		{
			echo "Please enter a valid action";
		}

	} else {
		echo "No action has been set";
	}

} else {
	require_once('interface/header.php');
	require_once('interface/websiteForm.php');
	require_once('interface/websites.php');
	require_once('interface/footer.php');
}


?>
