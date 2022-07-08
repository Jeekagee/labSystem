<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Print Bill</title>

    <style>
        body  
        { 
            font-weight: 600;
            height:140mm;
            width: 220mm;
            padding : 15px;
        }

        .tbl-bor{
            border: 1.5px solid black;
        }
        .print_container{
            width: 80mm;
        }

        .logo_img{
            width: 110px;
            height: auto;
        }
        .mt-10{
            margin-top: 10px;
        }
        .mb-10{
            margin-bottom: 10px;
        }
        .line {
            margin:5px 0;
            height:2px;
            background:
            repeating-linear-gradient(to right,black 0,black 5px,transparent 5px,transparent 7px);
            opacity: 0.5;
            /*5px red then 2px transparent -> repeat this!*/
        }

    </style>
</head>
<body>

<?php $CI =& get_instance(); ?>

<div class="print_container">
    <div class="text-center mb-10">
        <img class="logo_img" src="<?php echo base_url(); ?>assets/img/aclogo.png">
    </div>
    <div class="text-center mb-10">
        #184, Palaly Road,<br>
        Thirunelveli.<br>
        0778434368/0713070638
    </div>
    <div class="row mb-10">
        <div class="col-sm-6 text-left">
            Customer : 
        </div>
        <div class="col-sm-6 text-right">
            Invoice : <?php echo $bill_data->bill_no; ?>
        </div>
    </div>
    <div class="line"></div>

        <?php
        $i = 1;
        $order_id = $bill_data->order_id;
        $items = $CI->Orders_model->order_item_data($order_id);
        foreach ($items as $itm) {
            ?>
            <div class="row" style="font-size: 14px; margin-bottom:15px;">
                <div class="col-sm-4">
                    <?php echo $i; ?> - <?php echo $itm->item_name; ?>
                </div>
                <div class="col-sm-4 text-center">
                    <?php echo $amount = $itm->amount; ?>*<?php echo $qty = $itm->qty; ?>
                </div>
                <div class="col-sm-4 text-right">
                    <?php echo $amount*$qty; ?>.00
                </div>
            </div>
            <div class="line"></div>
            <?php
        }
        ?>
    <div class="row mb-10" style="font-size: 14px;">
        <div class="col-sm-6 text-left">
            Total
        </div>
        <div class="col-sm-6 text-right">
            <?php echo $total = $bill_data->total; ?>.00
        </div>
    </div>
    <div class="row mb-10" style="font-size: 14px;">
        <div class="col-sm-6 text-left">
            Discount
        </div>
        <div class="col-sm-6 text-right">
            <?php echo $discount = $bill_data->discount; ?>.00
        </div>
    </div>
    <div class="row mb-10" style="font-size: 14px;">
        <div class="col-sm-6 text-left">
            Payment
        </div>
        <div class="col-sm-6 text-right">
            <?php echo $payment = $bill_data->payment; ?>.00
        </div>
    </div>
    <div class="line"></div>
    <div class="row mb-10" style="font-size: 14px;">
        <div class="col-sm-6 text-left">
            Balance
        </div>
        <div class="col-sm-6 text-right">
            <?php echo $payment - $total - $discount; ?>.00
        </div>
    </div>

    <div class="row mb-10" style="font-size: 14px;">
        <div class="col-sm-6 text-left">
            No of Items : <?php echo $CI->Orders_model->noofitems($order_id); ?>
        </div>
        <div class="col-sm-6 text-right">
            No of PCs : <?php echo $CI->Orders_model->noofpcs($order_id); ?>
        </div>
    </div>

    <?php
        $month = date('m');
        $day = date('d');
        $year = date('Y');
        
        $today = $year . '-' . $month . '-' . $day;
    ?>

    <div class="row mb-10" style="font-size: 14px;">
        <div class="col-sm-6 text-left">
            Date : <?php echo $today; ?>
        </div>
        <div class="col-sm-6 text-right">
            Time : <?php echo time('H:s:i'); ?>
        </div>
    </div>

    <div class="line"></div>
        <div class="mb-10 text-center">
        Thankyou for with us
        </div>
    <div class="line"></div>

    <div class="line"></div>
        <div class="mb-10 text-center">
        Any medical services and inquries please contact with us 0778434368
        </div>
    <div class="line"></div>

    <div class="mb-10 text-center">
        Sysytem By : Kodplex - 0778434368
    </div>
</div>

<script>
    $(document).ready(function(){
        window.print();
        window.location.href = "<?php echo base_url(); ?>Orders";
    });
</script>
</body>
</html>