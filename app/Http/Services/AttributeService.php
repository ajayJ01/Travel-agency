<?php


namespace App\Http\Services;

use App\Models\Attribute\Attribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class AttributeService extends Service
{
    public function __construct(protected Attribute $attribute)
    {
    }

    /**
     * @array $data
     * @return array
     */
    public function storeAttribute(array $data): array
    {
        try {
            $attribute                  = new Attribute;
            $attribute->name            = $data['name'];
            $attribute->max_selection   = $data['max_selection'];
            $attribute->created_by      = auth()->user()->id;
            $attribute->status          = 1;
            $attribute->save();
        } catch (\Exception $e) {
            Log::error('Error occurred while creating Attribute: ' . $e->getMessage());
            $this->setMessage(__('franchise.error_messages.something_went_wrong'));
        }

        return $this->getResponse();
    }

    /**
     * Get modifier list.
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAttributeList(array $data): JsonResponse
    {
        $queryArray = array();

        if (isset($data['status'])) {
            $queryArray['status'] = $data['status'];
        }

        $modifiers = $this->attribute::where($queryArray)->orderBy('id', 'desc')->get();
        return DataTables::of($modifiers)
            ->addColumn('action', function ($modifiers) {
                $retAction = '<div class="action-buttons">';

                if (auth()->user()->can('modifiers_edit')) {
                    $retAction .= '<a href="' . route('admin.addons.edit', $modifiers) . '" class="btn btn-sm btn-icon btn-primary"
                        title="Edit" ><i class="far fa-edit"></i></a>';
                }
                return $retAction . '</div>';
            })
            ->editColumn('id', function ($modifiers) use (&$i) {
                return ++$i;
            })
            ->editColumn('status', function ($modifiers) {
                if (auth()->user()->can('modifier_status_change')) {
                    $checked = $modifiers->status == Constants::STATUS_ONE ? 'checked' : '';
                    return '<div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input toggle-status status_checked parent-id'.$modifiers->parent_id.'" id="customSwitch'.$modifiers->id.'" '.$checked.'
                            data-id="'.$modifiers->id.'" data-url="'.route('admin.addons.change-status').'">
                        <label class="custom-control-label" for="customSwitch'.$modifiers->id.'"></label>
                    </div>';
                }

                return trans('statuses.' . $modifiers->status) ?? trans('statuses.0');
            })
            ->rawColumns(['status', 'action'])

            ->escapeColumns([])
            ->make(true);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function changeStatus(array $data): bool
    {
        try {
            DB::beginTransaction();
            $this->attribute::where('id', $data['id'])->update(['status' => $data['status']]);
            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
        }

        return false;
    }

    /**
     * @param int $id
     * @return Attribute
     */
    public function getAttributeById(int $id): Attribute
    {
        $modifier = $this->attribute::with('option')->findorfail($id);
        if ($modifier->mlu) {
            $modifier->mlu_verified = 1;
        }
        return $modifier;
    }

    /**
     * @param array $data
     * @param int $id
     * @return array
     */
    public function updateAttribute(array $data, int $id): array
    {
        try {
            $addons                         =   Attribute::findOrFail($id);
            $addonArr['name']               =   $data['name'];
            $addonArr['max_selection']      =   $data['max_selection'];
            $addonArr['edited_by']          =   auth()->user()->id;
            Attribute::where('id',$id)->update($addonArr);
        } catch (\Exception $e) {
            Log::error('Error occurred while update Attribute: ' . $e->getMessage());
            $this->setMessage(__('franchise.error_messages.something_went_wrong'));
        }
        return $this->getResponse();
    }
}
