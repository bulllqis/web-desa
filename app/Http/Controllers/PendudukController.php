<?php

namespace App\Http\Controllers;

use App\Penduduk;
use Illuminate\Http\Request;
use Session;
 
use DataTables;

use App\Imports\Ipenduduk;
use Maatwebsite\Excel\Facades\Excel;

class PendudukController extends Controller
{
    
     public function index(Request $request)

        {

    
            if ($request->ajax()) {
                $data = Penduduk::latest()->get();
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
        

            return view('admin/penduduk/index');

        }


    // sotre
    
    public function store(Request $request)
    {

        Penduduk::updateOrCreate(

                ['id' => $request->data_id],
                [
                    
                 'nama_lengkap' => $request->name,
                 'nik' => $request->nik,
                 'jenis_klamin' => $request->jk,
                 'tampat_lahir' => $request->tempat_lahir,
                 'tanggal_lahir' => $request->tanggal_lahir,
                 'agama' => $request->agama,
                 'pendidikan' => $request->pendidikan,
                 'pekerjaan' => $request->pekerjaan,
                 'no_kk' => $request->no_kk
                 ]);        

   

        return response()->json([
            'status' => 'sukses',
             'pesan'=>'Data berhasil disimpan'
        ]);
    }

    // edit

    public function edit($id)
    {
        $penduduk = Penduduk::find($id);

        return response()->json($penduduk);
    }


    // delete

    public function destroy($id)
    {
        Penduduk::find($id)->delete();

       return response()->json([
            'status' => 'sukses',
             'pesan'=>'Data berhasil di Hapus'
        ]);
    }

    public function import_excel(Request $request) 
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

       
        $file = $request->file('file');
        $nama_file = rand().$file->getClientOriginalName();
        $file->move('files',$nama_file);
        Excel::import(new Ipenduduk, public_path('/files/'.$nama_file));
        Session::flash('sukses','Data  Berhasil Diimport!');
        return redirect('admin/penduduk/index');
    }


}
