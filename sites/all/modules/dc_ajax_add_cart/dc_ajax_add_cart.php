<?php
$erl = error_reporting(E_ALL);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cottagehills";


if(!empty($_POST)){
$Q=$_POST;

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$name=htmlspecialchars(trim(strip_tags($Q['name'])));

$middle=htmlspecialchars(trim(strip_tags($Q['middle'])));
$sides=/*htmlspecialchars(trim(strip_tags(*/$Q['sides']/*,"<br>")))*/;
$sql = "UPDATE commerce_line_item SET name='".$name."', middle='".$middle."', side='".$sides."' WHERE line_item_id='".$Q['lid']."'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
$conn->close();
unset($_POST);
}







if(!empty($_GET)){
$Q=$_GET;

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
} 
$q=(int)$Q['q'];
$sql = "SELECT side FROM commerce_line_item WHERE line_item_id = '".$q."'  AND  side IS NOT NULL";
//$sql = "SELECT side FROM commerce_line_item WHERE order_id = '".$q."'  AND  side IS NOT NULL";
$dat="";
if ($result= $conn->query($sql)) {
  $data = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row["side"];
    $dat = $row["side"];
  }
   echo $dat;
//echo json_encode($data);
    mysqli_free_result($result);//"Record updated successfully";
}else {
    echo "Error selecting record: " . $conn->error;
}
$conn->close();
unset($conn);
unset($_GET);
}
?>