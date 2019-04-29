<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('css')
</head>
<body>
    <div id="app">

      <main role="main" class="col-md-12 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
        </div>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
          <a href="{{ route('admin.dashboard') }}" class="navbar-brand col-sm-3 col-md-2 mr-0">Company Name</a>
          <input type="text" class="form-control form-control-dark w-100" placeholder="Search" aria-label="Search">
          <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
              <a href="#" class="nav-link">Sign Out</a>
            </li>
          </ul>
        </nav>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  @yield('breadcrumb')
                </ol>
              </nav>
            </div>
          </div>
          <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            @include('admin.partials.navbar')
          </nav>
          <div class="col-md-12">
            @yield('content')
          </div>
        </div>
      </main>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
