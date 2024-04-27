
<!--display credit card logos (aesthetics)-->
<img src="icons/CreditCardLogos.jpg" alt="Credit Card Logos" class="credit-card-logos">

<!--credit card payment form-->
<form name="paymentForm" class="payment-form" action="paymentVerify.php" method="post">
        
        <!--input field for cardholder name-->
        <div class="form-group-cardholderName">
            <label for="cardholderName" class="form-label-cardholderName">Cardholder Name</label>
            <input type="text" id="cardholderName" name="cardholderName" class="form-input-cardholderName" placeholder="Card Holder Name i.e Harry Maguire" required>
        </div>

        <!--input field for card number-->
        <div class="form-group-cardNumber">
            <label for="cardNumber" class="form-label-cardNumber">Card Number</label>
            <input type="text" id="cardNumber" name="cardNumber" class="form-input-cardNumber" minlength="16" maxlength="16" placeholder="Card Number i.e 3711 1111 1111 1142" required>
        </div>

        <!--input fields for expiry date-->
        <div class="form-group-expiryDate">
            <h4 class="form-label-expiryDate">Expiry Date</h4>
            <label for="expiryMonth" class="form-label-expiryMonth">MM</label>
            <input type="text" id="expiryMonth" name="expiryMonth" class="form-input-expiryMonth" pattern="(0[1-9]|1[0-2])" title="Please enter a valid month (01-12)" minlength="2" maxlength="2" placeholder="Card Expiry Month i.e 09" required>

            <label for="expiryYear" class="form-label-expiryYear">YY</label>
            <input type="text" id="expiryYear" name="expiryYear" class="form-input-expiryYear" pattern="([0-9]{2})" title="Please enter a valid year (last 2 digits)" minlength="2" maxlength="2" placeholder="Card Expiry Year i.e 28" required>
        </div>

        <!--input field for cvc-->
        <div class="form-group-cvc">
            <label for="cvc" class="form-label-cvc">CVC</label>
            <input type="password" id="cvc" name="cvc" class="form-input-cvc" pattern="\d{3}" title="Please enter a 3-digit CVC" minlength="3" maxlength="3" placeholder="CVC i.e 525" required>
        </div>

        <!--submit button for credit card payment form-->
        <input type="submit" name="paymentSubmitButton" value="Pay Now" class="form-submit-paymentSubmitButton">

</form>