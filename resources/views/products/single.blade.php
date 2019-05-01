@extends('layouts.app')

@section('contents')

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="mb-4">
            <div class="row">
              <div class="col-md-4">
                <img class="card-img-top img-thumbnail" src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}">
              </div>
              <div class="col-md-8">
                <h4 class="card-title">{{ $product->title }}</h4>
                <p class="card-text">{!! $product->description !!}</p>
                <div class="d-block justify-content-between align-items-center">
                  <div class="btn-group">
                    <a type="button" class="btn btn-sm btn-outline-secondary">Add To Cart</a>
                  </div>
                  <p class="text-muted">9 mins</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
