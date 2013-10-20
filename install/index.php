
 <!doctype html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Install Lola v1.0</title>
 	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
 	<link rel="stylesheet" href="install/resources/css/style.css">
 	<?php include('resources/install.class.php');

 	$docRoot = getcwd();
 	$docRoot = str_replace('\\', '/', $docRoot);
 	$hostsDir = "/app/_vhosts/*.conf";
	$myIP = gethostbyname(trim(`hostname`));




 	?>

 	<div class="wrap">
	<figure class="logo"><img src="install/resources/images/logo.png" alt=""></figure>
 		<div>

		<h1>Thanks for using Lola!</h1>
		<p>We're just going to go through some steps and checks to get you up and running.</p>

		<h2>Preflight checks</h2>
		<p>Below is a list of directories/files that need to be writeable by php, if its got a tick, its all good</p>
		<table class="preflight">
			<tr>
				<th>File</td>
				<th>Permissions</td>
				<th>Status</td>
			</tr>
			<tr>
				<?php $install->checkDir('./app/websites.json'); ?>
			</tr>
			<tr>
				<?php $install->checkDir('./app/_vhosts/'); ?>
			</tr>
			<tr>
				<?php $install->checkDir('./app/_vhosts/hosts.conf'); ?>
			</tr>
		</table>
		<h2>Steps</h2>
		<h3>Step 1</h3>
		<p>Add <code>127.0.0.1 lola</code> to your hosts file.</p>
		<h3>Step 2</h3>
		<p>Update the <code>rootHttp</code> global in <strong>app/Lola.php</strong> to your default sites location </p>
		<h3>Step 3</h3>
		<p>Add <code>Include <?php echo $docRoot.$hostsDir;?> </code> to the <strong>bottom</strong> of your httpd.conf file.</p>

		<h3>Step 4</h3>
		<p>Copy the contents of your servers httpd-vhosts.conf file into <strong>app/_vhosts/hosts.conf</strong>, be sure to remove any reference to localhost, but just make sure that http-vhosts.conf has one line: <code>NameVirtualHost *:80</code></p>

		<h3>Step 5</h3>
		<p>Copy the below to the top of <strong>app/_vhosts/hosts.conf</strong></p>
		<textarea>
<VirtualHost *:80>
    ServerAdmin you@yoursite.com
    DocumentRoot "<?php echo $docRoot;?>"
    ServerName lola
    <Directory <?php echo $docRoot;?>>
      Order Deny,Allow
      Allow from all
    </Directory>
</VirtualHost>
		</textarea>
		 <h3>Final step</h3>
		 <p>Delete or underscore the install folder, restart apache and <a href="http://lola">click here</a> to begin adding websites.</p>
		</div>
 	</div>
 </head>
 <body>
 </body>
 </html>