<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserdataController extends Controller
{
    public function index_data()
    {
        $users = User::all();

        return datatables()->of($users)
            ->editColumn('created_at', function ($users) {
                return date('d-m-Y H:i:s', strtotime('+8 hour', strtotime($users->created_at)));
            })
            ->addColumn('project', function ($users) {
                return $users->project->project_code;
            })
            ->addIndexColumn()
            ->addColumn('action', 'admin.users.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function user_activate()
    {
        $users = User::where('active', 0)->get();

        return datatables()->of($users)
            ->editColumn('created_at', function ($users) {
                return date('d-m-Y H:i:s', strtotime('+8 hour', strtotime($users->created_at)));
            })
            ->addColumn('project', function ($users) {
                return $users->project->project_code;
            })
            ->addIndexColumn()
            ->addColumn('action', 'admin.users.activate.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function user_deactivate()
    {
        $users = User::where('active', 1)->get();

        return datatables()->of($users)
            ->editColumn('created_at', function ($users) {
                return date('d-m-Y H:i:s', strtotime('+8 hour', strtotime($users->created_at)));
            })
            ->addColumn('project', function ($users) {
                return $users->project->project_code;
            })
            ->addIndexColumn()
            ->addColumn('action', 'admin.users.activate.deactivate_action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
