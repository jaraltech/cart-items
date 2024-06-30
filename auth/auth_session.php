<?php
session_start();
if (!isset($_SESSION["username"])) {
    echo "<script>
    alert('Please login First !!');
    window.open('./auth/login.php', '_self');
</script>";
}