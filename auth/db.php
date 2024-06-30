<?php
include('conn.php');
session_start();

// Register
if (isset($_POST['register'])) {
    extract($_POST);
    $sql = "INSERT INTO users (username, password) 
        VALUES ('$username', '$password')";
    $res = mysqli_query($con, $sql);
    if ($res) {
        $sql = "SELECT * from users WHERE username = '$username' AND password = '$password'";
        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($res);
        if ($row['password'] == $password) {
            $_SESSION['username'] = $row['username'];
            header('Location:../index.php');
            exit();
        }
        header("Location: login.php");
    } else {
        mysqli_error($con);
    }
}

// Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * from users WHERE username = '$username' AND password = '$password'";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        die(mysqli_error($con));
    }
    $row = mysqli_fetch_assoc($res);

    // check that username & password exists in database
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        $uname = $row['username'];
        $id = $row['id'];
        $pass = $row['password'];
        // pass data using session
        $_SESSION['username'] =  $uname;
        $_SESSION['id'] =  $id;
        echo '<script>
        window.open("../index.php", "_self");
    </script>';
    } else {
        echo '<script>
        alert("Username and Password Not Match... Try Again!");
        window.open("login.php", "_self");
    </script>';
    }
}
