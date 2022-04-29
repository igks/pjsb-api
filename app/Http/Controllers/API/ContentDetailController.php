<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContentDetail;
use Illuminate\Http\Request;

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
        ContentDetail::create($request->all());

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
    public function update(Request $request, ContentDetail $detail)
    {
        $request->validate(ContentDetail::rules());

        $detail->update($request->all());

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
        $detail->delete();
        return response()->success();
    }
}
