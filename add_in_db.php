<?php 
    include('./auth/auth_session.php');
    include('./auth/conn.php');

    if(isset($_POST['item_id'])){
        $iid =  $_POST['item_id'];
        $qt = $_POST['quantity'];

        $sql = "INSERT into cart (uid, iid, quantity) values ('" . $_SESSION['id'] . "','$iid', '$qt')";
        $res = mysqli_query($con, $sql);
        if ($res) {
            echo "Added";
        } else {
            die(mysqli_error($con));
        }
    }
    if(isset($_POST['uitem_id'])){
        $iid =  $_POST['uitem_id'];
        $qt = $_POST['nq'];

        $sql = "UPDATE cart set quantity = '$qt' where iid='$iid' and uid='".$_SESSION['id']."'";
        $res = mysqli_query($con, $sql);
        if ($res) {
            echo "Updated";
        } else {
            die(mysqli_error($con));
        }
    }

?>