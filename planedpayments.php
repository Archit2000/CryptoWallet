<?php include('headerfooters/Initial_Plugin.php'); ?>
<?php include('headerfooters\navbar_post_login.php'); ?>
<?php
    //create connection
    $conn = mysqli_connect('localhost','Cryptowallet','4PLJ0AoqqdExiL1W','cryptowallet');
    //check connection
    if(!$conn){
    echo 'errro: '.mysqli_connect_error();
}
    $email=mysqli_real_escape_string($conn, $_SESSION['email']);
    $sql="SELECT id,category,amount,payee,date,status,paymenttype FROM RECORDS WHERE EMAIL='$email' && STATUS='Uncleared' ORDER BY date desc ";
    $result=mysqli_query($conn,$sql);
    $records=mysqli_fetch_all($result, MYSQLI_ASSOC);
?>


<div class="row mx-auto align-self-center" style="margin-top:10px;">
    <h1 class="row mx-auto align-self-center font-weight-bold" style="color:#f9a602;">Records</h1>
</div>
<div class="row mx-auto align-self-center">
<?php foreach($records as $record){ ?>    
    <div class="col card bg-light shadow" style="margin:10px; min-width:280px; width:25%; max-width:360px;">       
        <table class="table table-borderless" style="margin-bottom:0px;">
            <tr>
                <td ><?php echo htmlspecialchars($record['category']); ?></td>
                <?php if($record['amount']<0){?>
                <td class="text-right text-danger"><?php echo htmlspecialchars($record['amount']); ?></td>
                <?php } ?>
                <?php if($record['amount']>0){?>
                <td class="text-right text-success"><?php echo htmlspecialchars($record['amount']); ?></td>
                <?php } ?>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($record['payee']); ?></td>
                <td class="text-right"><?php echo htmlspecialchars($record['date']); ?></td>
            </tr>
            <tr>
                <?php if($record['status']=='Cleared'){?>
                <td><span class="badge badge-success">Cleared</span></td>
                <?php } ?>
                <?php if($record['status']=='Uncleared'){?>
                <td><span class="badge badge-danger">Uncleared</span></td>
                <?php } ?>
                <td class="text-right"><?php echo htmlspecialchars($record['paymenttype']); ?></td>
            </tr>
            
            <tr>
                <td colspan='2' style="text-align:center;">
                    <a class="btn btn-primary" style="margin:1px; width:31%;" href="details.php?id=<?php echo $record['id'];?>">Details</a>
                    <a class="btn btn-success" style="margin:1px; width:31%;" href="edit.php?id=<?php echo $record['id'];?>">Edit</a>
                    <a class="btn btn-danger" style="margin:1px; width:31%;" href="deleterecord.php?id=<?php echo $record['id'];?>">Delete</a>
                </td>
            </tr>
        </table>   
    </div>
<?php } ?>
</div>
