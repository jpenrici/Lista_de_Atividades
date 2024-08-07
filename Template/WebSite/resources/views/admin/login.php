<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/login.css">
    <title>Login Form</title>
</head>

<body>

    <form action="validate.php" method="POST">
        <div class="container">
            <h1>Login</h1>
            <hr>
            <input type="hidden" name="validate" value="login">
            <label>Username</label>
            <input type="text" placeholder="Enter Username or Email" name="username" id="username" required>
            <br>
            <label>Password</label>
            <input type="password" placeholder="Enter Password" name="password" id="password" required>
            <br>
            <div class="clearfix">
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
                <button type="submit" class="confirmbtn">Login</button>
            </div>
            <div style="padding: 8px; background-color:#f1f1f1">
                <button type="button" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
        </div>
    </form>

</body>

</html>