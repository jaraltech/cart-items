<form action="db.php" method="POST" id="login-form">
    <div class="login-body">
        <div class="title">
            <h5 class="login-title text-uppercase">Login Form</h5>
        </div>
        <hr>
            <input type="text" name="username" id="username" class="form-control">
            <input type="text" name="password" id="password" class="form-control">
        <hr>
        <div class="login-bottom">
            <button type="submit" name="login">Login</button>
            <p>Not a member? <a href="../auth/register.php">Register</a></p>
        </div>
    </div>
</form>