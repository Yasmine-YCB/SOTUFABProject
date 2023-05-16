<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\representant;

class representantController extends Controller
{
    public function getAll(){
        return representant::get(
            'user_id',
            'fonction',
            'nom',
            'prenom',
            'numcpt',
            'vice_user_id'
        );
    }
 
}
