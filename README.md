# Description
Payment loan calculator

# To run the project

```bash
php -S localhost:8080
```

go to : http://localhost:8080/calculator.php



# The NPER() is copied from https://github.com/markrogoyski/math-php/blob/master/src/Finance.php

```php
/**.  
 * Number of payment periods of an annuity.
 * Solves for the number of periods in the annuity formula.
 *
 * Same as the =NPER() function in most spreadsheet software.
 *
 * Solving the basic annuity formula for number of periods:
 *        log(PMT - FV*r)
 *        ---------------
 *        log(PMT + PV*r)
 * n = --------------------
 *          log(1 + r)
 *
 * The (1+r*when) factor adjusts the payment to the beginning or end
 * of the period. In the common case of a payment at the end of a period,
 * the factor is 1 and reduces to the formula above. Setting when=1 computes
 * an "annuity due" with an immediate payment.
 *
 * Examples:
 * The number of periods of a $475000 mortgage with interest rate 3.5% and monthly
 * payment of $2132.96  paid in full:
 *   nper(0.035/12, -2132.96, 475000, 0)
 *
 * @param  float $rate
 * @param  float $payment
 * @param  float $present_value
 * @param  float $future_value
 * @param  bool  $beginning adjust the payment to the beginning or end of the period
 *
 * @return float
 */
public static function periods(float $rate, float $payment, float $present_value, float $future_value, bool $beginning = false): float
{
    $when = $beginning ? 1 : 0;
    if ($rate == 0) {
        return - ($present_value + $future_value) / $payment;
    }
    $initial  = $payment * (1.0 + $rate * $when);
    return log(($initial - $future_value*$rate) / ($initial + $present_value*$rate)) / log(1.0 + $rate);
}
```
