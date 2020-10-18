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
    <form method="post" action="{{ route('product.update',$product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                            <input type="text" class="form-control" id="name" name="name" onkeyup="ChangeToSlug();" placeholder="{{ __('messages.cate_name') }}" value="{{$product->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('messages.description') }}</label>
                            <textarea type="text" class="form-control" name="description" id="description" placeholder="{{ __('messages.description') }}">{{$product->description}}</textarea>
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
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="{{ __('messages.slug') }}" disabled="" value="{{$product->slug}}">
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
                                    <option value="{{$item->id }}" @if($product->category_id == $item->id) selected @endif>{{$item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="quantity">{{ __('messages.quantity') }}</label>
                                <input type="number" step="0.01" min="0" max="10000" class="form-control"  value="{{ $product->quantity }}" name="quantity" id="quantity" placeholder="{{ __('messages.quantity') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="quantity">{{ __('messages.unit') }}</label>
                                <select class="form-control" name="unit">
                                    <option value="{{ __('messages.fruit') }}" @if($product->unit == 'Trái') selected @endif>{{ __('messages.fruit') }}</option>
                                    <option value="{{ __('messages.Kg') }}" @if($product->unit == 'Kg') selected @endif>{{ __('messages.Kg') }}</option>
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
                    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
                    <link rel="stylesheet" type="text/css" href="{{ asset('fancybox/jquery.fancybox-1.3.4.css') }}" media="screen" />
                    <script type="text/javascript" src="{{ asset('fancybox/jquery.fancybox-1.3.4.pack.js')}}"></script>
                    <div class="card-body">
                        <div class="row">
                            <label for="avatar">{{ __('messages.avatar') }}</label>
                            <div class="input-group">
                                <input type="text" name="message" placeholder="" class="form-control">
                                <span class="input-group-append">
                                    <button href="{{ asset('/assets/filemanager/dialog.php?type=1&field_id=fieldID') }}" type="button" id="avatar" class="btn  btn-primary iframe-btn" >{{ __('messages.upload_avatar') }}</button>
                                </span>
                            </div>
                        </div><br>
                        <div class="row">
                            @if($product->path_avatar == null)
                                <em>{{ __('messages.avatar_null') }}</em>
                            @else
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch3" name="delete_avatar" >
                                    <label class="custom-control-label" for="customSwitch3">{{ __('messages.delete_avatar') }}</label>
                                </div>
                                <img src="{{ asset($product->path_avatar) }}" id="avatar_img" width="100%" height="50%" border="1px">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        $('.iframe-btn').fancybox({
            'width'		: 900,
            'height'	: 600,
            'type'		: 'iframe',
            'autoScale'    	: false
        });
    </script>
    <script type="text/javascript">
        function responsive_filemanager_callback(field_id){
            console.log(field_id);
            var url=jQuery('#'+field_id).val();
            alert('update '+field_id+" with "+url);
            //your code
        }
    </script>
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
