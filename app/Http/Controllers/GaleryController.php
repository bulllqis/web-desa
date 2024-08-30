<?php

namespace App\Http\Controllers;

use App\Galery;
use Illuminate\Http\Request;
use File;
use Session;
 
use DataTables;
class GaleryController extends Controller
{
        public function index(Request $request)

        {

    
             $dat = Galery::orderBy('id','DESC')->get();
        

            return view('admin/galery/index',compact('dat'));

        }

        public function store(Request $request)
            {
             
                if($request->hasFile('foto')){
                    $foto = $request->file('foto');
                    $nama  = time()."_".$foto->getClientOriginalName();
                    $lokasi = public_path('/foto');
                    $foto->move($lokasi,$nama);
                    Galery::updateOrCreate(

                        ['id' => $request->data_id],
                        [
                            
                        'judul' => $request->judul,
                        'keterangan' => $request->keterangan,
                        'foto' => $nama
                        ]);        
                
                }else{
                    Galery::updateOrCreate(

                        ['id' => $request->data_id],
                        [
                        'keterangan' => $request->keterangan,
                        'judul' => $request->judul
                        ]);        
                }

                

        

                Session::flash('sukses','Data Berhasi Di Tambahkan');
              $dat = Galery::orderBy('id','DESC')->get();
        

            return view('admin/galery/index',compact('dat'));


           
            }

        // edit

        public function edit($id)
        {
            $user = Galery::find($id);

            return response()->json($user);
        }


        // delete

        public function destroy($id)
        {
        // hapus file
		$gambar = Galery::where('id',$id)->first();
		File::delete('foto/'.$gambar->foto);
 

        Galery::find($id)->delete();

        return response()->json([
                'status' => 'sukses',
                'pesan'=>'Data berhasil di Hapus'
            ]);
        }

        public function detail($id){

            $budaya = Galery::find($id);

          return view('ui/galery/detail',compact('budaya'));


      }

}
