<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\UserActivityLog;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserActivity implements FromCollection, WithHeadings
{
    protected $time_range;

    public function __construct($time_range)
    {
        $this->time_range = $time_range;
    }

    public function collection()
    {
        $query = UserActivityLog::with('user');
        
        switch ($this->time_range) {
            case '1 day':
                $date = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
                break;
            case '7 days':
                $date = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
                break;
            case '1 month':
                $date = Carbon::now()->subMonth()->format('Y-m-d H:i:s');
                break;
            default:
                $date = Carbon::now()->subMonth()->format('Y-m-d H:i:s');
                break;
        }

        return $query->where('created', '>=', $date)->get()->map(function($item){
            return [
                'User'      =>  $item->user->first_name . $item->user->last_name,
                'Role'      =>  $item->user->role,
                'Tindakan'  =>  $item->activity,
                'Deskripsi' =>  $item->description,
                'Waktu'     =>  Carbon::parse($item->created)->format('d M Y h:i A')
            ];
        });
    }

    public function headings(): array
    {
        return ['User', 'Role', 'Tindakan', 'Deskripsi', 'Waktu'];
    }

}
