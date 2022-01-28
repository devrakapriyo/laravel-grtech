<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use Yajra\DataTables\DataTables;
use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class DialyQuotesController extends Controller
{
    public function index()
    {
        return view('admin.pages.dialyquotes.index');
    }

    public function get_daily_quotes(Request $request)
    {
        $token = User::where(['remember_token'=>$request->api_token])->first();
        if ($token)
        {
            $client = new Client();
            //$response = $client->request('GET', 'https://zenquotes.io/api/quotes', [
            //    'headers' => [
            //        'Accept' => 'application/json',
            //    ],
            //    'form_params' => [
            //        'api_token' => $token->remember_token,
            //    ],
            //]);
            //$data = json_decode($response->getBody(), true);
            try {
                $response = Http::get('https://zenquotes.io/api/quotes', ['api_token' => $token->remember_token]);
                $data = json_decode($response->getBody(), true);
                return Datatables::of($data)
                    ->escapeColumns([])
                    ->make(true);
            } catch(ConnectionException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e,
                    'draw' => 1,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => []
                ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Token not valid',
                'draw' => 1,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }
    }
}
