<?php include('headerfooters/Initial_Plugin.php'); ?>
<?php include('headerfooters\navbar_post_login.php'); ?>
<?php
    //create connection
    $conn = mysqli_connect('localhost','Cryptowallet','4PLJ0AoqqdExiL1W','cryptowallet');
    //check connection
    if(!$conn){
    echo 'errro: '.mysqli_connect_error();
}   
    $dateto=date("Y-m-d");
    $email=mysqli_real_escape_string($conn, $_SESSION['email']);
    //todays transactions
        $sql="SELECT id,category,amount,payee,date,status,paymenttype FROM RECORDS WHERE EMAIL='$email' && date='$dateto' ";
        $result=mysqli_query($conn,$sql);
        $records=mysqli_fetch_all($result, MYSQLI_ASSOC);
    //Balance trend of 30 days month
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && recordtype='Income'";
        $result=mysqli_query($conn,$sql);
            $monthlyincome=mysqli_fetch_assoc($result);
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && recordtype='Expenditure'";
        $result=mysqli_query($conn,$sql);
            $monthlyexpense=mysqli_fetch_assoc($result);
    
    // classification by category
        //food and drinks
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='food and drinks'";
        $result=mysqli_query($conn,$sql);
            $foodanddrinks=mysqli_fetch_assoc($result);
        //shopping
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='shopping'";
        $result=mysqli_query($conn,$sql);
            $shopping=mysqli_fetch_assoc($result);
        //housing
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='housing'";
        $result=mysqli_query($conn,$sql);
            $housing=mysqli_fetch_assoc($result);
        //transportation
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='transportation'";
        $result=mysqli_query($conn,$sql);
            $transportation=mysqli_fetch_assoc($result);
        //vehicle
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='vehicle'";
        $result=mysqli_query($conn,$sql);
            $vehicle=mysqli_fetch_assoc($result);
        //life and entertainment
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='life and entertainment'";
        $result=mysqli_query($conn,$sql);
            $lifeandentertainment=mysqli_fetch_assoc($result);
        //communication,PC
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='Communication,PC'";
        $result=mysqli_query($conn,$sql);
            $communicationpc=mysqli_fetch_assoc($result);
        //Financial expences
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='Financial Expences' ";
        $result=mysqli_query($conn,$sql);
            $financialexpences=mysqli_fetch_assoc($result);
        //investments
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='Investments' ";
        $result=mysqli_query($conn,$sql);
            $investments=mysqli_fetch_assoc($result);
        //income
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date='$dateto' && category='income' ";
        $result=mysqli_query($conn,$sql);
            $income=mysqli_fetch_assoc($result);
        //others
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email' && date='$dateto' && category='others' ";
        $result=mysqli_query($conn,$sql);
            $others=mysqli_fetch_assoc($result);

    
?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <div class="row mx-auto align-self-center" style="margin-top:10px;">
        <h1 class="row mx-auto align-self-center font-weight-bold">Today's Transactions</h1>
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
    <div class="row mx-auto align-self-center" style="margin-top:10px;">
        <h1 class="row mx-auto align-self-center font-weight-bold">Today's Statistics</h1>
    </div>
    <div class="row mx-auto align-self-center">  
        <div class="col card bg-light shadow" style="margin:10px; padding:10px; min-width:400px; width:50%;">
            <h4 class="mx-auto align-self-center">Balance</h4>
            <canvas id="outlook">
        </div>
        <div class="col card bg-light shadow" style="margin:10px; padding:5px; min-width:400px; width:50%;">
            <h4 class="mx-auto align-self-center">Spending</h4>
            <canvas id="spending">
        </div>
    </div>
    <div class="row mx-auto align-self-center">  
        <div class="col card bg-light shadow" style="margin:10px; padding:10px; min-width:400px;">
            <h4 class="mx-auto align-self-center">Income to Expences</h4>
            <canvas id="incometoexpenses">
        </div>

    </div>







<script>
//balance chart
    var ctx = document.getElementById('outlook').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'horizontalBar',

        // The data for our dataset
        data: {
            labels: [''],
            datasets: [{
                label: 'Income',
                backgroundColor: 'rgb(30, 150, 50)',
                borderColor: 'rgb(33, 136, 56)',
                data: [<?php echo $monthlyincome['sum(amount)']?>]
            },{
                label: 'Expenditure',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $monthlyexpense['sum(amount)']?>]
            },{
                label: 'Balance',
                backgroundColor: 'rgb(0, 123, 255)',
                borderColor: 'rgb(0, 123, 255)',
                data: [<?php echo $monthlyincome['sum(amount)']+$monthlyexpense['sum(amount)']?>]
            }]
        },

        // Configuration options go here
        options: {}
    });
//category chart
    var ctx = document.getElementById('spending').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'polarArea',

            // The data for our dataset
            data: {
                labels: ["Food and Drinks", "Shopping", "Housing", "Transportation", "Vehicle", "Life and Entertainment", "Communication,PC","Financial Expences","Investments","Income","Others"],
                datasets: [{
                    label: "My First dataset",
                    backgroundColor: [	' #ff0000 ', ' #ff0080 ', ' #ff00e8 ', ' #c100ff ', ' #5900ff ', ' #4898f7 ', ' #48eaf7 ',' #00ff9b ', ' #69fc74 ', ' #f1f94a ', ' #ffaf03 '],
                    borderColor: '#fff',
                    data: [15, 10, 8, 9, 20, 15, 7, 10, 15, 13, 9],
                }]
            },

            // Configuration options go here
            options: {}
        });
//income to expense
var ctx = document.getElementById('incometoexpenses').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'horizontalBar',

        // The data for our dataset
        data: {
            labels: [''],
            datasets: [{
                label: 'Income',
                backgroundColor: 'rgb(30, 150, 50)',
                borderColor: 'rgb(33, 136, 56)',
                data: [<?php echo $monthlyincome['sum(amount)']?>]
            },{
                label: 'Food and drinks',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $foodanddrinks['sum(amount)']*-1?>]
            },{
                label: 'Shopping',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $shopping['sum(amount)']*-1?>]
            },{
                label: 'Housing',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $housing['sum(amount)']*-1?>]
            },{
                label: 'Transportation',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $transportation['sum(amount)']*-1?>]
            },{
                label: 'Vehicle',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $vehicle['sum(amount)']*-1?>]
            },{
                label: 'Life and Entertainment',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $lifeandentertainment['sum(amount)']*-1?>]
            },{
                label: 'Vehicle',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $vehicle['sum(amount)']*-1?>]
            },{
                label: 'Communication,PC',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $communicationpc['sum(amount)']*-1?>]
            },{
                label: 'Financial Expenses',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $financialexpences['sum(amount)']*-1?>]
            },{
                label: 'Investment',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $investments['sum(amount)']*-1?>]
            },{
                label: 'Others',
                backgroundColor: 'rgb(220, 53, 69)',
                borderColor: 'rgb(220, 53, 69)',
                data: [<?php echo $others['sum(amount)']*-1?>]
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>