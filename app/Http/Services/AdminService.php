<?php


namespace App\Http\Services;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
//use File;
use Image;
//use Intervention\Image\Facades\Image;
use Intervention\Image\Facades\File;

class AdminService extends Service
{
    public function __construct(protected Admin $admin)
    {
    }

    /**
     * @array $data
     * @return array
     */
    public function updatePassword(array $data): array
    {
        try {
            $user = Auth::user();
            $user->password = Hash::make($data['new_password']);
            $user->save();
        } catch (\Exception $e) {
            Log::error('Error occurred while update password: ' . $e->getMessage());
            $this->setMessage(__('franchise.error_messages.something_went_wrong'));
        }

        return $this->getResponse();
    }


    /**
     * @array $data
     * @return array
     */
    public function updateProfile(array $data): array
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
