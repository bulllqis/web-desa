<?php

namespace App\Http\Controllers;

use App\Quetes;
use Illuminate\Http\Request;
use File;
use Session;
class QuetesController extends Controller
{
        public function index(Request $request)

        {

            $dat = Quetes::orderBy('id','DESC')->get();
    
          

            return view('admin/quetes/index',compact('dat'));

        }

        public function store(Request $request)
            {
             
                if($request->hasFile('foto')){
                    $foto = $request->file('foto');
                    $nama  = time()."_".$foto->getClientOriginalName();
                    $lokasi = public_path('/foto');
                    $foto->move($lokasi,$nama);
    
                }else{
                    $nama = 'nomedia.png';
                }
                if($request->data_id === null){

                }else{
                    $poto = Quetes::where('id',$request->data_id)->first();
                    File::delete('foto/'.$poto['foto']);
                }

                Quetes::updateOrCreate(

                        ['id' => $request->data_id],
                        [
                        'keterangan' => $request->keterangan,
                        'penulis' => $request->penulis,
                        'foto' => $nama
                        ]);        

        

                        Session::flash('sukses','Data Berhasi Di Tambahkan');
                        $dat = Quetes::orderBy('id','DESC')->get();
                  
          
                      return view('admin/quetes/index',compact('dat'));
          
                // Session::flash('sukses','Data Berhasi Di Tambahkan');
                // return redirect('/quetes')->with('status','data berhasil di Simpan');

           
            }

        // edit

        public function edit($id)
        {
            $user = Quetes::find($id);

            return response()->json($user);
        }


        // delete

        public function destroy($id)
        {
        // hapus file
		$gambar = Quetes::where('id',$id)->first();
		File::delete('foto/'.$gambar->foto);
 

        Quetes::find($id)->delete();

        return response()->json([
            'status' => 'sukses',
            'pesan'=>'Data berhasil di Hapus'
        ]);
        }

}
