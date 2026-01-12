<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PersonsResource;
use App\Http\Requests\PersonCreateRequest;
use App\Http\Requests\PersonShowRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Repositories\PersonRepository;
use App\Jobs\EmailPerson;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected PersonRepository $personRepository)
    {
        $this->response=(object)[];
        $this->response->response=1;
        $this->response->data=array();
    }

    public function __invoke(Request $request){
        if($request->isMethod('get')){
            $this->response->data[]=(object)["info"=>"Only POST method"];
            return response()->json($this->response);
        }
        $method=$request->input('request');
        if(method_exists($this,$method)){
            return $this->$method($request);
        }
        $this->response->response=0;
        $this->response->data[]=(object)["error"=>"There is no such method"];
        return response()->json($this->response);
    }


    public function index(Request $request)
    {
        $persons=$this->personRepository->listPersons();
        if(count($persons)){
            foreach($persons as $person){
                $this->response->data[]=(object) ['id'=>$person->id,'name'=>$person->name,'surname'=>$person->surname];
            }
        }
        return response()->json($this->response);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $personCreateRequest=new PersonCreateRequest;
        $validator=Validator::make($request->input('data'),$personCreateRequest->rules());
        if($validator->fails()){
            $this->response->response=0;
            $this->response->data[]=(object)["error"=>"Unproper data"];
            return response()->json($this->response);
        }
        $person=$this->personRepository->createPerson($request->input('data'));
        $this->response->data=$person;
        EmailPerson::dispatch($person);
        return response()->json($this->response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $personShowRequest=new PersonShowRequest;
        $validator=Validator::make($request->input('data'),$personShowRequest->rules());
        if($validator->fails()){
            return response()->json((object) []);
        }
        if($person=$this->personRepository->getPerson($request->input('data')['id'])){
            $person->emails=explode(";",$person->emails);
            $this->response->data=$person;
            return response()->json($this->response);
        }else{
            return response()->json($this->response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $personCreateRequest=new PersonUpdateRequest;
        $validator=Validator::make($request->input('data'),$personCreateRequest->rules());
        if($validator->fails()){
            $this->response->response=0;
            $this->response->data[]=(object)["error"=>"Unproper data"];
            return response()->json($this->response);
        }
        if($person=$this->personRepository->getPerson($request->input('data')['id'])){
            $person->name=$request->input('data')['name'];
            $person->surname=$request->input('data')['surname'];
            $person->phone=$request->input('data')['phone'];
            $person->emails=implode(";",$request->input('data')['emails']);
            $person->save();
            $this->response->data=$person;
            return response()->json($this->response);
        }else{
            return response()->json($this->response);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $personShowRequest=new PersonShowRequest;
        $validator=Validator::make($request->input('data'),$personShowRequest->rules());
        if($validator->fails()){
            $this->response->response=0;
            $this->response->data[]=(object)["error"=>"Unpropper data"];
            return response()->json($this->response);
        }

        if($person=$this->personRepository->getPerson($request->input('data')['id'])){
            $person->delete();
            $this->response->data[]=(object)["info"=>"Person deleted"];
            return response()->json($this->response);
        }else{
            $this->response->response=0;
            $this->response->data[]=(object)["error"=>"No person"];
            return response()->json($this->response);
        }
    }
}
