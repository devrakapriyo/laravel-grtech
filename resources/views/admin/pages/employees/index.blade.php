@extends('admin.layout')
@section('title') Employees @endsection
@section('employees')
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
                            <h5 class="m-0">Search</h5>
                        </div>
                        <div class="card-body">
                            <form id="form-search">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>From</label>
                                            <input type="date" name="from" id="from" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>To</label>
                                            <input type="date" name="to" id="to" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Company</label>
                                            <select name="company" id="company" class="form-control">
                                                <option value=""></option>
                                                @foreach(\App\Companies::get_field(['id','name']) as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group float-right">
                                            <button class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Employees</h5>
                            <a href="{{route('employees.create')}}" class="btn btn-primary float-right">Add New Employee</a>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Phone</th>
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
                            <form method="POST">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" id="firstname" class="form-control" name="first_name">
                                </div>
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" id="lastname" class="form-control" name="last_name">
                                </div>
                                <div class="form-group">
                                    <label>Company</label>
                                    <select id="company" class="form-control" name="company">
                                        @foreach(App\Companies::all() as $item_company)
                                            <option value="{{$item_company->id}}">{{$item_company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" id="phone" class="form-control" name="phone">
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

            {{-- MODAL COMPANY --}}
            <div class="modal fade" id="company-modal" tabindex="-1" role="dialog" aria-labelledby="company-modal-label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="company-modal-label">Company</h4>
                        </div>
                        <div class="modal-body">
                            <img id="logo" onerror="hideLogo()" style="max-width: 100px" class="img-responsive mb-3">
                            <p id="name">Name: </p>
                            <p id="email">Email: </p>
                            <p>Website: <a target="_blank" id="website"></a></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                ajax: '{{route('get.employees')}}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'fullName', name: 'fullName' },
                    { data: 'company', name: 'company' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });

        $('#edit-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var fullname = button.data('fullname')
            var submit = button.data('submit')
            var firstname = button.data('firstname')
            var lastname = button.data('lastname')
            var company = button.data('company')
            var email = button.data('email')
            var phone = button.data('phone')

            var modal = $(this)
            modal.find('.modal-title').text('Edit: ' + fullname)
            modal.find('.modal-body form').attr('action', submit)
            modal.find('.modal-body #firstname').val(firstname)
            modal.find('.modal-body #lastname').val(lastname)
            modal.find('.modal-body #email').val(email)
            modal.find('.modal-body #company option[value='+company+']').attr('selected','selected')
            modal.find('.modal-body #phone').val(phone)
        });

        $('#delete-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var fullname = button.data('fullname')
            var submit = button.data('submit')

            var modal = $(this)
            modal.find('.modal-title').text('Delete: ' + fullname)
            modal.find('.modal-footer form').attr('action', submit)
        });

        $('#company-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var name = button.data('name')
            var email = button.data('email')
            var logo = button.data('logo')
            var website = button.data('website')

            console.log(name);
            var modal = $(this)
            modal.find('.modal-body #name').text('Name: ' + name)
            modal.find('.modal-body #email').text('Email: ' + email)
            modal.find('.modal-body #logo').attr('src', logo)
            modal.find('.modal-body #website').attr('href', website).text(website)
        });

        function hideLogo() {
            document.getElementById("logo").style.display = "none";
        }

        $("#form-search").on('submit', function (e) {
            $('#datatable').DataTable().destroy();
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    'url': '{{url('admin/get/employees/search')}}' + '?from=' + $('#from').val() + '&to=' + $('#to').val() + '&email=' + $('#email').val() + '&first_name=' + $('#first_name').val() + '&last_name=' + $('#last_name').val() + '&company=' + $('#company').val(),
                    'type': 'get'
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'fullName', name: 'fullName' },
                    { data: 'company', name: 'company' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            e.preventDefault();
        });
    </script>
@endsection
