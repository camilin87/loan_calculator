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

  <h1>Loan repayment calculator in PHP</h1>

  <div class="form-group">
	  <label for="start_date">Start Date:</label>
	  <input type="date" class="form-control" id="start_date">
	</div>

	<div class="form-group">
		  <label for="loan_amount">Loan Amount:</label>
		  <input type="text" class="form-control" id="loan_amount" placeholder="$">
	</div>

	<div class="form-group">
		  <label for="installment_amount">Installment Amount:</label>
		  <input type="text" class="form-control" id="installment_amount" placeholder="$">
	</div>

	<div class="form-group">
		  <label for="interest_rate">Interest Rate:</label>
		  <input type="text" class="form-control" id="interest_rate" placeholder="%">
	</div>

	<div class="form-group">
		<label for="installment_interval">Installment Interval:</label>
		<div class="btn-group" data-toggle="buttons">
		  <label class="btn">
		    <input type="radio" name="options" id="daily" autocomplete="off"> Daily
		  </label>
		  <label class="btn">
		    <input type="radio" name="options" id="weekly" autocomplete="off"> Weekly
		  </label>
		  <label class="btn">
		    <input type="radio" name="options" id="monthly" autocomplete="off"> Monthly
		  </label>
		</div>
	</div>

	<br> 
	
	<button type="button" class="btn btn-primary">Calculate</button>

	<div class="result">

	</div>

	<?php
		$start_date = 0;
		$loan_amount = 0;
		$installment_amount = 0;
		$interest_rate = 0;
		$installment_interval = 0;

		$estimate_payoff = 0;

    echo $start_date;

    echo "alex";
	?>  
  </body>
</html>