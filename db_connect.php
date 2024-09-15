<?php



$conn;
function connect()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "party";
    if (!isset($conn)) {
        global $conn;
        $conn = new mysqli($servername, $username, $password, $database);
    }
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

function iud($q)
{
    connect();
    global $conn;
    $conn->query($q);

}

function search($q){
   connect();
   global $conn;
   $result = $conn->query($q);
   return $result;

}




?>