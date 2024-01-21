<?php
session_start();
$username=$_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="Styles/admin.css">

</head>
<body>
    <div class="header">
        <div class="left">
            <button class="button" onclick="showList('userlistiframe')">User List</button>
            <button class="button" onclick="showList('banuserlistiframe')">Banned User List</button>
            <button class="button" onclick="showList('slotlistiframe')">Slot List</button>
            <button class="button" onclick="showList('ordersiframe')">Tickets</button>
            <button class="button" onclick="showList('feedbackiframe')">Feedbacks</button>
            <button class="button" onclick="showList('reportiframe')">Daywise Visitors</button>
            <button class="button" onclick="showList('incomeiframe')">Income per Vehicle Type</button>
            <button class="button" onclick="showList('expirediframe')">Expired Tickets</button>
            <!-- <div class="items"> -->
                <!-- <p class="two">
                    <?php 
                        // echo "$username Panel" 
                    ?>
                </p> -->
                <p></p>
                <p><a href="logout.php" class = 'three'>Logout</a></p>
            <!-- </div> -->
        </div>
        <!-- <div class="middle"></div> -->
        <!-- <div class="right"></div> -->
    </div>
    <div class="iframesection">
        <iframe id="userlistiframe" class="iframe-container" src="php/users.php" width="100%" height="100%" frameborder="0"></iframe>
        <iframe id="banuserlistiframe" class="iframe-container" src="php/unbanuser.php" width="100%" height="100%" frameborder="0"></iframe>
        <iframe id="slotlistiframe" class="iframe-container" src="php/slots.php" width="100%" height="100%" frameborder="0"></iframe>
        <iframe id="ordersiframe" class="iframe-container" src="php/ticketsorder.php" width="100%" height="100%" frameborder="0"></iframe>
        <iframe id="feedbackiframe" class="iframe-container" src="php/feedbackview.php" width="100%" height="100%" frameborder="0"></iframe>
        <iframe id="reportiframe" class="iframe-container" src="php/report.php" width="100%" height="100%" frameborder="0"></iframe>
        <iframe id="incomeiframe" class="iframe-container" src="php/income.php" width="100%" height="100%" frameborder="0"></iframe>
        <iframe id="expirediframe" class="iframe-container" src="php/expiredtickets.php" width="100%" height="100%" frameborder="0"></iframe>
    </div>
</body>
<script>
    function showList(iframeId) 
    {
        var frame = document.getElementById(iframeId);
        
        var iframes = document.querySelectorAll(".iframe-container");
        iframes.forEach(function(iframe) 
        {
            iframe.style.display = "none";
            iframe.contentWindow.location.reload();
        });

        frame.style.display = "block";
        frame.contentWindow.location.reload();

    }
</script>
</html>