<?php

  require("connect.php");
  header('Content-Type: application/json');
  session_start();
  $user = $_SESSION['user_name'];
  //echo $user;
  $sql="SELECT * FROM devices WHERE user_name='".$user."'";
  $json=[];
  $data;
  $result=$conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $sql="SELECT * FROM active WHERE device_id='".$row["device_id"]."'";
        $active=$conn->query($sql);
        $active=$active->num_rows;
        $time=time();
        $last=$row["last_seen"];
        $diff=(int)$time-(int)$last;
        if($diff>5000)$active=0;
        $data=$row;
        $data["last_seen"]=$diff;
        $data["active"]=$active;
        array_push($json,$data);
    }
  }
  echo json_encode($json);
?>
