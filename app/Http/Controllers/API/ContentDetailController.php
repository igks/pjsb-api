<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByContent(int $id)
    {
        $details = ContentDetail::with('content')
            ->where('content_id', '=', $id)
            ->paginate(10);
        return response()->success($details);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(ContentDetail::rules());
        $path = "";
        if ($request->file('thumbnail') != null) {
            $path = $request->file('thumbnail')->store('public/thumbnail');
        }
        ContentDetail::create(array_merge($request->except('thumbnail'), ['thumbnail' => substr($path, strlen('public/'))]));

        return response()->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(ContentDetail $detail)
    {
        return response()->success($detail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        $detail = ContentDetail::find($id);
        if ($detail != null) {
            $request->validate(ContentDetail::rules());
            $input = $request->except('thumbnail');
            $detail->update($input);

            if ($request->file('thumbnail') != null) {
                if ($detail->thumbnail != "") {
                    $filename = substr($detail->thumbnail, strlen('thumbnail/'));
                    Storage::disk('thumbnail')->delete($filename);
                }

                $path = $request->file('thumbnail')->store('public/thumbnail');
                $detail->update(['thumbnail' => substr($path, strlen('public/'))]);
            }
        }

        return response()->success($detail);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContentDetail $detail)
    {
        if ($detail->thumbnail != "") {
            $filename = substr($detail->thumbnail, strlen('thumbnail/'));
            Storage::disk('thumbnail')->delete($filename);
        }

        $detail->delete();
        return response()->success();
    }
}
