<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Response;

use App\Resource;
use App\ResourceCate;
use App\DocCat;

use File;

class ResourceController extends Controller
{    
    // Manage Resource
    public function manage_resource(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return redirect()->route('login');
        }
        $data['page_name'] = "Manage Partner";
        $data['cate'] = ResourceCate::get();
        $data['resources'] = Resource::get();
        return view('admin.resource.manage-resource', $data);
    }
    public function new_resource(Request $request){
        // use App\Resource;
        // use App\ResourceCate;
        if(!Session::has('user_id') || session('level') < 2){
            return "You don't have permission to access this page";
        }
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('upload'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
        }
        // Category
        $cate_type = $request['cate_type'];
        if($cate_type == 0){
            // $cate_id = $request['cate'];
            $cate_id = json_encode($request['cate']);
        }
        else{
            $cate = ResourceCate::where('title', $request['cate_name'])->first();
            if(isset($cate->id)){
                $cate_id = $cate->id;
            }
            else{
                $category = new ResourceCate;
                $category->title = $request['cate_name'];
                $category->save();
                $cate_id = $category->id;
            }
        }
        $resource = new Resource;
        $resource->name = $request['name'];
        $resource->email = $request['email'];
        $resource->email_1 = $request['email_1'];
        $resource->phone_number = $request['phone_number'];
        $resource->com_name = $request['com_name'];
        $resource->file = $file_name;
        $resource->cate_id = $cate_id;
        $resource->save();
        return 'success';
    }
    public function update_resource(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return "You don't have permission to access this page";
        }
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('upload'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
        }
        // Category
        $cate_type = $request['cate_type'];
        // Categroy
        if($cate_type == 0){
            // $cate_id = $request['cate'];
            $cate_id = json_encode($request['cate']);
        }
        else{
            $cate = ResourceCate::where('title', $request['cate_name'])->first();
            if(isset($cate->id)){
                $cate_id = $cate->id;
            }
            else{
                $category = new ResourceCate;
                $category->title = $request['cate_name'];
                $category->save();
                $cate_id = $category->id;
            }
        }
        if($file_name != ""){
            Resource::where('id', $request['id'])
                ->update([
                    'file' => $file_name
                ]);
        }
        Resource::where('id', $request['id'])
            ->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'email_1' => $request['email_1'],
                'phone_number' => $request['phone_number'],
                'com_name' => $request['com_name'],
                "cate_id" => $cate_id,
            ]);
        return "success";
    }
    public function delete_resource(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return "You don't have permission to access this page";
        }
        Resource::where('id', $request['id'])->delete();
        return 'success';
    }
    // Manage Type
    public function manage_type(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return redirect()->route('login');
        }
        $data['page_name'] = "Manage Partner Types";
        $data['cate'] = ResourceCate::get();
        return view('admin.resource.manage-types', $data);
    }
    public function new_resource_type(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return "You don't have permission to access this page";
        }
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('upload'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
        }
        $type = new ResourceCate;
        $type->title = $request['title'];
        $type->extra = $request['extra'];
        $type->file = $file_name;
        $type->save();
        return 'success';
    }
    public function update_resource_type(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return "You don't have permission to access this page";
        }
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('upload'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
        }
        ResourceCate::where('id', $request['id'])
            ->update([
                'title' => $request['title'],
                'extra' => $request['extra'],
            ]);
        if($file_name != ''){
            ResourceCate::where('id', $request['id'])
            ->update([
                'file' => $file_name,
            ]);
        }
        return 'success';
    }
    public function delete_resource_type(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return "You don't have permission to access this page";
        }
        ResourceCate::where('id', $request['id'])->delete();
        return 'success';
    }
    // Resoure View
    public function graphic_view(){
        if(!Session::has('user_id')){
            return redirect()->route('login');
        }
        $data = [];
        $data['page_name'] = "Advertising Tools";
        $data['pa'] = \App::call("App\Http\Controllers\UserController@list_pa");

        $data['types'] = ResourceCate::get();
        $data['resource'] = Resource::leftjoin('tbl_resource_category', 'tbl_resource.cate_id',  'tbl_resource_category.id')
            ->select('tbl_resource_category.title', 'tbl_resource_category.extra as extra_cate', 'tbl_resource_category.file as type_file', 'tbl_resource.*')
            ->orderBy('tbl_resource_category.id')
            ->get();
        $data['cate'] = DocCat::get();
        return view('admin.resource.graphic', $data);
    }
}
