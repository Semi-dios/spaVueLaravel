<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Client;
use App\Http\Resources\ClientResource;



class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClientResource::collection(Client::with('city')->paginate(10));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =  Validator::make( $request->all(),[
            'name'=> 'required|min:4|max:20',
            'id_City'=> 'required',
            'url' => 'required|image|max:2048',

        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors(),'message' => 'error register !!'],401);
        }
            $image = $request->file('url');
            
            $new_name = rand().'.'.$image->getClientOriginalExtension(); 
            $image->move(public_path('/images'), $new_name);
          

          Client::create([
            'name' => $request->name,
            'id_City' => $request->id_City,
            'url' => $new_name
        ]);
      
      
     
        return response()->json(['message' => 'Client created successfully !!',$image . '"'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $clients = Client::with('city')->find($id);
        if($clients){
            return response()->json(['clients'=>$clients,'message' => 'success  !!'],200);
        }else {
            return response()->json([['error'=>'Unauthorized','message' => 'error !!'], 401]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients = Client::with('city')->find($id);
        if($clients){
            return response()->json(['clients'=>$clients,'message' => 'success  !!'],200);
        }else {
            return response()->json([['error'=>'Unauthorized','message' => 'error !!'], 401]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $clients = Client::findOrFail($id);
        $clients->update($request->all());
        return response()->json(['clients'=>$clients,'message' => 'updated!!'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json('Client deleted successfully', 204);
    }
}
