<!DOCTYPE html>
<html lang="en">
<head>
<STYLE>
  body
    {
      color:aliceblue;
      background: rgb(49, 49, 49);
    }
    .textthing{
      color:lightcoral
    }
    .users{
      display: flex;
      flex-direction: column;
    }
    .profile{
      width: 100px;
    }
    .items{
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      font-size: 25px;
      border: 5px solid aliceblue;
      background-color:rgba(71, 61, 139, 0.486);

    }
    .username,.slot,.plate,.timein,.timeout,.price,.payment{
      display: flex;
      flex-direction: column;
      flex:1;
    }
    .email{
      flex:2;
    }
    .ban_button{
      padding: 10px;
      background-color: rgba(255, 0, 0, 0.603);
      color: white;
      border: none;
      border-radius: 5px;
    }
    .ban_button:hover{
      background-color: red;
    }
  </STYLE>
</head>
<body>
  <div class=users>
  <?php

      $con = mysqli_connect("localhost", "root", "", "parkingsystem");

      if ($con->connect_error) 
      {
          die("Connection failed: " . $con->connect_error);
      }
      $usersel="SELECT * from feedbacks";

      $runusersel = mysqli_query($con,$usersel);
      if (mysqli_num_rows($runusersel) > 0) 
      {
        while ($row = mysqli_fetch_assoc($runusersel)) 
        {
          $id = $row['feedbackid'];
          echo"<div class=items>";
            echo"<div class=username>";
              echo "<span class=textthing>Feedback Number</span>";
              echo '#'.$row['feedbackid'];
            echo"</div>";
            echo"<div class=slot>";
              echo "<span class=textthing>Username</span>";
              echo $row['username'];
            echo"</div>";
            echo"<div class=plate>";
              echo "<span class=textthing>Phone Number</span>";
              echo $row['phonenumber'];
            echo"</div>";
            echo"<div class=timeout>";
              echo "<span class=textthing>Feedback</span>";
              echo $row['feedback'];
            echo"</div>";
            // echo"<div class=payment>";
            //   echo "<span class=textthing>Billing Number</span>";
            //   echo $row['paymentid'];
            // echo"</div>";
            // echo"<div class=price>";
            //   echo "<span class=textthing>Price</span>";
            //   echo $row['price'];
            // echo"</div>";
            
            echo" <div class=actions>";
              echo"<form action='' method=post>";
              echo "<input type=hidden name='feedbackid' value='$id'>";
              echo"<input type=submit name=delete value='Delete Ticket' class=ban_button>";
              echo"</form>";
            echo"</div>";
          echo"</div>";
      }
    } 
    else 
    {
        echo "No Feedbacks Found";
    }

    if (isset($_POST['delete'])) 
    {
        $id = $_POST['feedbackid'];

        $delpay="DELETE FROM feedbacks WHERE feedbackid = $id";
        $data=mysqli_query($con,$delpay);
        if($data)
        {
            echo"<script>
                alert('Feedback of $id has been successfully deleted.');
                window.location.href = 'feedbackview.php'; // Reload the page
                </script>";
        }
        else
        {
            echo"<script>alert('Feedback Number $id has been successfully deleted.')</script>";
        }
    }
    mysqli_close($con);
    ?>
    </div>
</body>
</html>