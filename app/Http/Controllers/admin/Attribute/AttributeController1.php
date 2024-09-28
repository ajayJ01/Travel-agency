<?php

namespace App\Http\Controllers\Admin\Attribute;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Http\Requests\AttributeStatusRequest;
use App\Http\Requests\AttributeFilterRequest;
use App\Http\Services\AttributeService;
use Attribute;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function __construct(protected AttributeService $AttributeService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|View
     */
    public function index(AttributeFilterRequest $request): JsonResponse|View
    {
        return view('admin.attribute.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeRequest $request
     * @return RedirectResponse
     */
    public function insert(AttributeRequest $request): RedirectResponse
    {
        prd($request->all()); die;
        /* try {
            $this->AttributeService->storeAttribute($request->except('_token'));
            return redirect()->route('admin.attribute.index')->withSuccess('The data inserted successfully!');
        }
        catch(Exception $e)
        {
            return redirect(route('admin.attribute.index'))->withErrors('Something went wrong!');
        } */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $addon = $this->AttributeService->getAttributeById($id);
        return view('admin.atribute.edit', compact('addon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(AttributeRequest $request, int $id): RedirectResponse
    {
        try {
            $this->AttributeService->updateAttribute($request->except('_token', '_method'), $id);
            return redirect()->route('admin.attribute.index')->withSuccess('The data inserted successfully!');
        }
        catch(Exception $e)
        {
            return redirect(route('admin.attribute.index'))->withErrors('Something went wrong!');
        }
    }

    /**
     * Change status with modifier.
     *
     * @param AttributeStatusRequest $request
     * @return bool
     */
    public function changeStatus(AttributeStatusRequest $request): bool
    {
        return $this->AttributeService->changeStatus($request->except('_token'));
    }
}
