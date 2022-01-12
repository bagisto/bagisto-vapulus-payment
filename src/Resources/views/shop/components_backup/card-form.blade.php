<!-- CREATE THE HTML FOR THE PAYMENT PAGE -->
<div class="card justify-content-center vapulus-card-shadow">
    <div class="row">
        <button type="button" class="close payment-reject" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="vapulus-logo">
            <img class="mx-auto d-block" src="{{ asset('vendor/webkul/vapulus/assets/images/vapulus-logo.png') }}" style="height: 70px;"/>
        </div>
        
        <form id="vapulus-payment-form">
            <div class="contents">
                <div class="vapulus-alert"></div>
                <div class="form-group">
                    <label class="col-md-8 control-label" for="cardNumber">Card number:</label>
                    <div class="col-md-8 field">
                        <input type="text" id="cardNumber" class="form-control input-md" value="" readonly />
                        <span class="vapulus-errors" id="card-number-error" role="alert"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-8 control-label" for="cardMonth">Expiry month:</label>
                    <div class="col-md-8 field">
                        <input type="text" id="cardMonth" class="form-control input-md" value="" />
                        <span class="vapulus-errors" id="card-month-error" role="alert"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-8 control-label" for="cardYear">Expiry year:</label>
                    <div class="col-md-8 field">
                        <input type="text" id="cardYear" class="form-control input-md" value="" />
                        <span class="vapulus-errors" id="card-year-error" role="alert"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-8 control-label" for="cardCVC">CVC:</label>
                    <div class="col-md-8 field">
                        <input type="text" id="cardCVC" class="form-control input-md" value="" readonly />
                        <span class="vapulus-errors" id="card-cvc-error" role="alert"></span>
                    </div>
                </div>
                <button class="btn btn-primary" id="payButton">Pay Now  ( {{ core()->currency(\Cart::getCart()->base_grand_total) }} )</button>
            </div>
        </form>
    </div>
