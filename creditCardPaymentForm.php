<form name="paymentForm" action="paymentVerify.php" method="post">
        
        <div>
            <label for="cardholderName">Cardholder Name</label>
            <input type="text" id="cardholderName" name="cardholderName" required>
        </div>

        <div>
            <label for="cardNumber">Card Number</label>
            <input type="text" id="cardNumber" name="cardNumber" minlength="16" maxlength="16" required>
        </div>

        <div>
            <h4>Expiry Date</h4>
            <label for="expiryMonth">MM</label>
            <input type="text" id="expiryMonth" name="expiryMonth" minlength="2" maxlength="2" required>

            <label for="expiryYear">YY</label>
            <input type="text" id="expiryYear" name="expiryYear" minlength="2" maxlength="2" required>
        </div>

        <div>
            <label for="cvc">CVC</label>
            <input type="password" id="cvc" name="cvc" minlength="3" maxlength="3" required>
        </div>

        <input type="submit" name="paymentSubmitButton" value="Pay Now">

</form>