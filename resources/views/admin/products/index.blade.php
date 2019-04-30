@extends('admin.app')
@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}">Dashboard</a> </li>
<li class="breadcrumb-item active" aria-current="page">Product</li>
@endsection
@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h2">Product List</h2>
    <hr>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-outline-secondary">Add Product</a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Description</th>
          <th>Slug</th>
          <th>Categories</th>
          <th>Price</th>
          <th>Thumbnail</th>
          <th>Create At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if ($products->count() > 0)
          @foreach ($products as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td>{{ $product->title }}</td>
              <td>{!! $product->description !!}</td>
              <td>{{ $product->slug }}</td>
              <td>
                @if ($product->categories()->count() > 0)
                  @foreach ($product->categories as $children)
                    {{ $children->title }}
                  @endforeach
                @else
                  <strong>{{ "Product" }}</strong>
                @endif
              </td>
              <td>$. {{ $product->price }}</td>
              <td>
                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}"
                class="img-responsive" height="50">
              </td>
              @if ($product->trashed())
                <td>{{ $product->deleted_at }}</td>
                <td>
                  <a href="{{ route('admin.products.recover', $product->id) }}" class="btn btn-info btn-sm">Restore</a>
                  <a href="javascript:;" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $product->id }}')">Delete</a>
                  <form id="delete-product-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->slug) }}" method="post"
                    style="display:none;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                  </form>
                </td>
              @else
              <td>{{ $product->created_at }}</td>
              <td>
                <a href="{{ route('admin.products.edit', $product->slug) }}" class="btn btn-info btn-sm">Edit</a>
                <a id="trash-product-{{ $product->id }}" class="btn btn-warning btn-sm" href="{{ route('admin.products.remove', $product->slug) }}">Trash</a>
                <a href="javascript:;" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $product->id }}')">Delete</a>
                <form id="delete-product-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->slug) }}" method="post"
                  style="display:none;">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                </form>
              </td>
              @endif
            </tr>
          @endforeach
        @else
            <tr>
              <td colspan="12" class="alert alert-info">No Products Found...</td>
            </tr>
        @endif
      </tbody>
    </table>
  </div>
  <div class="row">
    <div class="col-md-12">
      {{ $products->links() }}
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript">
  function confirmDelete(id) {
    let choice = confirm('Are you sure, You want to delete this record??')
    if (choice) {
      document.getElementById('delete-product-' + id).submit();
    }
  }
</script>
@endsection
