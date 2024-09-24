<?php

namespace App\Http\Controllers;

use App\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Notification::where('to_user', Auth::id())->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('message', function ($row) {
                    return '<p>' . $row->message . '</p>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('notification.show', $row->id) . '"><button data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="View" class="btn btn-primary btn-sm"><i class="uil-eye"></i></button></a>';
                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->rawColumns(['action', 'message', 'created_at'])
                ->make(true);
        }

        return view('notification.index');
    }

    public function show($id)
    {
        $notification = Notification::where('id', $id)->where('to_user', Auth::id())->first();
        if ($notification) {
            $notification->update(['is_read' => '1']);
            return view('notification.show', compact('notification'));
        } else {
            return redirect()->route('notification.index')->with('warning', 'Notification not found!');
        }
    }
}
