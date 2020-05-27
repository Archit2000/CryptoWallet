
<?php
    //create connection
    $conn = mysqli_connect('localhost','Cryptowallet','4PLJ0AoqqdExiL1W','cryptowallet');
    //check connection
    if(!$conn){
    echo 'errro: '.mysqli_connect_error();
    }
    $id='';    
    //check GET request id prameter
    if(isset($_GET['id'])){
        $id=mysqli_real_escape_string($conn,$_GET['id']);
    }
    $sql="DELETE FROM RECORDS WHERE id=$id";
    //get query results
    $result=mysqli_query($conn,$sql);
    header('Location: records.php');



?>