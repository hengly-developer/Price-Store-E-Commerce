@extends('layouts.app')

@section('contents')
<div class="row">
  <div class="col-md-4 order-md-2 mb-4">
    <h4 class="d-flex justify-content-between align-items-center mb-3">
      <span class="text-muted">Your cart</span>
      <span class="badge badge-secondary badge-pill">{{ $cart->getTotalQty() }}</span>
    </h4>
    <ul class="list-group mb-3">
      @foreach ($cart->getContents() as $slug => $product)
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">{{ $product['product']->title }}</h6>
            <small class="text-muted">{{ $product['qty'] }}</small>
          </div>
          <span class="text-muted">$ {{ $product['price'] }}.00</span>
        </li>
      @endforeach
      <!-- <li class="list-group-item d-flex justify-content-between bg-light">
        <div class="text-success">
          <h6 class="my-0">Promo code</h6>
          <small>EXAMPLECODE</small>
        </div>
        <span class="text-success">-$5</span>
      </li> -->
      <li class="list-group-item d-flex justify-content-between">
        <span>Total (USD)</span>
        <strong>$ {{ $cart->getTotalPrice() }}.00</strong>
      </li>
    </ul>
    <!-- <form class="card p-2">
      {{ csrf_field() }}
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Promo code">
        <div class="input-group-append">
          <button type="submit" class="btn btn-secondary">Redeem</button>
        </div>
      </div>
    </form> -->
  </div>
  <div class="col-md-8 order-md-1">
    <h4 class="mb-3">Billing address</h4>
    <form class="needs-validation" novalidate="" action="{{ route('checkout.store') }}" method="post">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="firstName">First name</label>
          <input type="text" class="form-control" name="billing_firstName" id="billing_firstName" placeholder="" value="" required="">
          @if ($errors->has('billing_firstName'))
            <div style="color:red;">
              {{ $errors->first('billing_firstName') }}
            </div>
          @endif
        </div>
        <div class="col-md-6 mb-3">
          <label for="lastName">Last name</label>
          <input type="text" class="form-control" name="billing_lastName" id="billing_lastName" placeholder="" value="" required="">
          @if ($errors->has('billing_lastName'))
            <div style="color:red;">
              {{ $errors->first('billing_lastName') }}
            </div>
          @endif
        </div>
      </div>
      <div class="mb-3">
        <label for="username">Username</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <input type="text" class="form-control" name="billing_userame" id="billing_username" placeholder="Username" required="">
          @if ($errors->has('billing_userame'))
            <div style="color:red;">
              {{ $errors->first('billing_userame') }}
            </div>
          @endif
        </div>
      </div>
      <div class="mb-3">
        <label for="email">Email</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <input type="text" class="form-control" name="billing_email" id="billing_email" placeholder="Email" required="">
          @if ($errors->has('billing_email'))
            <div style="color:red;">
              {{ $errors->first('billing_email') }}
            </div>
          @endif
        </div>
      </div>
      <div class="mb-3">
        <label for="address">Address</label>
        <input type="text" class="form-control" name="billing_address" id="billing_address" placeholder="1234 Main St" required="">
        @if ($errors->has('billing_address'))
          <div style="color:red;">
            {{ $errors->first('billing_address') }}
          </div>
        @endif
      </div>
      <div class="mb-3">
        <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
        <input type="text" class="form-control" name="billing_address2" id="billing_address2" placeholder="Apartment or suite">
        @if ($errors->has('billing_address2'))
          <div style="color:red;">
            {{ $errors->first('billing_address2') }}
          </div>
        @endif
      </div>
      <div class="row">
        <div class="col-md-5 mb-3">
          <label for="country">Country</label>
          <select class="custom-select d-block w-100" name="billing_country" id="billing_country" required="">
            <option value="">Choose...</option>
            <option>United States</option>
          </select>
          @if ($errors->has('billing_country'))
            <div style="color:red;">
              {{ $errors->first('billing_country') }}
            </div>
          @endif
        </div>
        <div class="col-md-4 mb-3">
          <label for="state">State</label>
          <select class="custom-select d-block w-100" name="billing_state" id="billing_state" required="">
            <option value="">Choose...</option>
            <option>California</option>
          </select>
          @if ($errors->has('billing_state'))
            <div style="color:red;">
              {{ $errors->first('billing_state') }}
            </div>
          @endif
        </div>
        <div class="col-md-3 mb-3">
          <label for="zip">Zip</label>
          <input type="text" class="form-control" name="billing_zip" id="billing_zip" placeholder="" required="">
          @if ($errors->has('billing_zip'))
            <div style="color:red;">
              {{ $errors->first('billing_zip') }}
            </div>
          @endif
        </div>
      </div>
      <hr class="mb-4">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" name="billing_same-address" id="same-address">
        <label id="check-shipping" class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
      </div>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" name="billing_save-info" id="save-info">
        <label class="custom-control-label" for="save-info">Save this information for next time</label>
      </div>
    <hr class="mb-4">
    <div id="shipping_address" class="col-md-12 order-md-1">
      <h4 class="mb-3">Shipping Address</h4>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" name="shipping_firstName" id="shipping_firstName" placeholder="" value="" required="">
            <div class="invalid-feedback">
              Valid first name is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" name="shipping_lastName" id="shipping_lastName" placeholder="" value="" required="">
            <div class="invalid-feedback">
              Valid last name is required.
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="username">Username</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">@</span>
            </div>
            <input type="text" class="form-control" name="shipping_userame" id="shipping_username" placeholder="Username" required="">
            <div class="invalid-feedback" style="width: 100%;">
              Your username is required.
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="address">Address</label>
          <input type="text" class="form-control" name="shipping_address1" id="shipping_address1" placeholder="1234 Main St" required="">
          <div class="invalid-feedback">
        </div>

        <div class="mb-3">
          <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
          <input type="text" class="form-control" name="shipping_address2" id="shipping_address2" placeholder="Apartment or suite">
        </div>

        <div class="row">
          <div class="col-md-5 mb-3">
            <label for="country">Country</label>
            <select class="custom-select d-block w-100" name="shipping_country" id="shipping_country" required="">
              <option value="">Choose...</option>
              <option>United States</option>
            </select>
          </div>
          <div class="col-md-4 mb-3">
            <label for="state">State</label>
            <select class="custom-select d-block w-100" name="shipping_state" id="shipping_state" required="">
              <option value="">Choose...</option>
              <option>California</option>
            </select>
          </div>
          <div class="col-md-3 mb-3">
            <label for="zip">Zip</label>
            <input type="text" class="form-control" name="shipping_zip" id="shipping_zip" placeholder="" required="">
            <div class="invalid-feedback">
              Zip code required.
            </div>
          </div>
        </div>
        </div>
        </div>
        <hr class="mb-4">
      <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
    </form>

</div>
@endsection
@section('script')
  <script>
    $(document).ready(function() {
      $('#same-address').on('change', function(){
        $('#shipping_address').slideToggle(!this.checked)
      })
    });
  </script>
@endsection
