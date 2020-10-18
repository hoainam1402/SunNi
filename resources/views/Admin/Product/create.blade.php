@extends('layouts.backend')
@section('content')
    <style>
        img {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 100%;
        }

        img:hover {
            box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
        }

    </style>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('messages.list') }} {{ __('messages.product') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('messages.product') }} </li>
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
    <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!--/.col (left) -->
            <div class="col-md-9">
                <!-- /.card -->
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.add_new') }} {{ __('messages.product') }}</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('messages.product_name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" onkeyup="ChangeToSlug();" placeholder="{{ __('messages.cate_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('messages.description') }}</label>
                            <textarea type="text" class="form-control" name="description" id="description" placeholder="{{ __('messages.description') }}"></textarea>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('messages.save') }}</button>
                        <button type="reset" class="btn btn-success"><i class="fas fa-redo-alt"></i> {{ __('messages.reset') }}</button>
                        <button type="button" class="btn btn-danger" onclick="javascript:window.location='{{ route('product.index') }}';"><i class="fas fa-sign-out-alt"></i> {{ __('messages.cancel') }}</button>
                    </div>
                </div>
            </div>
            <!--/.col (right) -->
            <div class="col-md-3">
                <div class="card card-light">
                    <!-- /.card-header -->
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.static_path') }}</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        <div class="row">
                            <label>{{ __('messages.slug') }}</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="{{ __('messages.slug') }}" disabled="" >
                        </div>
                    </div>
                </div>
                <div class="card card-light">
                    <!-- /.card-header -->
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.category') }}</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        <div class="row">
                            <label for="quantity">{{ __('messages.category') }}</label>
                            <select class="form-control" id="category_id" name="category_id">
                                @foreach($category as $item)
                                    <option value="{{$item->id }}">{{$item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="quantity">{{ __('messages.quantity') }}</label>
                                <input type="number" step="0.01" min="0" max="10000" class="form-control" name="quantity" id="quantity" placeholder="{{ __('messages.quantity') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="quantity">{{ __('messages.unit') }}</label>
                                <select class="form-control" name="unit">
                                    <option value="{{ __('messages.fruit') }}">{{ __('messages.fruit') }}</option>
                                    <option value="{{ __('messages.Kg') }}">{{ __('messages.Kg') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-light">
                    <!-- /.card-header -->
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.avatar') }}</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        <div class="row">
                            <label for="avatar">{{ __('messages.avatar') }}</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" placeholder="{{ __('messages.avatar') }}"  onchange="readURL(this);" accept="image/aces">
                        </div><br>
                        <div class="row">
                            <img id="avatar_img" width="100%" height="50%" border="1px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#avatar_img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#avatar").change(function(){
            readURL(this);
        });
    </script>
@endsection
