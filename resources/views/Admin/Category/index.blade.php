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
    <div class="row">
        <div class="col-12">
            @if (session()->has('message'))
                <div class="alert alert-success" id="alert">
                    {{ session()->get('message') }}
                </div>
            @endif
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('messages.category') }}</h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a href="{{ route('category.create') }}" class="btn bg-gradient-info btn-sm">
                                    <i class="fas fa-plus"></i>&nbsp;{{ __('messages.add_new') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('messages.no.') }}</th>
                            <th>{{ __('messages.cate_name') }}</th>
                            <th>{{ __('messages.category') }}</th>
                            <th>{{ __('messages.view') }}</th>
                            <th>{{ __('messages.edit') }}</th>
                            <th>{{ __('messages.delete') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- page script -->
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('category.data') }}",
                "columns": [{
                    "data": null
                },
                    {
                        "data": "name",
                        "render": function(data, type, row, meta) {
                            var url = '{{ route("category.edit",":id") }}';
                            url = url.replace(':id', row.id);
                            return '<a href="' + url + '">' + data + '</a>';
                        }
                    },
                    {
                        "data": "type_name",
                    },
                    {
                        "data": null,
                        "render": function(data, type, row, meta) {
                            var url = '{{ route("category.show",":id") }}';
                            url = url.replace(':id', row.id);
                            return '<a href="' + url + '" title="{{ __('messages.view') }}"><img src="{{ asset('img/view.svg') }}" width="30" height="30"></a>';
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, row, meta) {
                            var url = '{{ route("category.edit",":id") }}';
                            url = url.replace(':id', row.id);
                            return '<a href="' + url + '" title="{{ __('messages.edit') }}"><img src="{{ asset('img/edit.svg') }}" width="30" height="30"></a>';
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, row, meta) {
                            var url = '{{ route("category.destroy",":id") }}';
                            url = url.replace(':id', row.id);
                            return '<form action="' + url + '" method="post">@csrf @method('DELETE')<button type="submit" class="btn p-0 border-0 bg-transparent" onclick="return confirm(' + "'{{ __('messages.delete_confirmation') }}'" + ')" title="{{ __('messages.delete') }}"><img src="{{ asset('img/delete.svg') }}" width="30" height="30"></button></form>';
                        }
                    }
                ],
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "{{ __('messages.all') }}"]
                ],
                "pagingType": "full_numbers",
                "responsive": {
                    "details": false
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0,3,4,5]
                },
                    {
                        "responsivePriority": 1,
                        "targets": [1,2,3,5]
                    },
                    {
                        "className": "text-center",
                        "targets": [0,2,3,4]
                    }
                ],
                "order": [
                    [1, 'asc']
                ],
                "language": {
                    "processing": "{{ __('messages.processing') }}...",
                    "info": "{{ __('messages.showing') }} _START_ {{ __('messages.to') }} _END_ {{ __('messages.of') }} _TOTAL_ {{ __('messages.entries') }}",
                    "infoEmpty": "{{ __('messages.infoEmpty') }}",
                    "infoFiltered": "({{ __('messages.filtered') }} {{ __('messages.from') }} _MAX_ {{ __('messages.total') }} {{ __('messages.entries') }})",
                    "lengthMenu": "{{ __('messages.show') }} _MENU_ {{ __('messages.entries') }}",
                    "paginate": {
                        "first": "«",
                        "last": "»",
                        "next": "›",
                        "previous": "‹"
                    },
                    "search": "{{ __('messages.search') }}:",
                    "emptyTable": "{{ __('messages.emptyTable') }}",
                    "zeroRecords": "{{ __('messages.zeroRecords') }}"
                }
            });
            table.on('draw.dt', function() {
                var info = table.page.info();
                table.column(0, {
                    search: 'applied',
                    order: 'applied',
                    page: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + info.start;
                });
            });
        });
    </script>
@endsection
