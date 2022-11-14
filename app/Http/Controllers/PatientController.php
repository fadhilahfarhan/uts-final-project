<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    // Mendapatkan semua resource
    public function index()
    {
        //menggunakan all() untuk mengambil semua resource
        $patients = Patient::all();
        //isEmty() digunakan jika resource kosong atau tidak ada resourcenya
        if ($patients->isEmpty()) {
            return $this->response(200, 'Data is Empty');
        } else {
            return $this->response(200, 'Get All Resource', $patients);
        }
    }

    // Menambahkan Resource
    public function store(Request $request)
    {
        //menggunakan Validator untuk memvalidasi data yang dimasukan benar atau salah
        $validated = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'phone' => 'required|string|min:11|max:15',
            'address' => 'required|string',
            'status' => 'required',
            'in_date_at' => 'required|date',
            'out_date_at' => 'required|date|after_or_equal:in_date_at'
        ]);

        //fails()digunakan jika validasi ada kesalahan
        if ($validated->fails()) {
            //getMessageBag() digunakan untuk memberitahu dimana yang terjadi kesalahan
            return $this->response(400, $validated->getMessageBag()->first());
        }
        //jika validasi berhasil ini akan dijalankan
        else {
            //create digunakan untuk menambahkan data resource ke database
            $create = Patient::create($request->all());
            return $this->response(201, 'Resource is added successfully', $create);
        }
    }
    
    //Mendapatkan single resource
    public function show($id)
    {
        //find() digunakan untuk mencari data yang spesifik
        $patient = Patient::find($id);
        // jika resource ditemukan
        if ($patient) {
            return $this->response(200, 'Get Detail Resource', $patient);
        }
        //jika resource tidak ditemukan
        else {
            return $this->response(404, 'Resource Not Found');
        }
    }

    //Memperbarui single resource
    public function update(Request $request, $id)
    {
        //menemukan resource menggunakan find()
        $patient = Patient::find($id);
        //memvalidasi input resource yang masuk
        $validated = Validator::make($request->all(), [
            'nama' => 'nullable|string|max:50',
            'phone' => 'nullable|string|min:11|max:15',
            'address' => 'nullable|string',
            'status' => 'nullable',
            'in_date_at' => 'nullable|date',
            'out_date_at' => 'nullable|date|after_or_equal:in_date_at'
        ]);

        // jika resource tidak ditemukan
        if (!$patient) {
            return $this->response(404, 'Resource not found');
        }
        // jika validasi ada kesalahan
        elseif ($validated->fails()) {
            return $this->response(400, $validated->getMessageBag()->first());
        }
        //jika semua nyarat dipenuhi akan diupdate
        else {
            //menggunakan update untuk mengedit resource
            $patient->update($request->all());
            return $this->response(200, 'Resource is update successfully', $patient);
        }
    }

    //Menghapus single resource
    public function destroy($id)
    {
        //mencari resource menggunakan find()
        $patient = Patient::find($id);
        //jika resource ditemukan
        if ($patient) {
            //delete untuk menghapus resource
            $patient->delete();
            return $this->response(200, 'Resource is delete successfully');
        }
        //jika resource tidak ditemukan
        else {
            return $this->response(404, 'Resource not found');
        }
    }

    public function search($nama)
    {
        $patient = Patient::where('name', 'like', '%' . $nama . '%')->get();
    }
}
