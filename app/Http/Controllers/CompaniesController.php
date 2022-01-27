<?php

namespace App\Http\Controllers;

use App\Companies;
use App\Employees;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CompaniesController extends Controller
{
    public function get_companies()
    {
        $data = Companies::orderBy('id', 'desc');
        return DataTables::of($data)
            ->editColumn('logo', function ($data){
                return '<img class="img-responsive" style="width:150px;" src="'.asset('storage/'.$data->logo).'">';
            })
            ->editColumn('website', function ($data){
                return '<a href="'.$data->website.'" target="_blank">'.$data->website.'</a>';
            })
            ->addColumn('action', function ($data){
                $edit = '<a class="btn btn-warning" data-toggle="modal" data-target="#edit-modal" data-submit="'.url('admin/companies/'.$data->id).'" data-name="'.$data->name.'" data-email="'.$data->email.'" data-website="'.$data->website.'">edit</a>';
                $delete = '<a class="btn btn-danger" data-toggle="modal" data-target="#delete-modal" data-submit="'.url('admin/companies/'.$data->id).'" data-name="'.$data->name.'">delete</a>';
                return '<div class="btn btn-group">'.$edit.$delete.'</div>';
            })
            ->rawColumns(['logo','website','action'])
            ->make(true);
    }

    public function index()
    {
        return view('admin.pages.companies.index');
    }

    public function create()
    {
        return view('admin.pages.companies.add');
    }

    public function destroy($id)
    {
        if (Employees::where('company', $id)->first())
        {
            return redirect()->back()->withAlert('Data cant be deleted, is being used by employee data');
        }
        Companies::where('id', $id)->delete();
        return redirect()->back()->withAlert('Data deleted');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails())
        {
            $messages = '';
            foreach ($validator->getMessageBag()->toArray() as $key => $value)
            {
                $messages .= $value[0] .' ';
            }
            return redirect()->back()->withDanger($messages);
        }

        $file = $request->file('file');
        if ($file)
        {
            $nama_file = time()."_".$file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            Storage::putFileAs('public', $file, $nama_file);

            $simpan = new Companies;
            $simpan->name = $request->name;
            $simpan->email = $request->email;
            $simpan->logo = $nama_file;
            $simpan->website = $request->website;
            $simpan->save();
        }else{
            $simpan = new Companies;
            $simpan->name = $request->name;
            $simpan->email = $request->email;
            $simpan->website = $request->website;
            $simpan->save();
        }
        return redirect()->route('companies.index')->withAlert('Data saved');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails())
        {
            $messages = '';
            foreach ($validator->getMessageBag()->toArray() as $key => $value)
            {
                $messages .= $value[0] .' ';
            }
            return redirect()->back()->withDanger($messages);
        }

        $file = $request->file('file');
        if ($file)
        {
            $logo = time()."_".$file->getClientOriginalName();
            $logo = str_replace(' ', '', $logo);
            Storage::putFileAs('public', $file, $logo);

            Companies::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'logo' => $logo,
                    'website' => $request->website
                ]);
        }else{
            Companies::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'website' => $request->website
                ]);
        }
        return redirect()->route('companies.index')->withAlert('Data updated');
    }
}
