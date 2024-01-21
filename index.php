<html>
    <head>
        <title> Login_In</title>
        <link rel = "stylesheet" href = "Styles\signup.css">
    </head>
    <body>
    <h1> Welcome To Online Vehicle Parking System </h1>
    <div class = "style1">
        <form method = 'POST' action = "">
            <h2> Login </h2>
            <label for = 'username'> Username </label>
            <input type = 'text' id = 'Username' name = 'username' autocomplete="off">
            <br><br>
            <label for = 'password'> Password </label>
            <input type = 'password' id = 'Password' name = 'password' autocomplete="off">
            <br><br>
            <input type = 'submit' class = 'login' name = 'login' value = 'LOGIN'>
            <br>
        </form>
        <br>
        Don't Have An Account? <a href = "signup.php"> <button class = 'signup'> SIGNUP </button> </a>
    </div>
    </body>
</html>

<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $uname = $_POST["username"];
        $upassword = $_POST["password"];

        $con = mysqli_connect("localhost","root","","parkingsystem");

        $sql = "select * from users where username = '$uname' AND password = '$upassword'";

        $result = mysqli_query($con,$sql);

        if ($result && mysqli_num_rows($result) == 1) 
        {

            $row = mysqli_fetch_assoc($result);

            $_SESSION["isadmin"] = $row["isadmin"];
            $_SESSION["id"] = $row["userid"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["phnnumber"] = $row["phonenumber"];

            if($row["isadmin"]==0)
            {
                if($row['banstatus']==1)
                {
                    echo "<script>alert('$uname is Banned.\\nContact admin.');</script>";
                    exit();

                }
                else
                {
            header("Location: homepage.php");
            exit();
                }
            }
            else
            {
                header("Location: admin.php");
                exit();
            }
        } 
        else 
        {
            echo "</br>Login failed. Please <a href='index.php'>try again</a>.";
        }
    }
?>