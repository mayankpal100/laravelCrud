<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        return Property::query()->limit(10)->get();
    }

    public function propTypeList()
    {
        return PropertyType::query()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Builder|Model
     */
    public function create(Request $request): Builder|Model
    {
        $this->validate($request, [
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        return Property::query()->create(array_merge(json_decode($request->data, true), ['uuid' => (string)Str::uuid()], $this->fileMove($request)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function search(Request $request, $search)
    {
        return Property::query()->orwhere('description', "like", "%$search%")->orwhere('uuid', "=", $search)->limit(50)->get()->toJson();

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Property $property
     * @return Property
     */
    public function show(Property $uuid)
    {
        return $uuid;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return bool
     */
    public function update(Request $request, Property $uuid)
    {
        $this->validate($request, [
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        return $uuid->update(array_merge(json_decode($request->data, true), $this->fileMove($request)));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Property $property
     * @return bool
     */
    public function destroy(Property $uuid)
    {
        return $uuid->delete();
    }

    public function fileMove($request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');

            $input['file'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads');
            File::makeDirectory($destinationPath, $mode = 0777, true, true);
            $imgFile = Image::make($image->getRealPath());
            $imgFile->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['file']);
            $image->move($destinationPath, $input['file']);
            $destinationPath = storage_path('/uploads/') . $input['file'];
        }
        if (isset($destinationPath)) {
            $file_url = ['image_full' => $destinationPath, 'image_thumbnail' => $destinationPath];
        } else {
            $file_url = ['image_full' => "", 'image_thumbnail' => ""];
        }
        return $file_url;
    }
}
