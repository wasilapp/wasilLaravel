<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{

    public function index()
    {
        $subCategories = SubCategory::with('category')->orderBy('updated_at', 'DESC')->paginate(10);
       // return $subCategories;
        return view('admin.sub-categories.sub-categories')->with([
            'sub_categories' => $subCategories
        ]);
    }

    public function create()
    {

        return view('admin.sub-categories.create-sub-category')->with([
            'categories'=>Category::all()
        ]);
    }


    public function store(Request $request)
    {



        $this->validate($request,
            [
                'title' => 'required|unique:sub_categories',
                'price'=>'required',
                'category'=>'required',
                 'image' => 'required',
            ],
            [
                'title.required' => 'Please enter a title',
                'title.unique' => 'This title is already taken, you can edit',
                'image.required' => 'Please provide a image'
            ]
        );
        DB::beginTransaction();
        try{
            
                $subCategory = new SubCategory();
                $subCategory->title = $request->get('title');
                $subCategory->price = $request->get('price');
                $subCategory->category_id = $request->get('category');
                
                $path = $request->file('image')->store('sub-categories', 'public');
                $subCategory->image_url = $path;
                $subCategory->save();
                DB::commit();
                return redirect()->route('admin.sub-categories.index')->with('message', 'Category created');
               }
            catch(Exception $e){
                Log::info($e->getMessage());
                DB::rollBack();
                return redirect()->route('admin.sub-categories.index')->with('error', 'Something wrong');
            }

    }

    public function show($id)
    {
    }


    public function edit($id)
    {
        $subCategory = SubCategory::with('category')->find($id);
        return view('admin.sub-categories.edit-sub-category')->with([
            'sub_category' => $subCategory
        ]);

    }


    public function update(Request $request,$id)
    {

        $this->validate($request,
            [
                'title'=>'required',
                'price'=>'required',
            ]
        );


        $subCategory = SubCategory::find($id);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sub-categories', 'public');
            $subCategory->image_url = $path;
        }
        
        // if (isset($request->active)) {
        //     SubCategory::activateSubCategory($id);
        //     $subCategory->active = true;
        // }else{
        //     SubCategory::disableSubCategory($id);
        //     $subCategory->active = false;
        // }

        $subCategory->title = $request->get('title');
        $subCategory->price = $request->get('price');
        if ($subCategory->save()) {
            return redirect(route('admin.sub-categories.index'))->with('message', 'Sub Category updated');
        }
        return redirect(route('admin.sub-categories.index'))->with('error', 'Sub Category not updated');
    }


    public function destroy($id){
         $category = SubCategory::findOrFail($id);
        DB::beginTransaction();
        try{
            $category->delete();
            DB::commit();
            return redirect(route('admin.sub-categories.index'))->with('message', 'Category deleted');
        }catch(Exception $e){
            DB::rollBack();
            return redirect(route('admin.sub-categories.index'))->with('error', 'Category not deleted');

        }
        
    }
}
