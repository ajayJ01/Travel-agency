<?php


namespace App\Http\Services;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Intervention\Image\Facades\File;

class GeneralSettingService extends Service
{
    public function __construct(protected Admin $admin)
    {
    }

    /**
     * @array $data
     * @return array
     */
    public function updateSetting(array $data): array
    {
        try {
            $user                       = Auth::user();
            $update['name']             = $data['name'];
            $update['phone']            = $data['phone'];
            Admin::where('id', $user->id)->update($update);
        } catch (\Exception $e) {
            Log::error('Error occurred while update password: ' . $e->getMessage());
            $this->setMessage(__('franchise.error_messages.something_went_wrong'));
        }
        return $this->getResponse();
    }
}
