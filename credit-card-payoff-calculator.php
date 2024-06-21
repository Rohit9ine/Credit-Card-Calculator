<?php
/*
Plugin Name: Credit Card Payoff Calculator
Description: A simple credit card payoff calculator.
Version: 1.0
Author: Your Name
*/

function credit_card_payoff_calculator_shortcode() {
    ob_start();
    ?>
    <style>
        /* CSS styling for the form */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="radio"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="radio"] {
            width: auto;
            display: inline-block;
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            border: 0px solid #ccc;
            border-radius: 4px;
            background-color: #00000;
        }
    </style>
    <div class="container">
        <h1>Credit Card Payoff Calculator</h1>
        <form id="creditCardForm">
            <label for="balance">Credit Card Balance:</label>
            <input type="text" id="balance" placeholder="Enter balance">

            <label for="interestRate">Credit Card Interest Rate (%):</label>
            <input type="text" id="interestRate" placeholder="Enter interest rate">

            <input type="radio" id="paymentPerMonth" name="paymentOption" checked><label for="paymentPerMonth">Payment per Month</label>
            <br>

            <input type="radio" id="desiredMonthsToPayoff" name="paymentOption"><label for="desiredMonthsToPayoff">Desired Months to Payoff</label>

            <br><br>

            <div id="monthlyPaymentContainer">
                <label for="monthlyPayment">Monthly Payment:</label>
                <input type="text" id="monthlyPayment" placeholder="Enter monthly payment">
            </div>

            <div id="monthsToPayoffContainer" style="display:none">
                <label for="monthsToPayoff">Months to Payoff:</label>
                <input type="text" id="monthsToPayoff" placeholder="Enter months to payoff">
            </div>

            <input type="submit" value="Calculate">
        </form>

        <div id="result" class="result">

        </div>
    </div>

    <script>
        // JavaScript function to calculate the results
        document.getElementById("creditCardForm").addEventListener("submit", function(event) {
          event.preventDefault();

          var balance = parseFloat(document.getElementById("balance").value);
          var interestRate = parseFloat(document.getElementById("interestRate").value) / 100;

          var resultContainer = document.getElementById("result");

          if (document.getElementById("paymentPerMonth").checked) {
            var monthlyPayment = parseFloat(document.getElementById("monthlyPayment").value);
            var monthlyInterestRate = interestRate / 12;
            var numberOfMonths = Math.log(monthlyPayment / (monthlyPayment - balance * monthlyInterestRate)) / Math.log(1 + monthlyInterestRate);

            resultContainer.innerHTML = "Total Principal Paid: $" + balance.toFixed(2) +
              "<br>Total Interest Paid: $" + ((monthlyPayment * numberOfMonths) - balance).toFixed(2) +
              "<br>Monthly Payment: $" + monthlyPayment.toFixed(2) +
              "<br>Months to Payoff: " + Math.ceil(numberOfMonths);

          } else if (document.getElementById("desiredMonthsToPayoff").checked) {
            var monthsToPayoff = parseFloat(document.getElementById("monthsToPayoff").value);
            var monthlyInterestRate = interestRate / 12;
            var monthlyPayment = balance * ((monthlyInterestRate * Math.pow(1 + monthlyInterestRate, monthsToPayoff)) / (Math.pow(1 + monthlyInterestRate, monthsToPayoff) - 1));

            resultContainer.innerHTML = "Total Principal Paid: $" + balance.toFixed(2) +
              "<br>Total Interest Paid: $" + ((monthlyPayment * monthsToPayoff) - balance).toFixed(2) +
              "<br>Monthly Payment: $" + monthlyPayment.toFixed(2) +
              "<br>Months to Payoff: " + Math.ceil(monthsToPayoff);

          }
        });

        // JavaScript function to toggle visibility of input fields based on the selected radio button
        document.getElementById("paymentPerMonth").addEventListener("click", function() {
          document.getElementById("monthlyPaymentContainer").style.display = "block";
          document.getElementById("monthsToPayoffContainer").style.display = "none";
        });

        document.getElementById("desiredMonthsToPayoff").addEventListener("click", function() {
          document.getElementById("monthlyPaymentContainer").style.display = "none";
          document.getElementById("monthsToPayoffContainer").style.display = "block";
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('credit_card_payoff_calculator', 'credit_card_payoff_calculator_shortcode');
