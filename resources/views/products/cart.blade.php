@extends('layouts.app')

@section('contents')
  <h2>Shopping Cart Page</h2>
  @if (isset($cart) && $cart->getContents())
  <div class="card table-responsive">
    <table class="table table-hover shopping-cart-wrap">
      <thead class="text-muted">
        <tr>
          <th scope="col">Product</th>
          <th scope="col" width="120">Quantity</th>
          <th scope="col" width="120">Price</th>
          <th scope="col" width="200" class="text-right">Active</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($cart->getContents() as $slug => $product)
              <tr>
                <td>
                  <figure class="media">
                    <div class="img-wrap">
                      <img src="{{ asset('storage/' . $product['product']->thumbnail) }}" class="img-thumbnail img-sm" alt="{{ $product['product']->title }}">
                    </div>
                    <figcaption class="media-body">
                      <h6 class="title text-truncate">{{ $product['product']->title }}</h6>
                      <dl class="param param-inline small">
                        <dt>Size: </dt>
                        <dd>XXL</dd>
                      </dl>
                      <dl class="param param-inline small">
                        <dt>Color: </dt>
                        <dd>Orange Color</dd>
                      </dl>
                    </figcaption>
                  </figure>
                </td>
                <td>
                  <form action="{{ route('cart.update', $slug) }}" method="post" accept-charset="utf-8">
                    {{ csrf_field() }}
                    <input type="number" name="qty" id="qty" class="form-control text-center"
                    min="0" max="99" value="{{ $product['qty'] }}" value="">
                    <input type="submit" name="update" class="btn btn-block btn-outline-success btn-round" value="Update">
                  </form>
                </td>
                <td>
                  <div class="price-wrap">
                    <span class="price">USD {{ $product['price'] }}</span>
                    <small class="text-muted">(USD{{ $product['product']->price }} each)</small>
                  </div>
                </td>
                <td class="text-right">
                  <form action="{{ route('cart.remove', $slug) }}" method="post" accept-charset="utf-8">
                    {{ csrf_field() }}
                    <input type="submit" name="remove" class="btn btn-outline-danger" value="x Remove">
                  </form>
                </td>
              </tr>
          @endforeach

          <tr>
            <th>Total Qty: </th>
            <td>{{ $cart->getTotalQty() }}</td>
          </tr>
          <tr>
            <th>Total Price: </th>
            <td>$ {{ $cart->getTotalPrice() }}.00</td>
          </tr>
      </tbody>
    </table>
  </div>
  @else
    <p class="alert alert-danger">No Products in Cart &nbsp;<a href="{{ route('products.all') }}">Please Buy Some Products...!</a> </p>
  @endif
@endsection
