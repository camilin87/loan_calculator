<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Loan Calculator</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <style>
    body {
    margin-top: 100px;
    margin-bottom: 100px;
    margin-right: 150px;
    margin-left: 80px;
    background-color: lightblue;
    }

    h1 {
      text-align: center;
    }

    </style>
  </head>

  <body>
    <?php
      $start_date = 0;
      $loan_amount = 0;
      $installment_amount = 0;
      $interest_rate = 0;
      $installment_interval = 0;
      $estimate_payoff = 0;


      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $start_date = test_input($_POST["start_date"]);
        $loan_amount = test_input($_POST["loan_amount"]);
        $installment_amount = test_input($_POST["installment_amount"]);
        $interest_rate = test_input($_POST["interest_rate"]);
        $installment_interval = test_input($_POST["installment_interval"]);
      }

      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }


    public static function periods(float $interest_rate, float $installment_amount, float $present_value, float $future_value, bool $beginning = false): float
    {
        $when = $beginning ? 1 : 0;
        if ($rate == 0) {
            return - ($present_value + $future_value) / $installment_amount;
        }
        $initial  = $installment_amount * (1.0 + $rate * $when);
        return log(($initial - $future_value*$interest_rate) / ($initial + $present_value*$interest_rate)) / log(1.0 + $interest_rate);
    }



    ?>

    <h1>Loan repayment calculator in PHP</h1>

    <form method = "post" action = "/calculator.php">

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

    </form>



    <div class="result">

      <!-- show calculations -->

    </div>

    <?php
      echo "<h2>You selected :</h2>";
      echo "<br>";

      echo "Start date: " . $start_date;
      echo "<br>";

      echo "Loan amount: " . $loan_amount;
      echo "<br>";

      echo "Installment amount: " . $installment_amount;
      echo "<br>";

      echo "Interest rate: " . $interest_rate;
      echo "<br>";

      echo "Installment interval: " . $installment_interval;
      echo "<br>";
    ?>  
  </body>
</html>