@extends('admin.layout')
@section('title') Add New Employee @endsection
@section('employees')
    active
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Add New Employee</h5>
                            <a href="{{route('employees.index')}}" class="btn btn-primary float-right">Data Employees</a>
                        </div>
                        <div class="card-body">
                            <form action="{{route('employees.store')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name">
                                </div>
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last_name">
                                </div>
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control" name="company">
                                        @foreach(App\Companies::all() as $item_company)
                                            <option value="{{$item_company->id}}">{{$item_company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>

                                <button class="btn btn-success float-right">SAVE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
