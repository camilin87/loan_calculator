<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Loan Calculator</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <style>
      header {
        background-color: #3B5CB2;
        width:100%;
        text-align: center;
        border-radius: 10px;
        top:0;
        left:0;
      }

     .btn-primary {
        background-color: #3B5CB2;
        border-color: #3B5CB2;
        width: 100%;
      }

      body {
        margin-top: 100px;
        margin-bottom: 100px;
        margin-right: 150px;
        margin-left: 80px;
        background-color: lightblue;
      }

      h1 {
        text-align: center;
        color: white;
      }

      h3 {
        line-height: 1.5;
        color: #212529;
        text-align: left;
        color: gray;
      }

      #results {
        padding-left: 50px;
      }

      .payoff {
        color: black;
      }

      .list_dates {
        list-style-type: none;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        color: black;
      }

    </style>
  </head>

  <body>
    <?php

      $start_date = 0;
      $loan_amount = 0;
      $installment_amount = 0.01;
      $interest_rate = 0;
      $installment_interval = 1;
      $estimate_payoff = 0;

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $start_date = test_input($_POST["start_date"]);
        $loan_amount = floatval(test_input($_POST["loan_amount"]));
        $installment_amount = floatval(test_input($_POST["installment_amount"]));
        $interest_rate = floatval(test_input($_POST["interest_rate"]));
        $installment_interval = floatval(test_input($_POST["installment_interval"]));
      }

      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

      $interest_rate_adjusted = $interest_rate/100;
      $installment_amount_neg = -($installment_amount);

      $interest_rate_period = $interest_rate_adjusted/$installment_interval;


      // code is from: https://github.com/markrogoyski/math-php/blob/master/src/Finance.php
      // * Examples:
      // * The number of periods of a $475000 mortgage with interest rate 3.5% and monthly
      // * payment of $2132.96  paid in full:
      // *   nper(0.035/12, -2132.96, 475000, 0)

      // * @param  float $rate
      // * @param  float $payment
      // * @param  float $present_value
      // * @param  float $future_value
      // * @param  bool  $beginning adjust the payment to the beginning or end of the period
      // *
      // * @return float
      function periods(float $rate, float $payment, float $present_value, float $future_value, bool $beginning = false): float {
        //echo "DEBUG ".$rate.", ".$payment.", ".$present_value.", ".$future_value . '<br>';   

        $when = $beginning ? 1 : 0;
        if ($rate == 0) {
            return - ($present_value + $future_value) / $payment;
        }
        $initial  = $payment * (1.0 + $rate * $when);
        return log(($initial - $future_value*$rate) / ($initial + $present_value*$rate)) / log(1.0 + $rate);
      }

      $number_of_periods = periods($interest_rate_period, $installment_amount_neg, $loan_amount, 0);
      $number_of_periods_rounded = ceil($number_of_periods);

      $start_date_new_format = strtotime($start_date);

      //echo "DEBUG: start date new format: " . date('Y/m/d', $start_date_new_format) . '<br>';
      //echo "DEBUG: installment_interval " . $installment_interval . '<br>';
      //echo "DEBUG: start plus 7 days " . date('Y/m/d', strtotime("+7 day", $start_date_new_format)) . '<br>';
      //echo "DEBUG: start plus 3 month " . date('Y/m/d', strtotime("+3 month", $start_date_new_format)) . '<br>';
      //echo "DEBUG: start plus 5 weeks " . date('Y/m/d', strtotime("+5 week", $start_date_new_format)) . '<br>';
      //echo "DEBUG: number of periods rounded: " . $number_of_periods_rounded . '<br>';
    
      $payments = array();

      if ($installment_interval == 365 ){
        $pay_off_date = strtotime("+".$number_of_periods_rounded ." day", $start_date_new_format); 

        for ($payment_date = $start_date_new_format; $payment_date <= $pay_off_date; $payment_date = strtotime("+1 day", $payment_date)){
          //echo "DEBUG: Payment date (daily): " . date('Y/m/d', $payment_date) . '<br>';

          array_push($payments, $payment_date);
        } 

      }

      if ($installment_interval == 52 ){
        $pay_off_date = strtotime("+".$number_of_periods_rounded ." week", $start_date_new_format);

        for ($payment_date = $start_date_new_format; $payment_date <= $pay_off_date; $payment_date = strtotime("+1 week", $payment_date)){
          //echo "DEBUG: Payment date (weekly): " . date('Y/m/d', $payment_date) . '<br>';

          array_push($payments, $payment_date);
        } 
      }
     
      if ($installment_interval == 12 ){
        $pay_off_date = strtotime("+".$number_of_periods_rounded ." month", $start_date_new_format);  

        for ($payment_date = $start_date_new_format; $payment_date <= $pay_off_date; $payment_date = strtotime("+1 month", $payment_date)){
          //echo "DEBUG: Payment date (monthly): " . date('Y/m/d', $payment_date) . '<br>';

          array_push($payments, $payment_date);
        }  
      }

      //echo "DEBUG Pay off date formatted: " . date('Y-m-d',$pay_off_date) . "<br>";
    ?>

    <header>
      <div class="container text-center">
        <h1>Loan Repayment Calculator in PHP </h1>
      </div>
    </header>
    <br>

    <form method = "post" action = "/calculator.php">
      <div class="form-row">
        <div class="form-group col-md-3">
          <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" class="form-control" id="start_date" name="start_date"  value="<?php echo isset($_POST["start_date"]) ? $_POST["start_date"] : ''; ?>">
          </div>

          <div class="form-group">
              <label for="loan_amount">Loan Amount:</label>
              <input type="text" class="form-control" id="loan_amount" name="loan_amount" placeholder="$" value="<?php echo isset($_POST["loan_amount"]) ? $_POST["loan_amount"] : ''; ?>">
          </div>

          <div class="form-group">
              <label for="installment_amount">Installment Amount:</label>
              <input type="text" class="form-control" id="installment_amount" name="installment_amount" placeholder="$" value="<?php echo isset($_POST["installment_amount"]) ? $_POST["installment_amount"] : ''; ?>">
          </div>

          <div class="form-group">
              <label for="interest_rate">Interest Rate:</label>
              <input type="text" class="form-control" id="interest_rate" name="interest_rate" placeholder="%" value="<?php echo isset($_POST["interest_rate"]) ? $_POST["interest_rate"] : ''; ?>">
          </div>

          <div class="form-group">
            <label for="installment_interval">Installment Interval:</label>
            <div class="btn-group" data-toggle="buttons">
              <label class="btn">
                <input type="radio" name="installment_interval" id="daily" value="365"> Daily
              </label>
              <label class="btn">
                <input type="radio" name="installment_interval" id="weekly" value="52"> Weekly
              </label>
              <label class="btn">
                <input type="radio" name="installment_interval" id="monthly" value="12"> Monthly
              </label>
            </div>
          </div>

          <br> 
          
          <input type="submit" value="Calculate" class="btn btn-primary">
        </div>      
    </form>
   
    <?php if (isset($pay_off_date)){ ?>
      <div class="form-group col-md-6" id="results">
        <h3>Payoff Date: <span class="payoff"><?php echo  date('Y/m/d', $pay_off_date); ?></span></h3> 

        <h3>Payment Dates: </h3>
          <ul class="list_dates">
          <?php foreach ($payments as $payment) { ?>
            <li><?php echo date('Y/m/d', $payment) . '<br>';?></li>
          <?php } ?>
          </ul>
      </div>
    <?php } ?>
    </div>

     

  </body>
</html>