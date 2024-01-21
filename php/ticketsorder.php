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
    .username,.slot,.plate,.timein,.timeout,.price,.payment,.extratime,.extraprice,.ticketnumber{
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
      
      if (!$con) 
      {
          die("Connection failed! " . mysqli_connect_error(die));
      }

      $usersel="SELECT
                u.userid,
                u.username,
                s.slotnum ,
                t.ticketid,
                t.numberplate,
                t.timein,
                t.timeout,
                t.extratime,
                p.price,
                p.paymentid,
                p.extraprice
              FROM
                  users u
              JOIN
                  tickets t ON u.userid = t.userid
              JOIN
                  slot s ON t.ticketid = s.ticketid
              LEFT JOIN
                  payment p ON s.slotnum = p.slotnum;
              ";

      $runusersel=mysqli_query($con,$usersel);

      if (mysqli_num_rows($runusersel) > 0) 
      {
        while ($row = mysqli_fetch_assoc($runusersel)) 
        {
          $id=$row['ticketid'];
          echo"<div class=items>";
            echo"<div class=ticketnumber>";
              echo "<span class=textthing>Ticket Number</span>";
              echo '#'.$row['ticketid'];
            echo"</div>";
            echo"<div class=username>";
              echo "<span class=textthing>Username</span>";
              echo $row['username'];
            echo"</div>";
            echo"<div class=slot>";
              echo "<span class=textthing>SlotNumber</span>";
              echo '#'.$row['slotnum'];
            echo"</div>";
            echo"<div class=plate>";
              echo "<span class=textthing>Numberplate</span>";
              echo $row['numberplate'];
            echo"</div>";
            echo"<div class=timein>";
              echo "<span class=textthing>Time In</span>";
              echo $row['timein'];
            echo"</div>";
            echo"<div class=timeout>";
              echo "<span class=textthing>Time Out</span>";
              echo $row['timeout'];
            echo"</div>";
            echo"<div class=payment>";
              echo "<span class=textthing>Billing Number</span>";
              echo '#'.$row['paymentid'];
            echo"</div>";
            echo"<div class=price>";
              echo "<span class=textthing>Price</span>";
              echo '$'.$row['price'];
            echo"</div>";
            echo"<div class=extratime>";
              echo "<span class=textthing>Additional Time</span>";
              echo $row['extratime'].'hrs';
            echo"</div>";
            echo"<div class=extraprice>";
              echo "<span class=textthing>Additional Time Price</span>";
              echo '$'.$row['extraprice'];
            echo"</div>";
            
            echo" <div class=actions>";
              echo"<form action='' method=post>";
              echo "<input type=hidden name='ticketnum' value='$id'>";
              echo"<input type=submit name=delete value='Delete Ticket' class=ban_button>";
              echo"</form>";
            echo"</div>";
          echo"</div>";
      }
    } 
    else 
    {
        echo "No Ticket details found";
    }
    if (isset($_POST['delete'])) 
        {
                $id=$_POST['ticketnum'];

                $delpay="DELETE FROM payment WHERE slotnum IN (SELECT slotnum FROM slot WHERE ticketid =$id)";
                $delslot="UPDATE `slot` SET `status`=0,`ticketid`=null WHERE ticketid =$id";
                $delticket="DELETE FROM tickets WHERE ticketid =$id" ;
                $data=mysqli_query($con,$delpay);
                $data1=mysqli_query($con,$delslot);
                // $data2=mysqli_query($con,$insslot);
                $data3=mysqli_query($con,$delticket);
                if($data&&$data1&&$data3)
                {
                    echo"<script>
                        alert('Ticket $id has been successfully deleted.');
                        window.location.href = 'orders.php'; // Reload the page
                        </script>";
                }
              }
    mysqli_close($con);
    ?>
    </div>
</body>
</html>