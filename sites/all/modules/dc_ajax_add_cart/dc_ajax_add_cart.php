<?php
$erl = error_reporting(E_ALL);


//$servername = "cottage.c8ev03tuhhye.us-west-2.rds.amazonaws.com";
$servername = "cottage-restored.c8ev03tuhhye.us-west-2.rds.amazonaws.com";
$username = "cottage";
$password = "5iaGNy4RXryLsQzl";
$dbname = "cottagelive";
//$servername = "localhost";//PUT YOUR SERVER HERE
//$username = "root";//YOUR USER HERE
//$password = "";//YOUR PASSWORD HERE
//$dbname = "cottagehills";//YOUR DB NAME HERE

if(!empty($_POST)){
$Q=$_POST;

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$name= /*htmlspecialchars(trim(strip_tags(*/rawurldecode($Q['name'])/*)))*/;
$name = trim(strip_tags($name));
$name = rawurlencode($name);

$middle=/*htmlspecialchars(rawurlencode(trim(strip_tags(rawurldecode(*/rawurlencode($Q['middle'])/*))))*/;
/*$middle = trim(strip_tags($middle));
$middle = rawurlencode($middle);*/

$tempsides = array();
$temsides = rawurldecode($Q['sides']);
$tempsides = json_decode($temsides);
foreach ($tempsides as $key => $value) {
    $tempsides[$key]=rawurlencode($tempsides[$key]);
}
$sides=json_encode($tempsides);


//$sides=/*htmlspecialchars(trim(strip_tags(*/$Q['sides']/*,"<br>")))*/;
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
