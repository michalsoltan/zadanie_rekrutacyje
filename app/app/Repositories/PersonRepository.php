<?php

namespace App\Repositories;

use App\Models\Persons;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Log;

class PersonRepository
{


    public function createPerson(array $data): Persons
    {
        $data['emails']=implode(';',$data['emails']);
        return Persons::create($data);
    }

    public function getPerson(int $id)
    {
        return Persons::find($id);
    }

    public function listPersons()
    {
        return Persons::get();
    }

    public function updatePerson(array $data):Persons
    {
        $data['emails']=implode(';',$data['emails']);
        return Persons::upadate($data);
    }

    public function deletePerson(int $id){
        Persons::findOrFail($id)->delete();
    }

}
