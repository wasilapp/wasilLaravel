<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('updated_at', 'DESC')->paginate(10);
        return view('admin.categories.categories')->with([
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('admin.categories.create-category');
    }


    public function store(Request $request)
    {

        $this->validate($request,
            [
                'title' => 'required|unique:categories',

                'image' => 'required',
                'commesion' => 'required',
                'delivery_fee' => 'required',
                'type' =>'required'
            ],
            [
                'title.required' => 'Please enter a title',
                'title.unique' => 'This title is already taken, you can edit',

                'image.required' => 'Please provide an image'

            ]
        );

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category = new Category();
            $category->title = $request->get('title');
            $category->commesion = $request->get('commesion');
            $category->type = $request->get('type');

            $category->delivery_fee = $request->get('delivery_fee');

            $category->image_url = $path;
            if ($category->save()) {
                return redirect()->route('admin.categories.index')->with('message', 'Category created');
            } else {
                return redirect()->route('admin.categories.index')->with('error', 'Something wrong');
            }
        }
        return redirect()->route('categories.index')->with('error', 'Something wrong');

    }

    public function show($id)
    {
    }


    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit-category')->with([
            'category' => $category
        ]);

    }


    public function update(Request $request,$id)
    {

        $this->validate($request,
            [

                'title'=>'required',
                'type'=>'required'


            ],
        );

        $category = Category::find($id);

   /*     if (isset($request->active)) {
            Category::activateCategory($id);
            $category->active = true;
        }else{
            Category::disableCategory($id);
            $category->active = false;
        }*/

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category->image_url = $path;
        }
        $category->title = $request->get('title');
        $category->commesion = $request->get('commesion');
        $category->delivery_fee = $request->get('delivery_fee');
         $category->type = $request->get('type');



        if ($category->save()) {
            return redirect(route('admin.categories.index'))->with('message', 'Category updated');
        }
        return redirect(route('admin.categories.index'))->with('error', 'Category not updated');
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        DB::beginTransaction();
        try{
            DB::table('sub_categories')->where('category_id',$category->id)->delete();
            $category->delete();
            DB::commit();
            return redirect(route('admin.categories.index'))->with('message', 'Category deleted');
        }catch(Exception $e){
            DB::rollBack();
            return redirect(route('admin.categories.index'))->with('error', 'Category not deleted');

        }

    }

}
