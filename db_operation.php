<?php
class DBoperation
{
  private $servername="localhost";
  private $username="root";
  private $password="";
  private $db_name="finmanage";
  private $conn;

  //methods
  private function table_len($table,$col) //return row number
  {
    $sql="SELECT COUNT("."'".$col."'".")FROM ".$this->db_name.".".$table;
    $result=$this->conn->query($sql);
    $num=mysqli_fetch_array($result);
    return $num[0];
  }

  function __construct(){;}

  function DB_connect() //connect to db server
  {
    //create coonection
    $conn=new mysqli($this->servername,$this->username,$this->password);
    if($conn->connect_error)
    {
      die("Connection fail<br>".$conn->connect_error);
    }
    else
    {
      //echo"Connection successful<br>";
      $this->conn=$conn;
    }
  }

  function search_user($c_mail) //Check whether this email account is our user or not
  {
    $sql="SELECT * FROM finmanage.customer_info WHERE customer_mail="."'".$c_mail."'";
    $result=$this->conn->query($sql);
    if(!$result)
    {
      echo mysqli_error($this->conn);
    }
    else
    {
      $num=mysqli_num_rows($result);
      if($num==0)
      {
        return false;
      }
      return $result;
    }
  }

  function search_record($c_id,$print=true) //search customer transection record. Can choose either print the record or get latest total money
  {
    $sql="SELECT * FROM finmanage.trans_detail WHERE c_id='".$c_id."'";
    $result=mysqli_query($this->conn,$sql);
    $last_total=0;
    if(!$result)
    {
      echo mysqli_error($this->conn);
      return $last_total;
    }
    else
    {
      $num=mysqli_num_rows($result);
      if($num==0)
      {
        echo "No record<br>";
        return $last_total;
      }
      else
      {
        if($print)
        {
          echo"<table border='1' bordercolor='#00ff00' align='center' style='text-align".": center;'".">";
          echo"\t<thead>";
          echo"\t\t<tr>";
          echo"\t\t\t<th colspan='7'><font color='#00ff00'>交易明細</font></th>";
          echo"\t\t</tr>";
          echo"\t\t<tr>";
          echo"\t\t\t<td><font color='#00ff00'>交易編號</font></td>";
          echo"\t\t\t<td><font color='#00ff00'>顧客代碼</font></td>";
          echo"\t\t\t<td><font color='#00ff00'>收入</font></td>";
          echo"\t\t\t<td><font color='#00ff00'>支出</font></td>";
          echo"\t\t\t<td><font color='#00ff00'>餘額</font></td>";
          echo"\t\t\t<td><font color='#00ff00'>明細</font></td>";
          echo"\t\t\t<td><font color='#00ff00'>交易時間</font></td>";
          echo"\t</thead>";
          echo"\t<tbody>";
          for($i=0;$i<$num;$i++)
          {
            $row=mysqli_fetch_array($result);
            echo"\t\t<tr>";
            echo"\t\t\t<td><font color='#00ff00'>".$row['t_id']."</font></td>";
            echo"\t\t\t<td><font color='#00ff00'>".$row['c_id']."</font></td>";
            echo"\t\t\t<td><font color='#00ff00'>".$row['income']."</font></td>";
            echo"\t\t\t<td><font color='#00ff00'>".$row['cost']."</font></td>";
            echo"\t\t\t<td><font color='#00ff00'>".$row['total']."</font></td>";
            echo"\t\t\t<td><font color='#00ff00'>".$row['detail']."</font></td>";
            echo"\t\t\t<td><font color='#00ff00'>".$row['timestamp']."</font></td>";
            echo"\t\t</tr>";
          }
          echo"\t</tbody>";
          echo"</table>";
        }
        else
        {
          for($i=0;$i<$num;$i++)
          {
            $row=mysqli_fetch_array($result);
            if($i==$num-1)
            {
              $last_total=$row['total'];
              return $last_total;
            }
          }
        }
        mysqli_free_result($result);
      }
    }
  }

  function insert_user($userdata) //Insert new user
  {
    $sql="INSERT INTO finmanage.customer_info(customer_id,customer_name,customer_mail,customer_pwd)";
    $c_id;
    $c_id_num=$this->table_len("customer_info","customer_id")+1;
    $c_id_char='A';
    if($c_id_num<10)
    {
      $c_id_char=$c_id_char."00";
    }
    elseif ($c_id_num>=10 && $c_id_num<100)
    {
      $c_id_char=$c_id_char."0";
    }
    elseif ($c_id_num>999)
    {
      $c_id_char++;
    }
    $c_id=$c_id_char.$c_id_num;
    $c_name=$userdata[0];
    $c_mail=$userdata[1];
    $c_pwd=$userdata[2];
    $sql=$sql." VALUE("."'".$c_id."'".","."'".$c_name."'".","."'".$c_mail."'".","."'".$c_pwd."'".")";
    if($this->conn->query($sql))
    {
      echo"Data insert successfully<br>";
      return true;
    }
  }

  function insert_record($rec_data)//Insert transection record
  {
    $sql="INSERT INTO finmanage.trans_detail(t_id,c_id,income,cost,total,detail)";
    $t_id_num=$this->table_len("trans_detail","t_id")+1;
    $t_id_char='A';
    if($t_id_num<10)
    {
      $t_id_char.="0000";
    }
    elseif ($t_id_num>=10 && $t_id_num<100)
    {
      $t_id_char.="000";
    }
    elseif ($t_id_num>=100 && $t_id_num<1000)
    {
      $t_id_char.="00";
    }
    elseif ($t_id_num>=1000 && $t_id_num<10000)
    {
      $t_id_char.="0";
    }
    elseif ($t_id_num>99999)
    {
      $t_id_char++;
    }
    $t_id=$t_id_char.$t_id_num;
    $c_id=$rec_data[0];
    $income=$rec_data[1];
    $cost=$rec_data[2];
    $total=$this->search_record($c_id,$print=false)+$income-$cost;
    $detail=$rec_data[3];
    $sql.=" VALUE("."'".$t_id."'".","."'".$c_id."'".","."'".$income."'".","."'".$cost."'".","."'".$total."'".","."'".$detail."'".")";
    $result=$this->conn->query($sql);
    return $result;
  }

  function update_user($userdata)
  {
    $c_id=$userdata[0];
    $c_name=$userdata[1];
    $c_mail=$userdata[2];
    $c_pwd=$userdata[3];
    $sql="UPDATE finmanage.customer_info SET customer_name="."'".$c_name."',"." customer_mail="."'".$c_mail."',"." customer_pwd="."'".$c_pwd."'"." WHERE customer_id="."'".$c_id."'";
    //echo $sql;
    $result=$this->conn->query($sql);
    if($result)
    {
      //echo"Update successfully";
      return true;
    }
  }

  function close_connect()
  {
    $this->conn->close();
    echo"Connection close";
  }
}

/*$db=new DBoperation();
$db->DB_connect();
//$userdata=array('John','John@mail.com','5feceb66ffc86f38d952786c6d696c79c2dbc239dd4e91b46729d73a27fb57e9');
//$db->insert_user($userdata);
//$rec_data=array('A001','0','1000','salary');
//$db->insert_record($rec_data);
//$db->search_record('A001');
//$has_user=$db->search_user('John@mail.com');
//echo $has_user;
$update_data=array('A001','Ejohn','johm@mail.com','5feceb66ffc86f38d952786c6d696c79c2dbc239dd4e91b46729d73a27fb57e9');
$db->update_user($update_data);
$db->close_connect();*/
 ?>
