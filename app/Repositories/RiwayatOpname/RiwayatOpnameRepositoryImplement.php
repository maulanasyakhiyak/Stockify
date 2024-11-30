<?php

namespace App\Repositories\RiwayatOpname;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\RiwayatOpname;
use LaravelEasyRepository\Implementations\Eloquent;

class RiwayatOpnameRepositoryImplement extends Eloquent implements RiwayatOpnameRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(RiwayatOpname $model)
    {
        $this->model = $model;
    }

    public function createRiwayat($keterangan)
    {
        $today = Carbon::now()->format('Y-m-d');

        $existingRecords = $this->model->where('user_id', auth()->id())
                                   ->where('tanggal_opname', $today)
                                   ->count();
        if ($existingRecords >= 3) {
            throw new \Exception("Anda sudah melakukan opname 3 kali pada hari ini.");
        }

        $riwayatOpname = $this->model->create([
            'id' => (string) Str::uuid(),  // Menambahkan UUID secara otomatis
            'token' => Str::random(10),
            'tanggal_opname' => $today,
            'user_id' => auth()->id(),
            'notes' => $keterangan
        ]);

        return $riwayatOpname;
    }

    /**
     * Mendapatkan riwayat opname berdasarkan id
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Mendapatkan semua riwayat opname
     */
    public function RiwayatAll()
    {
        return $this->model->with('user')->get();
    }

    /**
     * Menyimpan perubahan riwayat opname
     */
    public function update($id,$data)
    {
        $riwayatOpname = $this->findById($id);  // Mendapatkan data riwayat opname
        $riwayatOpname->update($data);  // Update data
        return $riwayatOpname;
    }

    /**
     * Menghapus riwayat opname
     */
    public function delete($id)
    {
        $riwayatOpname = $this->findById($id);  // Mendapatkan data riwayat opname
        return $riwayatOpname->delete();  // Hapus riwayat opname
    }
}
