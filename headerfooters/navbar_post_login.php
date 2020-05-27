<?php
    
    if($_SESSION['email']=='NULL'){
        header('Location: signin.php');
    }
    if(isset($_POST['logout'])){
        $_SESSION['email']='NULL';
        $_SESSION['name']='NULL';
        header('Location: index.php');
    }
    if(isset($_POST['delete'])){
        //create connection
        $conn = mysqli_connect('localhost','Cryptowallet','4PLJ0AoqqdExiL1W','cryptowallet');
        //check connection
        if(!$conn){
            echo 'errro: '.mysqli_connect_error();
        }
        $sql = "DELETE FROM USERDETAILS WHERE Email='$email'";
        $result=mysqli_query($conn,$sql);
        $sql = "DELETE FROM RECORDS WHERE Email='$email'";
        $result=mysqli_query($conn,$sql);


    }
?>



<nav class="navbar navbar-expand-sm navbar-dark bg-gold">
  <a class="navbar-brand" href="dashboard.php">CryptoWallet</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="addRecord.php">Add Record</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="records.php">Records</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link " href="statistics.php">Statistics</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="planedpayments.php">Planed Payments</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['name']?>
        </a>
        <div class="dropdown-menu bg-gold" style="border:0px;" aria-labelledby="navbarDropdown">
          <a class="dropdown-item dropdown-mod" href="#">Change Password</a>
          <form class=" " method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <button type="submit" name="logout" class="dropdown-item dropdown-mod">Log out</button>
          </form>
          <form class=" " method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <button type="submit" name="delete" class="dropdown-item dropdown-mod" style=" color:red;">Delete user data</button>
          </form>
        </div>
      </li>

    </ul>
  </div>
</nav>



</body>
</html>
