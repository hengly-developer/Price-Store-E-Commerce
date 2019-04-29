@extends('admin.app')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}">Dashboard</a> </li>
<li class="breadcrumb-item active"> <a href="{{ route('admin.category.index') }}">Category</a> </li>
<li class="breadcrumb-item active" aria-current="page">Add/Edit Category</li>
@endsection
@section('content')
  <div class="col-md-12">
    <form action="@if(isset($category)) {{ route('admin.category.update', $category->id) }} @else {{ route('admin.category.store') }} @endif" method="post" accept-charset="utf-8">
      {{ csrf_field() }}
      @if (isset($category))
        {{ method_field('PUT') }}
      @endif
      <div class="form-group row">
        <div class="col-md-12">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
        <div class="col-md-12">
          @if (session()->has('message'))
            <div class="alert alert-success">
              {{ session('message') }}
            </div>
          @endif
        </div>
        <div class="col-sm-12">
          <label for="form-control-label">Title:</label>
          <input type="text" id="txturl" name="title" id="title" class="form-control" value="{{ @$category->title }}">
          <p class="small">{{ config('app.url') }} <span id="url">{{ @$category->slug }}</span> </p>
          <input type="hidden" name="slug" id="slug" value="{{ @$category->slug }}">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-12">
          <label for="form-control-label">Title:</label>
          <textarea name="description" id="editor" class="form-control" rows="10" cols="80">{!! @$category->description !!}</textarea>
        </div>
      </div>
      <div class="form-group row">
        @php
          $ids = (isset($category->childrens) && $category->childrens->count() > 0) ? array_pluck($category->childrens, 'id') : null
        @endphp
        <div class="col-sm-12">
          <label for="form-control-label">Select Category:</label>
          <select class="form-control" name="parent_id[]" multiple="multiple" id="parent_id">
            @if (isset($categories))
              <option value="0">Top Level</option>
              @foreach ($categories as $cate)
                <option value="{{ $cate->id }}" @if(!is_null($ids) && in_array($cate->id, $ids)) {{ 'selected' }} @endif>{{ $cate->title }}</option>
              @endforeach
            @endif
          </select>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-12">
          @if(isset($category))
            <input type="submit" name="submit" value="Edit Category" class="btn btn-primary">
          @else
            <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
          @endif
        </div>
      </div>
    </form>
  </div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script>
      $(document).ready(function() {
        ClassicEditor.create(document.querySelector('#editor'), {
          toolbar: ['Heading', 'Link', 'bold', 'italic', 'bulletedList', 'numberedList',
          'blockQuote', 'undo', 'redo'],
        }).then(editor => {
          console.log(editor);
        }).catch(error => {
          console.error(error);
        })
        $('#txturl').on('keyup', function() {
          var url = slugify($(this).val());
          $('#url').html(url);
          $('#slug').val(url);
        })
        $('#parent_id').select2({
          placeholder: "Select a Parent Category",
          allowClear: true,
          // minimumResultsForSearch: Infinity
        });
      });
  </script>
@endsection
