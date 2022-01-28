@extends('admin.layout')
@section('title')
    Employees
@endsection
@section('daily-quotes')
    active
@endsection
@section('header')
    <link href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Dialy Quotes</h5>
                            <a id="refresh" class="btn btn-primary float-right">Refresh</a>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                <tr>
                                    <th>Quotes</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#refresh").click(function() {
                $('#datatable').DataTable().ajax.reload();
            });
        });

        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                ordering: false,
                ajax: '{{url('admin/get/daily-quotes')}}' + '?api_token={{ Auth::user()->remember_token }}',
                columns: [
                    { data: 'h', name: 'action', render: function(data){
                            return ''+data+'';
                        }
                    },
                ]
            });
        });
    </script>
@endsection
