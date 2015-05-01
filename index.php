<!DOCTYPE html>
<html>
  <head>
    <title>Aliases management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  </head>
  <body>
<div class="container">
  <?php
$alias = $_POST["alias"];
$newalias = $_POST["newalias"];
?>
    <h1>Aliases management</h1>
<form method="post" class="navbar-form pull-left">
<input name="newalias" type="text" class="span2">
<input name="alias" type="text" class="search-query" value="<?php echo $alias ?>">
  <button type="submit" class="btn">Submit</button>
</form>
<?php
require('config.inc.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($newalias != '') {
	$username_rw = "postfix_rw";
	$password_rw = "tmYtp3GxXGGz8x64";
	$conn_rw = new mysqli($servername, $username_rw, $password_rw, $dbname);
	if ($conn_rw->connect_error) {
		die("Connection failed: " . $conn_rw->connect_error);
	} 
	$sql = "INSERT INTO postfix_alias (alias, destination) VALUES ('$newalias', '$alias_target')";
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
		echo "<tr><td>" . $row["alias"]. "</td><td>" . $row["destination"]. "</td><td>" . $row["enable"]. "</td></tr>";
	}
	echo '</tbody>';
	echo '</table>';
} else {
	echo "0 results";
}
}

$conn->close();

?>
<div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
