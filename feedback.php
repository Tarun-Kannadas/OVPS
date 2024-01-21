<!-- Existing problem is duplication code ain't ready -->

<html>
<head>
    <title>FeedBack Form</title>
    <link rel = "stylesheet" href = "Styles/feedback.css">
</head>
<body>
    <?php include 'menu.php' ?>
    <br><br>
    <div class = "centering">
        <div class = "centerstyle2">
            <h1>Feedback Form</h1>
            <form action = "" method = "post">
                <?php 

                    $id = $_SESSION['id'];

                    $con = mysqli_connect("localhost","root","","parkingsystem");

                    $sql2 = "SELECT username,phonenumber from users where userid = $id";

                    $result = mysqli_query($con, $sql2);

                    $row = mysqli_fetch_assoc($result);

                    $username = $row['username'];
                    $phonenumber = $row['phonenumber'];

                    // echo $username,$phonenumber;
                
                ?>
                <?php echo "<label class = 'username'>Username: $username </label>"; ?>
                <br><br><br>
                <?php echo "<label class = 'phonenumber'>Phone Number: $phonenumber </label>"; ?>             
                <br><br><br>
                <center><label for = "feedback" class = "feedback" value = "feedback">Give Your Feedback Below:</label></center>
                <textarea id="feedback" name = "feedback" placeholder = "Type in your valuable thoughts" rows="4" cols="25" required></textarea>
                <br><br>
                <input type="submit" class = "submit" name = "submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>

<?php

    if (isset($_POST['submit'])) 
    {

        $Feedback = $_POST['feedback'];

        $con = mysqli_connect("localhost", "root", "", "parkingsystem");

        if (!$con) 
        {
            die("Connection Failed!" . mysqli_connect_error());
        }

        // Check if the phone number exists in the credential table
        $checkPhoneNumberQuery = "SELECT * FROM users WHERE username = '$username' AND phonenumber = '$phonenumber'";
        
        $result = mysqli_query($con, $checkPhoneNumberQuery);

        if (mysqli_num_rows($result) > 0) 
        {
        // Phone number exists in the credential table, proceed with inserting feedback
            $sql = "INSERT INTO feedbacks (username, phonenumber, feedback, userid) VALUES ('$username', '$phonenumber', '$Feedback','$id')";

            $query = mysqli_query($con, $sql);

            try 
            {
                if ($query) 
                {
                    echo "<script>alert('Feedback Successfully Submitted')</script>";
                    
                    sleep(0.5);

                    echo "<script>window.location.href = 'ticket.php';</script>";
                } 
                else 
                {
                    echo "<script>alert('Error in Submitting')</script>";

                    sleep(0.5);
                }
            } 
            catch (Exception $e) 
            {
                echo "Type in your valuable Feedback";

                sleep(0.5);
            }
        } 
        else 
        {
            // Phone number does not exist in the credential table, show an error message
            echo "<script>alert('Invalid Username or Phone Number')</script>";

            sleep(0.5);
        }

        $updateFeedbackStatusQuery = "UPDATE users SET feedbackgiven = 1 WHERE id = '$id'";
        mysqli_query($con, $updateFeedbackStatusQuery);

    }
    mysqli_close($con);
?>

<!-- Existing problem is duplication code ain't ready -->