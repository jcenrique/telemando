<?php

namespace App\Http\Controllers;

use App\Models\Alarma;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Livewire\WithPagination;


class SearchController extends Controller
{

   use WithPagination;
    public function index(Request $request)
    {
       
       
        $alarmas =null;
        if($query = $request->get('query')){
            $alarmas = Alarma::search($query, function($meilisearch, $query, $options){
                return $meilisearch->search($query,$options);
            })->paginate();
     
        }
       


        return view('results_search', ['alarmas' => $alarmas]);
    }
}
