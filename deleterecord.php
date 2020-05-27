<?php include('headerfooters/Initial_Plugin.php'); ?>
<?php include('headerfooters\navbar_post_login.php'); ?>


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
    $sql="SELECT * FROM RECORDS WHERE id=$id";
    //get query results
    $result=mysqli_query($conn,$sql);
    //fetch result in array
    $record=mysqli_fetch_assoc($result);
    

    if(isset($_POST['delete'])){
        // create sql
        $sql="DELETE FROM RECORDS WHERE ID=$id";
        $result=mysqli_query($conn,$sql);
        // save to db and check
        if(mysqli_query($conn, $sql)){
            header('Location: dashboard.php');
        } else if(mysqli_error($conn)){
            //$sqlerror= 'This Email address is already registered';
            echo("Error" . mysqli_error($conn));
        }     
    }



?>



<div style="margin-top:5%; padding-top:15px; padding-bottom:15px; border-radius:0.5rem; min-width:325px; width:80%;" class="col mx-auto align-self-center bg-light shadow">
        <h3 class="text-center" style="padding-bottom:15px;">RECORD DETAILS</h3>
        <form  method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="row">
                <div class="col-6" style="min-width:325px;">
                    <div class="form-group" >
                        <label>Record Type</label>
                        <div type="text" class="form-control"><?php echo $record['recordtype']; ?></div>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <div type="text" class="form-control"><?php echo $record['amount']; ?></div>
                    </div>
                    <div class="form-group ">
                        <label>Category</label>
                        <div type="text" class="form-control"><?php echo $record['category']; ?></div>
                    </div>
                    <div class="form-group ">
                        <label>Currency</label>
                        <div type="text" class="form-control"><?php echo $record['currency']; ?></div>
                    </div>
                </div>
                <div class="col-6" style="min-width:325px;">
                    <div class="form-group">
                        <label>Payee</label>
                        <div type="text" class="form-control"><?php echo $record['payee']; ?></div>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <div type="text" class="form-control"><?php echo $record['date']; ?></div>
                    </div>
                    <div class="form-group ">
                        <label>Payment Type</label>
                        <div type="text" class="form-control"><?php echo $record['paymenttype']; ?></div>
                    </div>
                    <div class="form-group ">
                        <label>Status</label>
                        <div type="text" class="form-control"><?php echo $record['status']; ?></div>
                    </div>
                </div>
            </div>
            <a href="delete.php?id=<?php echo $id?>" class="btn btn-danger btn-block" >Confirm Deletion</a>
        </form>
    </div>