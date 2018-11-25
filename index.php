<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN"
    "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<?php
require('config.inc.php');
?>
<html lang="fr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Aliases</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" id="viewport">
    <meta name="robots" content="noindex,nofollow,noarchive" />
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/aliases.css" rel="stylesheet" media="screen">
    <!-- IOS icons -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" type="image/png" href="<?php echo $config["icon_prefix"]; ?>apple-icon-57x57.png" />
    <link rel="apple-touch-icon" href="<?php echo $config["icon_prefix"]; ?>apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $config["icon_prefix"]; ?>apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $config["icon_prefix"]; ?>apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $config["icon_prefix"]; ?>apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $config["icon_prefix"]; ?>apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $config["icon_prefix"]; ?>apple-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $config["icon_prefix"]; ?>apple-icon-180x180.png" />
    <link rel="apple-touch-startup-image" href="<?php echo $config["icon_prefix"]; ?>apple-icon-144x144.png">
    <meta name="apple-mobile-web-app-title" content="Aliases">
  </head>
  <body>
    <script src="js/aliases.js"></script>
<div class="container">
  <?php
$alias = $_POST["alias"];
$newalias = $_POST["newalias"];
?>
<div id="form">
    <h1>Aliases management</h1>
	<form method="post" class="navbar-form pull-left">
	  <input name="newalias" type="checkbox" class="span1">
	  <input name="alias" type="text" class="search-query" autocapitalize="none" value="<?php echo $alias ?>">
	  <button type="submit" class="btn">Submit</button>
	</form>
</div>
<?php
// Create connection
$conn = new mysqli($config["server"], $config["username"], $config["password"], $config["dbname"]);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($newalias != '') {
	$conn_rw = new mysqli($config["server"], $config["username_rw"], $config["password_rw"], $config["dbname"]);
	if ($conn_rw->connect_error) {
		die("Connection failed: " . $conn_rw->connect_error);
	} 
	$sql = sprintf( "INSERT INTO postfix_alias (alias, destination) VALUES ('%s', '%s')", $alias, $config["alias_target"]);
	if ($conn_rw->query($sql) === TRUE) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn_rw->error;
	}
	$conn_rw->close();
}

if ($alias != '') {
$sql = "SELECT alias, destination, enable FROM postfix_alias where alias like '%" . $alias . "%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo '<table class="table">';
	echo '<thead><tr><td>Alias</td><td>Destination</td><td>Enable</td></tr></thead>';
	echo '<tbody>';
	while($row = $result->fetch_assoc()) {
		$alias_to = $row["alias"] . '@' . $config["alias_domain"];
		echo "<tr><td><span onClick=\"copyToClipboard('". $alias_to . "')\" id='alias'>" . $row["alias"] . "</span></td><td>" . $row["destination"]. "</td><td>" . $row["enable"]. "</td></tr>";
	}
	echo '</tbody>';
	echo '</table>';
} else {
	echo "<br/><br/>0 results";
}
}
?>
<div id="message" class="alert alert-success" role="alert"></div>
<div>Total:
<?php

$sql = "SELECT count(*) as total FROM postfix_alias where enable = 1 AND destination = '" . $config["alias_target"] . "'";
$result = $conn->query($sql);

$data = $result->fetch_array();

echo $data['total'];

$conn->close();

?>
</div>
</div>
    <script src="<?php echo $config["jquery_prefix"]; ?>jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
