<center>
<table width="700px">
    <tr>
        <td width='10%'><a href="healing.php">Healing</a></td>
        <td width='10%'><a href="salvage.php">Salvage</a></td>
        <?php 
        if (@$_SESSION['logged_in'] == true){
            ?><td width='10%'><a href="saved.php">Saved Options</a></td>
              <td width='10%'><a href="logout.php">Logout (<?php print $_SESSION['username']?>)</a></td>  
                <?php 
        }
        else{ ?>
            <td width='10%'></td>
            <td width='10%'><a href='login.php'>Login</a></td> <?php
        }
        ?>
        
    </tr>
</table>
</center>