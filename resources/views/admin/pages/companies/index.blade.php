@extends('admin.layout')
@section('title')
    Companies
@endsection
@section('companies')
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
                            <h5 class="m-0">Companies</h5>
                            <a href="{{route('companies.create')}}" class="btn btn-primary float-right">Add New Company</a>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Logo</th>
                                        <th>Website</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            {{-- MODAL EDIT --}}
            <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Edit: </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Logo</label>
                                    <input type="file" class="form-control" name="file">
                                </div>
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" id="website" class="form-control" name="website">
                                </div>

                                <a type="button" class="btn btn-warning float-right ml-2" data-dismiss="modal">CANCEL</a>
                                <button class="btn btn-success float-right">UPDATE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MODAL DELETE --}}
            <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="delete-modal-label">Delete: </h4>
                        </div>
                        <div class="modal-body">Are you sure want to delete data?</div>
                        <div class="modal-footer">
                            <form method="POST">
                                @csrf
                                @method('DELETE')
                                <button  class="btn btn-danger">YES</button>
                            </form>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">NO, CANCEL</button>
                        </div>
                    </div>

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('footer')
    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('get.companies')}}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'logo', name: 'logo', orderable: false, searchable: false },
                    { data: 'website', name: 'website' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });

        $('#edit-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var submit = button.data('submit')
            var name = button.data('name')
            var email = button.data('email')
            var website = button.data('website')

            var modal = $(this)
            modal.find('.modal-title').text('Edit: ' + name)
            modal.find('.modal-body form').attr('action', submit)
            modal.find('.modal-body #name').val(name)
            modal.find('.modal-body #email').val(email)
            modal.find('.modal-body #website').val(website)
        });

        $('#delete-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var name = button.data('name')
            var submit = button.data('submit')

            var modal = $(this)
            modal.find('.modal-title').text('Delete: ' + name)
            modal.find('.modal-footer form').attr('action', submit)
        });
    </script>
@endsection
