<?php
  $servername = "localhost";
  $uname = "root";
  $password = "";
  $dbname = 'siimteq_work';
  
  // connect web app with mysql server
  $con = mysqli_connect($servername, $uname, $password, $dbname);
  
  // check that connection with mysql server is established or not
  if (!$con) {
      die("Connection failed" . mysqli_connect_error());
  } else {
      // die("Connected with Database");
  }
  
//   mysqli_close($con);