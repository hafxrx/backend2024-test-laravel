<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;


class MyClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = MyClient::latest()->paginate(10);
            return view('my_client.index', compact('my_client'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($this->validate($request, [
            'name'     => 'required|max:250',
            'slug'     => 'required|max:100',
            'is_project'   => 'required|max:30',
            'self_capture'   => 'required|max:1',
            'client_prefix'   => 'required|max:4',
            'client_logo'   => 'required|image|mimes:jpg,jpeg,png',
        ])){

            $model = new MyClient;
            $file = $request->file('client_logo'); //MAKA KITA GET FILENYA
            $filename = $request->name . '-' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('s3')->put('images/' . $filename, file_get_contents($file));
            
            $model->name       = Input::get('name');
            $model->slug      = Redis::get('my_client:profile:'.$id);
            $model->is_project = Input::get('is_project');
            $model->self_capture = Input::get('self_capture');
            $model->client_prefix = Input::get('client_prefix');
            $model->client_logo = $filename;
            $model->address = Input::get('address');
            $model->phone_number = Input::get('phone_number');
            $model->city = Input::get('city');
            $model->create_at = date('Y-m-d H:i:s');
            
            $model->save();
        }
         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if($this->validate($request, [
            'name'     => 'required|max:250',
            'slug'     => 'required|max:100',
            'is_project'   => 'required|max:30',
            'self_capture'   => 'required|max:1',
            'client_prefix'   => 'required|max:4',
            'client_logo'   => 'required|max:255',
        ])){
            $model = MyClient::find($id);
            $model->name       = Input::get('name');
            $model->slug      = Redis::get('my_client:profile:'.$id);
            $model->is_project = Input::get('is_project');
            $model->self_capture = Input::get('self_capture');
            $model->client_prefix = Input::get('client_prefix');
            $model->client_logo = Input::get('client_logo');
            $model->address = Input::get('address');
            $model->phone_number = Input::get('phone_number');
            $model->city = Input::get('city');
            $model->update_at = date('Y-m-d H:i:s');
            $model->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = MyClient::find($id);
            $model->slug      = null;
            $model->delete_at = date('Y-m-d H:i:s');
            $model->save();
    }
}

//nama : Hafizh Achmad Dinan
//email : hafizhdinan35@gmail.com

//1. C 
//2. E
//3. B
//4. B 
//5. B
//6. E
//7. B
//8. A
//9. C
//10. E 
//11. D
//12. D
//13. C
//14. C
//15. C