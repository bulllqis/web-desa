<?php

namespace App\Http\Controllers;

use App\Potensi;
use Illuminate\Http\Request;
use File;
use Session;
 
use DataTables;
class PotensiController extends Controller
{
   
    public function index(Request $request)
    {
            
            $dat = Potensi::orderBy('id','DESC')->get();
    
          

            return view('admin/potensi/index',compact('dat'));

    }


          public function store(Request $request)
            {   
                
                if($request->hasFile('foto')){
                    $foto = $request->file('foto');
                    $nama  = time()."_".$foto->getClientOriginalName();
                    $lokasi = public_path('/foto');
                    $foto->move($lokasi,$nama);
	
                    Potensi::updateOrCreate(

                        ['id' => $request->data_id],
                        [
                            
                        'nama_potensi' => $request->nama,
                        'alamat' => $request->alamat,
                        'keterangan' => $request->keterangan,
                        'foto' => $nama
                        ]);        

                }else{
                    Potensi::updateOrCreate(

                        ['id' => $request->data_id],
                        [
                            
                        'nama_potensi' => $request->nama,
                        'alamat' => $request->alamat,
                        'keterangan' => $request->keterangan,
                        
                        ]);        

                }

                Session::flash('sukses','Data Berhasi Di Tambahkan');
                $dat = Potensi::orderBy('id','DESC')->get();
          
  
              return view('admin/potensi/index',compact('dat'));
  
        

                // Session::flash('sukses','Data Berhasi Di Tambahkan');
                // return redirect('/potensi')->with('status','data berhasil di simpan');
           
            }

        // edit

        public function edit($id)
        {
            $user = Potensi::find($id);

            return response()->json($user);
        }


        // delete

        public function destroy($id)
        {
        // hapus file
		$gambar = Potensi::where('id',$id)->first();
		File::delete('foto/'.$gambar->foto);
 

        Potensi::find($id)->delete();

        return response()->json([
            'status' => 'sukses',
            'pesan'=>'Data berhasil di Hapus'
        ]);
    }

       public function detail($id){

              $potensi = Potensi::find($id);

            return view('ui/potensi/detail',compact('potensi'));


        }

}
