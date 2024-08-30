<?php

namespace App\Http\Controllers;
use DataTables;

use App\Pemasukan;
use App\Dandes;

use App\Imports\Pemasukann;
use Maatwebsite\Excel\Facades\Excel;
use Session; 

use Illuminate\Http\Request;
use PDF;

class PemasukanController extends Controller
{
    
     public function index(Request $request)

        {

    
            if ($request->ajax()) {
                $data = Pemasukan::select()->where('kondisi','pemasukan')->latest()->get();

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
        

            return view('admin/pemasukan/index');

        }


    // sotre
    
    public function store(Request $request)
    {

        $da = Dandes::select('jumlah')->first();
        $dana = $da->jumlah + $request->jumlah;
        
        
        Pemasukan::updateOrCreate(

                ['id' => $request->data_id],
                [
                    
                 'jumlah' => $request->jumlah,
                 'keterangan' => $request->keterangan,
                 'sumber' =>  $request->pk,
                 'user_id' => $request->user,
                 'tanggal' => $request->tanggal,
                 'kondisi' => 'pemasukan'

                 ]);        

   

        return response()->json([
            'status' => 'sukses',
             'pesan'=>'Data berhasil disimpan'
        ]);
    }

    // edit

    public function edit($id)
    {
        $Pemasukan = Pemasukan::find($id);

        return response()->json($Pemasukan);
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

    public function import_excel(Request $request) 
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

       
        $file = $request->file('file');
        $nama_file = rand().$file->getClientOriginalName();
        $file->move('files',$nama_file);
        Excel::import(new Pemasukann, public_path('/files/'.$nama_file));
        Session::flash('sukses','Data  Berhasil Diimport!');
        return redirect('/pemasukan');
    }

    
    public function cetak_pdf(Request $request)
    {   


        $start = $request->start;
        $end = $request->end;      
       
        $dana = Pemasukan::all()->whereBetween('tanggal', [$start, $end])->where('kondisi','pemasukan');

    	$pdf = PDF::loadview('admin.pemasukan.pemasukan_pdf',compact('dana','end','start'));
    	return $pdf->stream();
    }
}
