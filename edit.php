<?php include('headerfooters/Initial_Plugin.php'); ?>
<?php include('headerfooters\navbar_post_login.php'); ?>
<?php 
    //create connection
    $conn = mysqli_connect('localhost','Cryptowallet','4PLJ0AoqqdExiL1W','cryptowallet');
    //check connection
    if(!$conn){
    echo 'errro: '.mysqli_connect_error();
    }    
    //check GET request id prameter
    if(isset($_GET['id'])){
        $id=mysqli_real_escape_string($conn,$_GET['id']);
    }
    $sql="SELECT * FROM RECORDS WHERE id=$id";
    //get query results
    $result=mysqli_query($conn,$sql);
    //fetch result in array
    $record=mysqli_fetch_assoc($result);
    $_SESSION['id']=$id;
    $_SESSION['recordtype']=$record['recordtype'];
    $_SESSION['payee']=$record['payee'];
    $_SESSION['amount']=$record['amount'];
    $_SESSION['date']=$record['date'];
    $_SESSION['category']=$record['category'];
    $_SESSION['paymenttype']=$record['paymenttype'];
    $_SESSION['currency']=$record['currency'];
    $_SESSION['status']=$record['status'];
    header('Location: editRecord.php');
?>