<?php

namespace App\Http\Controllers;


use App\User;
use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DataTables;

        
class UserController extends Controller
{
    
     public function index(Request $request)

        {

    
            if ($request->ajax()) {
                $data = User::latest()->get();
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
    
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn edit  editData"><i class="icon-pencil"></i></a>';
    
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn deleteData"><i class="icon-trash"></i></a>';
        
                                return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
        

            return view('admin/user/index');

        }


    // sotre
    
    // public function store(Request $request)
    // {
    //     $validasi = $this->validate($request,[
    //         'name' => 'required'
    //     ]);
    //     $username = User::getId();
    //     foreach ($username as $value);
    //     $ul = $value->id + 1;
    //     $ub = 'U'.$ul.'00';

    //     User::updateOrCreate(

    //             ['id' => $request->data_id],
    //             [
                    
    //              'name' => $request->name,
    //              'password' => bcrypt('PW'.$ub),
    //              'role' => $request->role,
    //              'username' => $ub
    //              ]);        

   

    //     return response()->json([
    //         'status' => 'sukses',
    //          'pesan'=>'Data berhasil disimpan'
    //     ]);
    // }

    public function store(Request $request)
{
    $validasi = $this->validate($request,[
        'name' => 'required',
        'role' => 'required'
    ]);

    $lastUser = User::latest('id')->first();
    $ul = $lastUser ? $lastUser->id + 1 : 1;
    $ub = 'U'.$ul.'00';

    User::updateOrCreate(
        ['id' => $request->data_id], // pastikan nama input sesuai
        [
            'name' => $request->name,
            'password' => bcrypt('PW'.$ub),
            'role' => $request->role,
            'username' => $ub
        ]
    );        

    Session::flash('sukses','Data Berhasi Di Tambahkan');
                $dat = User::orderBy('id','DESC')->get();
          
  
              return view('admin/user/index',compact('dat'));
  
}

    // edit

    public function edit($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }


    // delete

    public function destroy($id)
    {
        User::find($id)->delete();

       return response()->json([
            'status' => 'sukses',
             'pesan'=>'Data berhasil di Hapus'
        ]);
    }

    // prosses login
   public function postlogin(Request $request)
    {

       if(Auth::attempt($request->only('username','password'))){
          return redirect('/dashboard');
       } 
       Session::flash('peringatan','Password atau sandi anda salah');
       return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
       return redirect('/');
    }

    public function setings(Request $request)
    {
       
        if($request->password){

            User::where('id',$request->id)->update([
                'name' => $request->nama,
                'username' => $request->username,
                'password' => bcrypt($request->password)
            ]);

        }else{
            User::where('id',$request->id)->update([
                'name' => $request->nama,
                'username' => $request->username
            ]);
        }
        
       return response()->json([
        'status' => 'sukses',
         'pesan'=>'Akun berhasil di Perbarui'
    ]);
    }


}
