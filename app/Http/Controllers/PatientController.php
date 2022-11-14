<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    # Mendapatkan semua resource
    # isEmpty() adalah jika resource kosong
    public function index()
    {
        $patients = Patient::all();

        if ($patients->isEmpty()) {
            return $this->response(200, 'Data is Empty');
        }

        return $this->response(200, 'Get All Resource', $patients);
    }

    # Menambahkan Resource
    # Validator untuk memvalidasi
    # menggunakan fails() untuk validasi yang gagal
    # create() digunakan untuk menambah data ke database
    # This->response() untuk response ini ada di controller.php
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'phone' => 'required|string|min:11|max:15',
            'address' => 'required|string',
            'status' => 'required',
            'in_date_at' => 'required|date',
            'out_date_at' => 'required|date|after_or_equal:in_date_at'
        ]);

        if ($validated->fails()) {
            return $this->response(400, $validated->getMessageBag()->first());
        }

        $create = Patient::create($request->all());

        return $this->response(201, 'Resource is added successfully', $create);
    }

    # Mendapatkan single resource
    # find untuk mencari data yang specific menggunakan id
    public function show($id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            return $this->response(200, 'Get Detail Resource', $patient);
        }

        return $this->response(404, 'Resource Not Found');
    }

    //Memperbarui single resource
    # update() digunakan untuk mengupdate database
    # nullable digunakan agar data yang diupdate tidak perlu lengkap
    # after_or_equal digunakan untuk menetapkan tanggal setelah tanggal sebelumnya
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        $validated = Validator::make($request->all(), [
            'name' => 'nullable|string|max:50',
            'phone' => 'nullable|string|min:11|max:15',
            'address' => 'nullable|string',
            'status' => 'nullable',
            'in_date_at' => 'nullable|date',
            'out_date_at' => 'nullable|date|after_or_equal:in_date_at'
        ]);

        if (!$patient) {
            return $this->response(404, 'Resource not found');
        } elseif ($validated->fails()) {
            return $this->response(400, $validated->getMessageBag()->first());
        }

        $patient->update($request->all());
        return $this->response(200, 'Resource is update successfully', $patient);
    }

    # Menghapus single resource
    # delete() untuk menghapus data di database
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            $patient->delete();
            return $this->response(200, 'Resource is delete successfully');
        }

        return $this->response(404, 'Resource not found');
    }

    # Mencari resource by name
    # where() untuk mecari resource dengan lebih spesifik
    # '%'.$name.'%' digunakan untuk mecari data lebih fle
    public function search($name)
    {
        $patient = Patient::where('name', 'like', '%' . $name . '%')->get();

        if ($patient->isEmpty()) {
            return $this->response(404, 'Resource not found');
        }

        return $this->response(200, 'Get searched resource', $patient);
    }

    # Mendapatkan resource yang positif
    public function positive()
    {
        $patient = Patient::where('status', 'positive')->get();

        if ($patient->isEmpty()) {
            return $this->response(404, 'Resource not found ');
        }

        return $this->response(200, 'Get searched resource', $patient, true);
    }

    # Mendapatkan resource yang recovered
    public function recovered()
    {
        $patient = Patient::where('status', 'recovered')->get();

        if ($patient->isEmpty()) {
            return $this->response(404, 'Resource not found ');
        }

        return $this->response(200, 'Get searched resource', $patient, true);
    }

    ## Mendapatkan resource yang dead
    public function dead()
    {
        $patient = Patient::where('status', 'dead')->get();

        if ($patient->isEmpty()) {
            return $this->response(404, 'Resource not found ');
        }

        return $this->response(200, 'Get searched resource', $patient, true);
    }
}
