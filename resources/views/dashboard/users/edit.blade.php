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
              <li class="breadcrumb-item active"><a href="{{ url('dashboard/users') }}">{{ trans('site.users') }}</a></li>
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
           <form action="{{ route('dashboard.users.update',$user->id) }}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}
                {{ method_field('put') }}
            <div class="form-group">
                <label for="">{{ trans('site.first_name') }}</label>
                <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
            </div>
            <div class="form-group">
                <label for="">{{ trans('site.last_name') }}</label>
                <input type="text" name="last_name" class="form-control" value="{{$user->last_name  }}">
            </div>
            <div class="form-group">
                <label for="">{{ trans('site.email') }}</label>
                <input type="email" name="email" class="form-control" value="{{$user->email  }}">
            </div>
            <div class="form-group">
                <label for="">{{ trans('site.image') }}</label>
                <input type="file" name="image" class="form-control image">
            </div>
            <div class="form-group">
                <img class='img-thumbnail img-preview 'src="{{ $user->image_path }}"style='width:100px' alt="">
            </div>
            <div class="row">
                <div class="col-12">
                  <!-- Custom Tabs -->
                  <div class="card">
                    <div class="card-header d-flex p-0">
                      <h3 class="card-title p-3">{{ trans('site.permissions') }}</h3>
                      <ul class="nav nav-pills ml-auto p-2">
                        @php
                         $models = ['users','categories','products','clients','orders'];
                            $maps = ['create','read','update','delete'];

                        @endphp

                        @foreach ($models as $items=>$model)
                        <li class="nav-item"><a class="nav-link {{ $items == 0 ? 'active' : '' }}" href="#{{ $model }}" data-toggle="tab">{{ trans('site.'.$model) }}</a></li>

                        @endforeach

                        </li>
                      </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                      <div class="tab-content">
                        @foreach ($models as $items=>$model)
                        <div class="tab-pane {{ $items == 0 ? 'active' : '' }}" id="{{ $model }}">
                            <div class="form-check">
                                @foreach ($maps as $map)
                                <input type="checkbox" class="form-check-input"name='permissions[]'{{ $user->hasPermission($map . '_'. $model) ? 'checked': '' }}  value='{{$map . '_'. $model }}' id="exampleCheck1">
                                <label class="form-check-label " for="exampleCheck1">{{ trans('site.'.$map) }}</label>

                                @endforeach



                              </div>
                        </div>
                          @endforeach

                      </div>
                      <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                  </div>
                  <!-- ./card -->
                </div>
                <!-- /.col -->
              </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> {{ trans('site.edit') }}</button>
            </div>

           </form>
          </div>
        </section>
  </div>

  @endsection
