
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img class="card-img-top img-thumbnail" src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}">
            <div class="card-body">
              <h4 class="card-title">{{ $product->title }}</h4>
              <p class="card-text">{!! $product->description !!}</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ route('products.single', $product) }}">View Product</a>
                  <a type="button" class="btn btn-sm btn-outline-secondary">Add To Cart</a>
                </div>
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="row">
        <div class="col-md-12">
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </div>
