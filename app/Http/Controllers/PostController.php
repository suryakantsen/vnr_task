<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB, Auth;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $data['posts'] = DB::table('posts')->where('user_id', Auth::user()->id)->where('status', 'Y')->get();
        return view('home')->with($data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'body' => 'required|min:10',
        ]);
        if ($validator->fails())
        {
            return response()->json([ 'status' => false, 'message' => $validator->errors()->first() ]);
        }

        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::user()->id,
                ];

        if(isset($request->id))
        {
            $save = DB::table('posts')->where('id', $request->id)->update($data);
            return response()->json([ 'status' => true, 'message' => 'Post updated successfully']);
        }
        else
        {
            $save = DB::table('posts')->insertGetId($data);
        }
        if($save)
        {
            return response()->json([ 'status' => true, 'message' => 'Post added successfully']);
        }
        return response()->json([ 'status' => false, 'message' => 'Something went wrong, try again later' ]);
    }

    public function get_data(Request $request)
    {
        $data = DB::table('posts')->where('id', $request->id)->select('body', 'title')->first();
        return response()->json([ 'status' => true, 'message' => 'Post added successfully', 'data'=>$data]);
    }

    public function delete(Request $request)
    {
        $delete = DB::table('posts')->where('id', $request->id)->update(['status'=> 'N']);
        if($delete)
        {
            return response()->json([ 'status' => true, 'message' => 'Post deleted successfully']);
        }
        return response()->json([ 'status' => false, 'message' => 'Something went wrong, try again later' ]);
    }

    public function delete_account(Request $request)
    {
        $delete = DB::table('users')->where('id', Auth::user()->id)->delete();
        if($delete)
        {
            return response()->json([ 'status' => true, 'message' => 'Account deleted' ]);
        }
        return response()->json([ 'status' => false, 'message' => 'Something went wrong, try again later' ]);
    }
}
