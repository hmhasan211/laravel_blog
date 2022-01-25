<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
//use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = Category::latest()->get();
        return view('admin.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'name'=>'required|unique:categories',
            'image'=>'required|mimes:jpeg,png,jpg'
        ]);

        $image = $request->file('image');
        $slug  = str_slug($request->name);
        if (isset($image)){
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check directory
            if(!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }
              //resize image for category
            $catImage = Image::make($image)->resize(1600,479)->save('my-image.jpg', 90);
            Storage::disk('public')->put('category/'.$imageName,$catImage);

            //check slider directory
            if(!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }
            //resize image for slider
            $sliderImage = Image::make($image)->resize(500,333)->save('my-image.jpg', 90);
            Storage::disk('public')->put('category/slider/'.$imageName,$sliderImage);
        }else{
            $imageName = 'default.png';
        }
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imageName;
        $category->save();
        Toastr::success('Data Successfully Saved :)','Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
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

        //return $request;
        $this->validate($request,[
            'name'=>'required',
            'image'=>'mimes:jpeg,jpg,png,bmp'
        ]);

        $image = $request->file('image');
        $slug  = str_slug($request->name);
        $category = Category::find($id);
        if (isset($image)){
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check Category directory
            if(!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }
            //delete old Category image
            if (Storage::disk('public')->exists('category/'.$category->image)){
                Storage::disk('public')->delete('category/'.$category->image);
            }
            //resize image for category
            $catImage = Image::make($image)->resize(1600,479)->save('my-image.jpg', 90);
            Storage::disk('public')->put('category/'.$imageName,$catImage);

            //check slider directory
            if(!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }
            //delete old slider image
            if (Storage::disk('public')->exists('category/slider/'.$category->image)){
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }

            //resize image for slider
            $sliderImage = Image::make($image)->resize(500,333)->save('my-image.jpg', 90);
            Storage::disk('public')->put('category/slider/'.$imageName,$sliderImage);
        }else{
            $imageName = $category->image;
        }
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imageName;
        $category->save();
        Toastr::success('Data Successfully Updated :)','Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(Storage::disk('public')->exists('category/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
        }
        //delete old slider image
        if (Storage::disk('public')->exists('category/slider/'.$category->image)){
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }
        $category->delete();
        Toastr::success('Data Deleted Successfully!!!','success');
        return redirect()->back();
    }
}
