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
    $datefrom=Date('Y-m-d', strtotime('-30 days'));
    $email=mysqli_real_escape_string($conn, $_SESSION['email']);
    if(isset($_POST['dated'])){
        $datefrom=$_POST['from'];
        $dateto=$_POST['to'];
    }

    //Balance trend of 30 days month
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && recordtype='Income' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $monthlyincome=mysqli_fetch_assoc($result);
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && recordtype='Expenditure' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $monthlyexpense=mysqli_fetch_assoc($result);
    
    // classification by category
        //food and drinks
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='food and drinks' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $foodanddrinks=mysqli_fetch_assoc($result);
        //shopping
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='shopping' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $shopping=mysqli_fetch_assoc($result);
        //housing
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='housing' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $housing=mysqli_fetch_assoc($result);
        //transportation
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='transportation' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $transportation=mysqli_fetch_assoc($result);
        //vehicle
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='vehicle' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $vehicle=mysqli_fetch_assoc($result);
        //life and entertainment
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='life and entertainment' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $lifeandentertainment=mysqli_fetch_assoc($result);
        //communication,PC
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='Communication,PC' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $communicationpc=mysqli_fetch_assoc($result);
        //Financial expences
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='Financial Expences' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $financialexpences=mysqli_fetch_assoc($result);
        //investments
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='Investments' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $investments=mysqli_fetch_assoc($result);
        //income
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='income' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $income=mysqli_fetch_assoc($result);
        //others
        $sql="SELECT sum(amount) FROM RECORDS WHERE EMAIL='$email'&& date<'$dateto' && date>'$datefrom' && category='others' ORDER BY date desc ";
        $result=mysqli_query($conn,$sql);
            $others=mysqli_fetch_assoc($result);

    
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <div class="row mx-auto align-self-center" style="margin-top:10px;">
        <h1 class="row mx-auto align-self-center font-weight-bold">Statistics</h1>
    </div>
    <div class="row mx-auto align-self-center">  
        <div class="col card bg-light shadow mx-auto align-self-center" style="margin:10px; padding:10px; min-width:400px; max-width:500px; width:60%;">
            <form class=" " method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <div class="form-group">
                    <label>From(yyyy-mm-dd)</label>
                    <input type="text" style="margin:3px;" name="from" class="form-control" value="<?php echo htmlspecialchars($datefrom) ?>">
                </div>
                <div class="form-group">
                    <label>To(yyyy-mm-dd)</label>
                    <input type="text" style="margin:3px;" name="to" class="form-control" value="<?php echo htmlspecialchars($dateto) ?>">
                </div>
                <button type="submit" style="margin:3px;" name="dated" class="btn btn-primary btn-block">Generate Statistics</button>
            </form>
        </div>
    </div>
    <div class="row mx-auto align-self-center">  
        <div class="col card bg-light shadow" style="margin:10px; padding:10px; min-width:400px; width:50%;">
            <canvas id="outlook">
        </div>
        <div class="col card bg-light shadow" style="margin:10px; padding:5px; min-width:400px; width:50%;">
            <canvas id="spending">
        </div>
    </div>
    <div class="row mx-auto align-self-center">  
        <div class="col card bg-light shadow" style="margin:10px; padding:10px; min-width:400px;">
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