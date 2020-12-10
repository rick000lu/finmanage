<?php
class DBoperation
{
  private $servername="localhost";
  private $username="rick";
  private $password="krick000620";
  private $db_name="finmanage";

  //methods
  function __construct()
  {
    echo"Object constructed";
  }
  function DB_connect()
  {
    //create coonecrion
    $conn=new mysqli($this->$servername,$this->$username,$this->$password);
    if($conn->connect_error){
      die("Connection fail<br>".$conn->connect_error);
    }else {
      echo"Connection successful";
    }
  }
}

$db=new DBoperation();
$db->DB_connect();
 ?>
