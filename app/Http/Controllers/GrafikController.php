<?php

namespace App\Http\Controllers;


use App\Grafik;

use Illuminate\Http\Request;

use DataTables;
use Session;

        
class GrafikController extends Controller
{
    
     public function index(Request $request)

        {

    
            if ($request->ajax()) {
                $data = Grafik::latest()->get();
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
        

            return view('admin/grafik/index');

        }


    // sotre
    
    public function store(Request $request)
    {
      
  
        Grafik::updateOrCreate(

                ['id' => $request->datum_id],
                [
                    
                 'opsi' => $request->opsi,
                 'lebel' => $request->label,
                 'nomor' => $request->nomor
                 ]);        

   

        return response()->json([
            'status' => 'sukses',
             'pesan'=>'Data berhasil disimpan'
        ]);
    }

    // edit

    public function edit($id)
    {
        $grafik = Grafik::find($id);

        return response()->json($grafik);
    }


    // delete

    public function destroy($id)
    {
        Grafik::find($id)->delete();

       return response()->json([
            'status' => 'sukses',
             'pesan'=>'Data berhasil di Hapus'
        ]);
    }

  
}
