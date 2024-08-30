<?php

namespace App\Http\Controllers;
use App\Webs;
use Session;
use File;
use Illuminate\Http\Request;

class SejarahController extends Controller
{
        public function index(Request $request)

        {

            $dat = Webs::orderBy('id','DESC')->get();
        

            return view('admin/web/sejarah',compact('dat'));

        }

        public function store(Request $request)
            {
             
               

                Webs::updateOrCreate(

                        ['id' => $request->data_id],
                        [
                        
                        'sejarah' => $request->sejarah
                        ]);        

        

                Session::flash('sukses','Data Berhasi Di Tambahkan');
                return redirect('/sejarahs')->with('status','data berhasil di Simpan');

           
            }

        // edit

        public function edit($id)
        {
            $user = Webs::find($id);

            return response()->json($user);
        }


 

}
