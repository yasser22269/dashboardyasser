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
                <li class="breadcrumb-item active">{{ trans('site.categories') }}</li> </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card-header with-border">
            <h3 class="card-title">{{ trans('site.categories') }} <small>{{ $categories->total() }}</small></h3>
          </div>
          <form action="{{ route("dashboard.categories.index") }}" method="GET">
              <div class="row">
                  <div class="col-md-4">
                    <input type="text" name="search" value="{{ request()->search }}" class='form-control'plaseholer="{{ trans('site.search') }}">
                  </div>
                  <div class="col-md-4">
                      <button type="submit"class="btn btn-primary btn-sm"><i class="fa fa-search"></i> {{ trans('site.search') }}</button>
                      @if (auth()->user()->hasPermission('create_categories'))
                      <a  class="btn btn-info btn-sm" href="{{ route("dashboard.categories.create") }}"><i class="fa fa-plus"></i>{{ trans('site.add') }}</a>
                        @else
                        <a  class="btn btn-info btn-sm disabled" href="#"><i class="fa fa-plus"></i>{{ trans('site.add') }}</a>

                      @endif
                    </div>
              </div>
           </form>
          <br>
          <div class="card-body">
           @if ($categories->Count() > 0)
           <table class="table table-hover">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>{{ trans('site.name') }}</th>
                <th>{{ trans('site.products_count') }}</th>
                <th>{{ trans('site.related_products') }}</th>
                <th >{{ trans('site.action') }}</th>
              </tr>
            </thead>
            <tbody>

                  @foreach ($categories as $index => $Category)
                     <tr>
                           <td>{{  $index +1 }}</td>
                        <td>{{  $Category->name }}</td>
                        <td>{{  $Category->products->count() }}</td>
                        <td><a href="{{ route('dashboard.products.index',['category_id'=> $Category->id]) }}" class="btn btn-info btn-sm">{{ trans('site.related_products') }}</a></td>
                        <td>
                            @if (auth()->user()->hasPermission('update_categories'))
                            <a  class="btn btn-info btn-sm" href="{{ route("dashboard.categories.edit",$Category->id) }}"><i class="fa fa-edit"></i>  {{ trans('site.edit') }}</a>

                            @else
                            <a  class="btn btn-info btn-sm disabled"  href="#"><i class="fa fa-edit"></i>  {{ trans('site.edit') }}</a>

                            @endif
                            @if (auth()->user()->hasPermission('delete_categories'))
                            <form action="{{ route("dashboard.categories.destroy",$Category->id) }}" method="post" style="display:inline-block">
                                 {{ csrf_field() }}
                                 {{ method_field('delete') }}
                                 <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i>  {{ trans('site.delete') }}</button>
                            </form>
                            @else
                                <button type="submit" class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i>   {{ trans('site.delete') }}</button>

                            @endif
                        </td>
                        <tr>
                  @endforeach


              </tr>

            </tbody>
          </table>
          {{ $categories->appends(request()->query())->links() }}
          @else

            <p class="alert alert-danger alert-sm">{{ trans('site.no_data_found') }}</p>


           @endif
          </div>
    </section>

  </div>

  @endsection
