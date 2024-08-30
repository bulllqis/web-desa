<?php

namespace App\Http\Controllers;

use App\Pemasukan;
use Illuminate\Http\Request;
use App\Imports\Pengeluaran;
use Maatwebsite\Excel\Facades\Excel;
use Session; 
use DataTables;
 
use Carbon\Carbon;
use PDF;
class PengluaranController extends Controller
{
    
     public function index(Request $request)

        {

            if ($request->ajax()) {
                $data = Pemasukan::select()->where('kondisi','keluar')->latest()->get();
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
    
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn edit  editData"><i class="icon-pencil"></i></a>';
    
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn deleteData"><i class="icon-trash"></i></a>';
        
                                return $btn;
                        })
                        ->addColumn('many', function($row){
                            $hasil_rupiah = "Rp-" . number_format($row->jumlah,0, ".", ".");
                            $btn = '<td>'.$hasil_rupiah.'</td>';
                                return $btn;
                        })
                        ->rawColumns(['action','many'])
                        ->make(true);
            }
        

            return view('admin/pengeluaran/index');

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
            Excel::import(new Pengeluaran, public_path('/files/'.$nama_file));
            Session::flash('sukses','Data Berhasil Diimport!');
            return redirect('/pengeluaran');
        }

    // sotre
    
    public function store(Request $request)
    {


        Pemasukan::updateOrCreate(

                ['id' => $request->data_id],
                [
                    
                 'jumlah' => $request->jumlah,
                 'keterangan' => $request->keterangan,
                 'sumber' =>  $request->pk,
                 'user_id' => $request->user,
                 'tanggal' => $request->tanggal,
                 'kondisi' => 'keluar'

                 ]);        

   

        return response()->json([
            'status' => 'sukses',
             'pesan'=>'Data berhasil disimpan'
        ]);
    }

    // edit

    public function edit($id)
    {
        $Pengluaran = Pemasukan::find($id);

        return response()->json($Pengluaran);
    }


    // delete

    public function destroy($id)
    {
        Pemasukan::find($id)->delete();

       return response()->json([
            'status' => 'sukses',
             'pesan'=>'Data berhasil di Hapus'
        ]);
    }

 
    public function cetak_pdf(Request $request)
    {   


        $start = $request->start;
        $end = $request->end;      
       
        $dana = Pemasukan::all()->whereBetween('tanggal', [$start, $end])->where('kondisi','keluar');

    	$pdf = PDF::loadview('admin.pengeluaran.pengeluaran_pdf',compact('dana','end','start'));
    	return $pdf->stream();
    }
}
