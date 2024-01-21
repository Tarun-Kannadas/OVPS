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
      color: white;
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
    .username,.account,.date,.actions{
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
      if ($con->connect_error) {
          die("Connection failed: " . $con->connect_error);
      }
      $usersel="SELECT
      userid,
      username,
      isadmin
      from users
      where isadmin=0 && banstatus=1";

      $runusersel=mysqli_query($con,$usersel);
      if (mysqli_num_rows($runusersel) > 0) {
        while ($row = mysqli_fetch_assoc($runusersel)) 
        {
          $id=$row['userid'];
          echo"<div class=items>";
            echo"<div class=username>";
              echo "<span class=textthing>Username </span>";
              echo $row['username'];
            echo"</div>";
            echo" <div class=actions>";
              echo"<form action='' method=post>";
              echo "<input type=hidden name='userid' value='$id'>";
              echo"<input type=submit name=unban value='UnBan User' class=ban_button>";
              echo"</form>";
            echo"</div>";
          echo"</div>";
      }
    } else {
        echo "No banned users found";
    }
    if(isset($_POST['unban']))
    {
      $userid = $_POST['userid'];
      $upd="UPDATE `users` SET `banstatus`=0 WHERE `userid`=$userid";
      $dataupd=mysqli_query($con,$upd);
      echo "<script>alert('User has been unbanned')</script>";
      header("Refresh: 0");

    }
    mysqli_close($con);
    ?>
    </div>
</body>
</html>