<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search_nama;

        $limit = $request->limit;

        $hospitals = Hospital::where('nama_pasien', 'LIKE','%'.$search.'%')->limit($limit)->get();
        if ($hospitals) {
            return ApiFormatter::createAPI(200,'success',$hospitals);
        }else {
            return ApiFormatter::createAPI(400,'failed');
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_pasien' => 'required|min:8',
                'alamat'=> 'required',
                'umur'=> 'required',
                'no_telp'=> 'required',
                'tanggal_pendaftaran'=> 'required',
                'dokter'=> 'required',
            ]);
            $hospitals = Hospital::create([
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat,
                'umur' => $request->umur,
                'no_telp' => $request->no_telp,
                'tanggal_pendaftaran'=> \Carbon\Carbon::parse($request->tanggal_pendaftaran)->format('Y-m-d'),
                'dokter' => $request->dokter,
            ]);
            $TambahData = Hospital::where('id', $hospitals->id)->first();
            if ($TambahData) {
                return ApiFormatter::createAPI(200,'success',$hospitals);
            }else{
                return ApiFormatter::createAPI(400,'failed');
            } 
        }catch(Exception $error) {
            return ApiFormatter::createAPI(400,'failed',$error->getMessage());
        }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $hospitals = Hospital::find($id);
            if ($hospitals) {
                return ApiFormatter::createAPI(200,'success',$hospitals);
            }else{
                return ApiFormatter::createAPI(400,'failed');
        }
        } catch(Exception $error) {
            return ApiFormatter::createAPI(400,'failed',$error->getMessage());
       
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hospital $hospital)
    {
        //
    }
    
    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        try{
            $request->validate([
                'nama_pasien' => 'required|min:8',
                'alamat'=> 'required',
                'umur'=> 'required',
                'no_telp'=> 'required',
                'dokter'=> 'required',
            ]);
            
            $hospitals = Hospital::findOrFail($id);

            $hospitals->update([
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat,
                'umur' => $request->umur,
                'no_telp' => $request->no_telp,
                'dokter' => $request->dokter,
            ]);
            $updatePasien =  Hospital::where('id',$hospitals->id)->first();
            if($updatePasien){
                return ApiFormatter::createAPI(200,'success',$updatePasien);
            }else{
                return ApiFormatter::createAPI(400,'failed');
            }
        }catch(Exception $error){
            return ApiFormatter::createAPI(400,'failed',$error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $hospitals = Hospital::onlyTrashed()->where('id',$id);
            $hospitals->restore();
            $dataKembali = Hospital::where('id',$id)->first(); 
            if($dataKembali) {
                return ApiFormatter::createAPI(200,'success', $dataKembali);
            } else {
                return ApiFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'Failed',$error->getMessage());
        }
    }

    public function onlyTrash()
    {
        try{
            $hospitals = Hospital::onlyTrashed()->get();
            if ($hospitals) {
                return ApiFormatter::createAPI(200,'success',$hospitals);
            }else{
                return ApiFormatter::createAPI(400,'failed');
        }
        } catch(Exception $error) {
            return ApiFormatter::createAPI(400,'failed',$error->getMessage());
       
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    

     public function deletePermanent($id)
     {
        try {
            $hospitals = Hospital::findOrFail($id);
            $proses = $hospitals->forceDelete();

            if($proses) {
                return ApiFormatter::createAPI(200, 'success delete data!');
            } else {
                return ApiFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'Failed',$error->getMessage());
        }
     }

    public function destroy($id)
    {
        try {
            $hospitals = Hospital::findOrFail($id);
            $proses = $hospitals->delete();

            if($proses) {
                return ApiFormatter::createAPI(200, 'success delete data!');
            } else {
                return ApiFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'Failed',$error->getMessage());
        }
    }
    }



