@extends('layouts.backend')
@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('messages.list') }} {{ __('messages.category') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('messages.category') }} </li>
            </ol>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
    </div>
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i>
                @foreach ($errors->all() as $error)
                   {{ $error }}
                @endforeach
            </h5>
        </div>
    @endif
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('messages.add_new') }} {{ __('messages.category') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{ route('category.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('messages.cate_name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" onkeyup="ChangeToSlug();" placeholder="{{ __('messages.cate_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('messages.description') }}</label>
                            <textarea type="text" class="form-control" name="description" id="descriptions" placeholder="{{ __('messages.description') }}"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="type">{{ __('messages.type') }}</label><br>
                            @foreach($type as $item)
                                <input type="radio" id="type" name="type" value="{{$item->id}}">
                                <label for="type">{{$item->name}}</label>&#160;&#160;&#160;&#160;
                            @endforeach
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                        <button type="reset" class="btn btn-success"><i class="fas fa-redo-alt"></i> Reset</button>
                        <button type="button" class="btn btn-danger" onclick="javascript:window.location='{{ route('category.index') }}';"><i class="fas fa-sign-out-alt"></i> Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-4">
            <!-- general form elements disabled -->
            <div class="card card-light">
                <div class="card-header">
                    <h3 class="card-title">{{ __('messages.static_path') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                        <div class="row">
                            <label>{{ __('messages.slug') }}</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="{{ __('messages.slug') }}" disabled="" >
                        </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!--/.col (right) -->
    </div>
@endsection
