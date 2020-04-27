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
                <li class="breadcrumb-item active">{{ trans('site.users') }}</li> </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card-header with-border">
            <h3 class="card-title">{{ trans('site.users') }} <small>{{ $users->total() }}</small></h3>
          </div>
          <form action="{{ route("dashboard.users.index") }}" method="GET">
              <div class="row">
                  <div class="col-md-4">
                    <input type="text" name="search" value="{{ request()->search }}" class='form-control'plaseholer="{{ trans('site.search') }}">
                  </div>
                  <div class="col-md-4">
                      <button type="submit"class="btn btn-primary btn-sm"><i class="fa fa-search"></i> {{ trans('site.search') }}</button>
                      @if (auth()->user()->hasPermission('create_users'))
                      <a  class="btn btn-info btn-sm" href="{{ route("dashboard.users.create") }}"><i class="fa fa-plus"></i>{{ trans('site.add') }}</a>
                        @else
                        <a  class="btn btn-info btn-sm disabled" href="#"><i class="fa fa-plus"></i>{{ trans('site.add') }}</a>

                      @endif
                    </div>
              </div>
          </form>
          <br>
          <div class="card-body">
           @if ($users->Count() > 0)
           <table class="table table-hover">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>{{ trans('site.first_name') }}</th>
                <th>{{ trans('site.last_name') }}</th>
                <th >{{ trans('site.email') }}</th>
                <th >{{ trans('site.image') }}</th>
                <th >{{ trans('site.action') }}</th>
              </tr>
            </thead>
            <tbody>

                  @foreach ($users as $index => $user)
                     <tr>
                           <td>{{  $index +1 }}</td>
                        <td>{{  $user->first_name }}</td>
                        <td>{{  $user->last_name }}</td>
                        <td>{{  $user->email }}</td>
                        <td><img src="{{  $user->image_path }}"style='width:100px'class='img-thumbnail' alt=""></td>
                        <td>
                            @if (auth()->user()->hasPermission('update_users'))
                            <a  class="btn btn-info btn-sm" href="{{ route("dashboard.users.edit",$user->id) }}"><i class="fa fa-edit"></i>  {{ trans('site.edit') }}</a>

                            @else
                            <a  class="btn btn-info btn-sm disabled"  href="#"><i class="fa fa-edit"></i>  {{ trans('site.edit') }}</a>

                            @endif
                            @if (auth()->user()->hasPermission('delete_users'))
                            <form action="{{ route("dashboard.users.destroy",$user->id) }}" method="post" style="display:inline-block">
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
          {{ $users->appends(request()->query())->links() }}
          @else

            <p class="alert alert-danger alert-sm">{{ trans('site.no_data_found') }}</p>


           @endif
          </div>
    </section>

  </div>

  @endsection
