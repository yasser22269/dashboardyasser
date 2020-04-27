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
              <li class="breadcrumb-item active"><a href="{{ url('dashboard/clients') }}">{{ trans('site.clients') }}</a></li>
              <li class="breadcrumb-item active">{{ trans('site.add') }}</li>

            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card-header with-border">
            <h3 class="card-title">{{ trans('site.add') }}</h3>
            <br>
          </div>
          <div class="card-body">
              @include('partials._errors')
           <form action="{{ route('dashboard.clients.store') }}" method="post">

            {{ csrf_field() }}
                {{ method_field('post') }}


            <div class="form-group">
                <label for="">{{ trans('site.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            @for($i = 1; $i <= 2; $i++)
                <div class="form-group">
                    <label for="">{{ trans('site.phone') . $i }} </label>
                    <input type="text" name="phone[]" class="form-control" value="">
                </div>
            @endfor

             <div class="form-group">
                <label for="">{{ trans('site.address') }}</label>
                <textarea  name="address" class="form-control" value="{{ old('address') }}">
            </textarea>
            </div>






              <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('site.add') }}</button>
            </div>

           </form>
          </div>
        </section>
  </div>

  @endsection
