<html>
    <head>
        <title>Sign_Up</title>
        <link rel = "stylesheet" href = "Styles\signup.css">
    </head>
    <body>
    <h1> Welcome To Online Vehicle Parking System </h1>
    <div class = "style2">
        <form method = 'POST' action = "">
            <h2> SignUp </h2>
            <label for = 'username'> Username </label>
            <input type = 'text' id = 'Username' name = 'username' autocomplete="off" required>
            <br><br>
            <label for = 'password'> Password </label>
            <input type = 'password' id = 'Password' name = 'password' autocomplete="off" required>
            <br><br>
            <label for = 'phonenumber'> Phone Number </label>
            <input type = 'text' id = 'phonenumber' name = 'phonenumber' autocomplete="off" required>
            <br><br>
            <input type = 'submit' class = 'signup'  name = 'signup' value = 'SIGNUP'>
            <br>
        </form>
        Already Have An Account! <a href = "index.php"> <button class = 'login'> LOGIN </button>
    </div>
    </body>
</html>

<?php
    session_start();
        if(isset($_POST['signup']))
        {
            $uname = $_POST['username'];
            $upassword = $_POST['password'];
            $phnnumber = $_POST['phonenumber'];

            function validatePhoneNumber($phnnumber) 
            {
                // Remove any non-numeric characters
                $phnnumber = preg_replace('/[^0-9]/', '', $phnnumber);
            
                // Check if the phone number is exactly 10 digits
                if (strlen($phnnumber) == 10) {
                    return true; // Valid phone number
                } else {
                    return false; // Invalid phone number
                }
            }

            function validatePassword($upassword) 
            {
                $errors = [];
            
                // Minimum length requirement
                if (strlen($upassword) < 8) {
                    $errors[] = "Password must be at least 8 characters long.";
                }
            
                // Check for at least one uppercase letter
                if (!preg_match('/[A-Z]/', $upassword)) {
                    $errors[] = "Password must contain at least one uppercase letter.";
                }
            
                // Check for at least one lowercase letter
                if (!preg_match('/[a-z]/', $upassword)) {
                    $errors[] = "Password must contain at least one lowercase letter.";
                }
            
                // Check for at least one digit
                if (!preg_match('/\d/', $upassword)) {
                    $errors[] = "Password must contain at least one digit.";
                }
            
                // Check for at least one special character
                if (!preg_match('/[^A-Za-z0-9]/', $upassword)) {
                    $errors[] = "Password must contain at least one special character.";
                }
            
                return $errors;
            }
            
            $passwordErrors = validatePassword($upassword);

            if (validatePhoneNumber($phnnumber) && empty($passwordErrors)) 
            {
                // echo "Valid phone number: $phnnumber";

                $con = mysqli_connect("localhost","root","","parkingsystem");
    
                if(!$con)
                {
                    die("Connection Failed".mysqli_connect_error(die));
                }
                

                $sql = "insert into users (username,password,phonenumber) values ('$uname','$upassword','$phnnumber')";

                try
                {
                    if(mysqli_query($con,$sql))
                    {
                        echo "<script> alert('User Successfully Created') </script>";

                        sleep(2);

                        echo"<script>window.location='slotbooking.php';</script>";
                    }
                    else
                    {
                        echo "<script> alert('Error in creating a User') </script>";
                    }
                }
                catch(Exception $e)
                {
                    echo "<script>alert('Enter Username and Password to Register')</script>";
                }
            } 
            else 
            {
                if (!validatePhoneNumber($phnnumber)) 
                {
                    echo "<script>alert('Enter a valid phone number')</script>";
                }
            
                if (!empty($passwordErrors)) 
                {
                    echo "<script>alert('Password is not valid. Errors: " . implode(", ", $passwordErrors) . "')</script>";
                }
            }
        }
?>

