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
$errors = array('amount' => '','payee'=>'','date'=>'');

if(isset($_POST['addrecord'])){
    // check record type
    $recordtype = $_POST['recordtype'];
    if($recordtype=='Income')
        $sign=1;
    else {
        $sign=-1;
    }
    // check amount type
    $amount = intval($_POST['amount']);
    // check category
    $category = $_POST['category'];
    // check currency type
    $currency = $_POST['currency'];
    // check payee type
    $payee = $_POST['payee'];
    // check date type and validation
    $date = $_POST['date'];
    // check payment type
    $paymenttype = $_POST['paymenttype'];
    // check status
    $status = $_POST['status'];
    //validation
    if($amount==0){
        $errors['amount']='Enter amount';
    }
    if($payee==''){
        $errors['payee']='Enter payee';
    }
    //insert commands
    // escape sql chars
    $recordtype = mysqli_real_escape_string($conn, $_POST['recordtype']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $currency = mysqli_real_escape_string($conn, $_POST['currency']);
    $payee = mysqli_real_escape_string($conn, $_POST['payee']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $paymenttype = mysqli_real_escape_string($conn, $_POST['paymenttype']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $email = mysqli_real_escape_string($conn, $_SESSION['email']);
    $sql='SELECT MAX(id) as id FROM records ';
    $result=mysqli_query($conn,$sql);
    $id=mysqli_fetch_assoc($result);
    $idupdated=$id['id']+1;
    // create sql
    $sql = "INSERT INTO records (id, recordtype, category, amount, currency, payee, date, paymenttype, status, email) VALUES ($idupdated, '$recordtype', '$category', $amount*$sign, '$currency', '$payee', '$date', '$paymenttype', '$status', '$email') ";
    // save to db and check
    if(mysqli_query($conn, $sql)){
        header('Location: dashboard.php');
    } else if(mysqli_error($conn)){
        //$sqlerror= 'This Email address is already registered';
        //echo("Error" . mysqli_error($conn));
    }     
}






?>

    <div style="margin-top:3%; padding-top:15px; padding-bottom:15px; border-radius:0.5rem; min-width:325px; width:80%;" class="col mx-auto align-self-center bg-light shadow">
        <h3 class="text-center" style="padding-bottom:15px;">Add Record</h3>
        <form class=" " method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="row">
                <div class="col-6" style="min-width:325px;">
                    <div class="form-group" >
                        <label>Record Type</label>
                        <select id="recordtype" class="form-control" name="recordtype" value="<?php echo htmlspecialchars($recordtype) ?>">
                            <option>Income</option>
                            <option>Expenditure</option>
                        </select>
                        <div class="error-display"></div>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" name="amount" class="form-control" value="<?php echo htmlspecialchars($amount) ?>">
                        <div class="error-display"><?php echo $errors['amount']; ?></div>
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
                    </div>
                    <div class="form-group ">
                        <label>Currency</label>
                        <select id="currency" class="form-control" name="currency" value="<?php echo htmlspecialchars($currency) ?>">
                            <option>Indian Rupees</option>
                            <option>US Dollars</option>
                            </select>
                    </div>
                </div>
                <div class="col-6" style="min-width:325px;">
                    <div class="form-group">
                        <label>Payee</label>
                        <input type="text" name="payee" class="form-control" value="<?php echo htmlspecialchars($payee) ?>">
                        <div class="error-display"><?php echo $errors['payee']; ?></div>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control" placeholder="YYYY-MM-DD" value="<?php echo htmlspecialchars($date) ?>">
                        <div class="error-display"><?php echo $errors['date']; ?></div>
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
                    </div>
                    <div class="form-group ">
                        <label>Status</label>
                        <select id="status" class="form-control" name="status" value="<?php echo htmlspecialchars($status) ?>">
                            <option>Cleared</option>
                            <option>Uncleared</option>
                            <option>Reconciled</option>
                            </select>
                    </div>
                </div>
            </div>
            <button type="submit" name="addrecord" class="btn btn-primary btn-block">Add Record</button>
        </form>
    </div>
</html>
