<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    public function getUsersData(Request $request)
    {
        if ($request->ajax()) {
            $data = User::withCount('blogs');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a onclick="getUser(' . $row->id . ')" class="edit btn btn-primary btn-sm mr-2">Edit</a>';
                    $btn .= '<a onclick="deleteConfirm(' . $row->id . ')" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user.list');
    }
}
