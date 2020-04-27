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
              <li class="breadcrumb-item active"><a href="{{ url('dashboard/categories') }}">{{ trans('site.categories') }}</a></li>
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
           <form action="{{ route('dashboard.categories.update',$category->id) }}" method="post">

            {{ csrf_field() }}
                {{ method_field('put') }}
                @foreach (config('translatable.locales') as $locale)
            <div class="form-group">
                <label for="">{{ trans('site.'. $locale . '.name') }}</label>
                <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ $category->translate($locale)->name }}">
            </div>
            @endforeach





            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> {{ trans('site.edit') }}</button>
            </div>

           </form>
          </div>
        </section>
  </div>

  @endsection
