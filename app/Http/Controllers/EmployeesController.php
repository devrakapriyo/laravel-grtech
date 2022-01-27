<?php

namespace App\Http\Controllers;

use App\Companies;
use App\Employees;
use App\Notification;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EmployeesController extends Controller
{
    public function get_employees()
    {
        $data = Employees::orderBy('id', 'desc');
        return DataTables::of($data)
            ->editColumn('fullName', function($data) {
                return "{$data->fullName}";
            })
            ->editColumn('company', function($data) {
                $company = Companies::where('id', $data->company)->first();
                return '<a style="cursor: pointer;" data-toggle="modal" data-target="#company-modal" data-name="'.$company->name.'" data-email="'.$company->email.'" data-logo="'.asset('storage/'.$company->logo).'" data-website="'.$company->website.'">'.$company->name.'</a>';
            })
            ->addColumn('action', function ($data){
                $edit = '<a class="btn btn-warning" data-toggle="modal" data-target="#edit-modal" data-submit="'.url('admin/employees/'.$data->id).'" data-fullname="'.$data->fullName.'" data-firstname="'.$data->first_name.'" data-lastname="'.$data->last_name.'" data-email="'.$data->email.'" data-phone="'.$data->phone.'" data-company="'.$data->company.'">edit</a>';
                $delete = '<a class="btn btn-danger" data-toggle="modal" data-target="#delete-modal" data-submit="'.url('admin/employees/'.$data->id).'" data-fullname="'.$data->fullName.'">delete</a>';
                return '<div class="btn btn-group">'.$edit.$delete.'</div>';
            })
            ->rawColumns(['fullName','company','action'])
            ->make(true);
    }

    public function index()
    {
        return view('admin.pages.employees.index');
    }

    public function create()
    {
        return view('admin.pages.employees.add');
    }

    public function destroy($id)
    {
        Employees::where('id', $id)->delete();
        return redirect()->back()->withAlert('Data deleted');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
        ]);

        if ($validator->fails())
        {
            $messages = '';
            foreach ($validator->getMessageBag()->toArray() as $key => $value)
            {
                $messages .= $value[0].' ';
            }
            return redirect()->back()->withDanger($messages);
        }

        $simpan = new Employees;
        $simpan->first_name = $request->first_name;
        $simpan->last_name = $request->last_name;
        $simpan->company = $request->company;
        $simpan->email = $request->email;
        $simpan->phone = $request->phone;
        $simpan->save();

        $company = Companies::find($request->company);
        $messages_mail = "
        <h3>New Employee is Added.</h3>
        <p>
        Fullname : $simpan->fullName<br>
        Email : $simpan->email<br>
        Phone : $simpan->phone<br>
        Company : $company->name
        </p>";
        Notification::notificationMail($company->email, 'new employee is added.', $messages_mail);

        return redirect()->route('employees.index')->withAlert('Data saved');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
        ]);

        if ($validator->fails())
        {
            $messages = '';
            foreach ($validator->getMessageBag()->toArray() as $key => $value) {
                $messages .= $value[0] .' ';
            }
            return redirect()->back()->withDanger($messages);
        }

        Employees::where('id', $id)
            ->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company' => $request->company,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

        return redirect()->route('employees.index')->withAlert('Data updated');
    }
}
