<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ route('admin.dashboard') }}">Company name</a>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#">Sign out</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link @if (request()->url() == route('admin.dashboard')) {{ 'active' }}  @endif" href="{{ route('admin.dashboard') }}">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <div class="dropdown">
                <a id="productDropdown" class="nav-link @if (request()->url() == route('admin.products.index')) {{ 'active' }}  @endif dropdown-toggle" href="{{ route('admin.products.index') }}"
                  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span data-feather="shopping-cart"></span>
                  Products
                </a>
                <div class="dropdown-menu" aria-labelledby="productDropdown">
                  <a href="{{ route('admin.products.create') }}" class="dropdown-item">Add Product</a>
                  <a href="{{ route('admin.products.index') }}" class="dropdown-item">All Products</a>
                  <a href="{{ route('admin.products.trash') }}" class="dropdown-item">Trashed Products</a>
                </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a id="categoryDropdown" class="nav-link @if (request()->url() == route('admin.category.index')) {{ 'active' }}  @endif dropdown-toggle" href="{{ route('admin.category.index') }}"
              role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span data-feather="users"></span>
              Categories
            </a>
            <div class="dropdown-menu" aria-labelledby="categoryDropdown">
              <a href="{{ route('admin.category.create') }}" class="dropdown-item">Add Category</a>
              <a href="{{ route('admin.category.index') }}" class="dropdown-item">All Categories</a>
              <a href="{{ route('admin.category.trash') }}" class="dropdown-item">Trashed Categories</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link @if(request()->url() == route('admin.profile.index')) {{ 'active' }} @else {{ '' }} @endif" href="
              {{ route('admin.profile.index') }}">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Integrations
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="d-flex align-items-center text-muted" href="#">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li>
        </ul>
      </div>
    </nav>
