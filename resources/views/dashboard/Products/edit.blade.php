@extends('layouts.dashboard.app')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          {{-- <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ trans('site.Dashboard') }}</h1>
          </div><!-- /.col --> --}}
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="{{ url('dashboard/index') }}">{{ trans('site.Dashboard') }}</a></li>
              <li class="breadcrumb-item active"><a href="{{ url('dashboard/products') }}">{{ trans('site.products') }}</a></li>
              <li class="breadcrumb-item active">{{ trans('site.edit') }}</li>

            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card-header with-border">
            <h3 class="card-title">{{ trans('site.edit') }}</h3>
            <br>
          </div>
          <div class="card-body">
              @include('partials._errors')
           <form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}
                {{ method_field('put') }}

            <div class="form-group">
                <label for="">{{ trans('site.categories') }}</label>
                <select name="category_id" class="form-control">
                    <option value="">{{ trans('site.all_categories') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                    @endforeach
                </select>

            </div>


            @foreach (config('translatable.locales') as $locale)
            <div class="form-group">
                <label for="">{{ trans('site.'. $locale . '.name') }}</label>
                <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ $product->name }}">
            </div>

            <div class="form-group">
                <label for="">{{ trans('site.'. $locale . '.description') }}</label>
                <textarea  name="{{$locale}}[description]" class="form-control ckeditor">{{ $product->description }}</textarea>
            </div>
            @endforeach


            <div class="form-group">
                <label for="">{{ trans('site.image') }}</label>
                <input type="file" name="image" class="form-control image">
            </div>
            <div class="form-group">
                <img class='img-thumbnail img-preview 'src="{{  $product->image_path }}"style='width:100px' alt="">
            </div>

            <div class="form-group">
                <label for="">{{ trans('site.purchase_price') }}</label>
                <input type="number" name="purchase_price" class="form-control"  value="{{  $product->purchase_price}}">
            </div>
            <div class="form-group">
                <label for="">{{ trans('site.sale_price') }}</label>
                <input type="number" name="sale_price" class="form-control"  value="{{ $product->sale_price}}">
            </div>
            <div class="form-group">
                <label for="">{{ trans('site.stoke') }}</label>
                <input type="number" name="stoke" class="form-control"  value="{{ $product->stoke }}">
            </div>
              <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('site.edit') }}</button>
            </div>

           </form>
          </div>
        </section>
  </div>

  @endsection
