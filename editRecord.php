<?php include('headerfooters/Initial_Plugin.php'); ?>
<?php include('headerfooters\navbar_post_login.php'); ?>
<?php
//create connection
$conn = mysqli_connect('localhost','Cryptowallet','4PLJ0AoqqdExiL1W','cryptowallet');
//check connection
if(!$conn){
    echo 'errro: '.mysqli_connect_error();
}
$sqlerror="";
$email=$recordtype = $category=$amount=$currency=$payee=$date=$paymenttype=$status= $sign='';
$errors = array('amount' => '','payee'=>'','date'=>'','incomplete'=>'Enter all the fields');

if(isset($_POST['editrecord'])){
    // check record type
    $recordtype = $_POST['recordtype'];
    if($recordtype=='Income')
        $sign=1;
    else {
        $sign=-1;
    }
    // check amount type
    $amount = intval($_POST['amount']);
    if($amount=""){
        $amount=$_SESSION['amount'];
    }
    // check category
    $category = $_POST['category'];
    if($category=""){
        $category=$_SESSION['category'];
    }
    // check currency type
    $currency = $_POST['currency'];
    if($currency=""){
        $currency=$_SESSION['currency'];
    }
    // check payee type
    $payee = $_POST['payee'];
    if($payee=""){
        $payee=$_SESSION['payee'];
    }
    // check date type and validation
    $date = $_POST['date'];
    if($date=""){
        $date=$_SESSION['date'];
    }
    // check payment type
    $paymenttype = $_POST['paymenttype'];
    if($paymenttype=""){
        $paymenttype=$_SESSION['paymenttype'];
    }
    // check status
    $status = $_POST['status'];
    if($status=""){
        $status=$_SESSION['status'];
    }
    //insert commands
    // escape sql chars
    $id=mysqli_real_escape_string($conn, $_SESSION['id']);
    $recordtype = mysqli_real_escape_string($conn, $_POST['recordtype']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $currency = mysqli_real_escape_string($conn, $_POST['currency']);
    $payee = mysqli_real_escape_string($conn, $_POST['payee']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $paymenttype = mysqli_real_escape_string($conn, $_POST['paymenttype']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $email = mysqli_real_escape_string($conn, $_SESSION['email']);
    $sql='DELETE FROM RECORDS WHERE ID="$id" ';
    $result=mysqli_query($conn,$sql);
    if($recordtype=='Expenditure'){
        $amount=$amount*-1;
    }
    // create sql
    $sql = "update records SET recordtype='$recordtype', category='$category', amount=$amount, currency='$currency', payee='$payee', date='$date', paymenttype='$paymenttype', status='$status', email='$email' where Id=$id ";
    // save to db and check
    if(mysqli_query($conn, $sql)){
        header('Location: dashboard.php');
    } else if(mysqli_error($conn)){
        $errors['incomplete']='Enter all the fields';
    }     
}






?>

    <div style="margin-top:3%; padding-top:15px; padding-bottom:15px; border-radius:0.5rem; min-width:325px; width:80%;" class="col mx-auto align-self-center bg-light shadow">
        <h3 class="text-center" style="padding-bottom:15px;">Edit Record</h3>
        <div class="alert-error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong><?php echo $errors['incomplete']; ?></strong>
        </div>
        <form class=" " method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="row">
                <div class="col-6" style="min-width:325px;">
                    <div class="form-group" >
                        <label>Record Type</label>
                        <select id="recordtype" class="form-control" name="recordtype" value="<?php echo htmlspecialchars($recordtype) ?>">
                            <option>Income</option>
                            <option>Expenditure</option>
                        </select>
                        <div class="alert alert-light" role="alert"><?php echo "Record has record type : ".$_SESSION['recordtype']; ?></div>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" name="amount" class="form-control" value="<?php echo htmlspecialchars($amount) ?>">
                        <div class="alert alert-light" role="alert"><?php echo "Record has amount : ".$_SESSION['amount']; ?></div>
                    </div>
                    <div class="form-group ">
                        <label>Category</label>
                        <select id="category" class="form-control" name="category" value="<?php echo htmlspecialchars($category) ?>">
                            <option>Food and Drinks</option>
                            <option>Shopping</option>
                            <option>Housing</option>
                            <option>Transportation</option>
                            <option>Vehicle</option>
                            <option>Life and Enertainment</option>
                            <option>Communication,PC</option>
                            <option>Financial Expenses</option>
                            <option>Investments</option>
                            <option>Income</option>
                            <option>Others</option>
                            </select>
                            <div class="alert alert-light" role="alert"><?php echo "Record has category : ".$_SESSION['category']; ?></div>
                    </div>
                    <div class="form-group ">
                        <label>Currency</label>
                        <select id="currency" class="form-control" name="currency" value="<?php echo htmlspecialchars($currency) ?>">
                            <option>Indian Rupees</option>
                            <option>US Dollars</option>
                            </select>
                            <div class="alert alert-light" role="alert"><?php echo "Record has currency : ".$_SESSION['currency']; ?></div>
                    </div>
                </div>
                <div class="col-6" style="min-width:325px;">
                    <div class="form-group">
                        <label>Payee</label>
                        <input type="text" name="payee" class="form-control" value="<?php echo htmlspecialchars($payee) ?>">
                        <div class="alert alert-light" role="alert"><?php echo "Record has payee : ".$_SESSION['payee']; ?></div>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control" placeholder="YYYY-MM-DD" value="<?php echo htmlspecialchars($date) ?>">
                        <div class="alert alert-light" role="alert"><?php echo "Record has date : ".$_SESSION['date']; ?></div>
                    </div>
                    <div class="form-group ">
                        <label>Payment Type</label>
                        <select id="paymenttype" class="form-control" name="paymenttype" value="<?php echo htmlspecialchars($paymenttype) ?>">
                            <option>Cash</option>
                            <option>Debit card</option>
                            <option>Credit card</option>
                            <option>Bank transfer</option>
                            <option>Voucher</option>
                            <option>Mobile payment</option>
                            <option>Web payment</option>
                            </select>
                            <div class="alert alert-light" role="alert"><?php echo "Record has payment type : ".$_SESSION['paymenttype']; ?></div>
                    </div>
                    <div class="form-group ">
                        <label>Status</label>
                        <select id="status" class="form-control" name="status" value="<?php echo htmlspecialchars($status) ?>">
                            <option>Cleared</option>
                            <option>Uncleared</option>
                            <option>Reconciled</option>
                            </select>
                            <div class="alert alert-light" role="alert"><?php echo "Record has status : ".$_SESSION['status']; ?></div>
                    </div>
                </div>
            </div>
            <button type="submit" name="editrecord" class="btn btn-success btn-block">Edit Record</button>
        </form>
    </div>
</html>
