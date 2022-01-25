<?php

namespace App\Http\Controllers\Admin;

use App\Tag;

//use Brian2694\Toastr\Toastr;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['tags'] = Tag::orderBy('id','desc')->get();
        return view('admin.tag.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);

        $data = Tag::insert([
            'name'=> $request->name,
            'slug'=>str_slug($request->name),
        ]);
        if ($data){
            return redirect()->route('admin.tag.index')->with('success','Data Saved Successfully!!!');
        }else{
            return redirect()->route('admin.tag.index')->with('warning','Failed to Saved Data!!!');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['tag'] = Tag::find($id);
        return view('admin.tag.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
        ]);

        $data['tag'] = Tag::find($id)->update([
            'name'=>$request->name,
            'slug'=>str_slug($request->name),
        ]);
            return redirect()->route('admin.tag.index',$data)->with('success','Data Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::find($id)->delete();
        return redirect()->back()->with('delete','Data has been deleted!!');
    }
}
