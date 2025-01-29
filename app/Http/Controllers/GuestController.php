<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestStoreRequest;
use App\Http\Requests\GuestUpdateRequest;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) //receber dados da requisição
    {
       
        $guests = Guest::query(); 
        
        //filtros
        if($request->has('name')){ //pega a key apos '?' nos parametros separa as keys/values por &
            $guests->where('name','like','%'.$request->get('name').'%');
        }
        if($request->has('is_foreigner')){
            $guests->where('is_foreigner',$request->get('is_foreigner'));
        }

        return response()->json($guests->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuestStoreRequest $request){ //usa as validações
       
        //transacition: commit se der certo e rollback se der errado , segurança
        $guest = DB::transaction(function () use($request){
            $user = User::create($request ->validated());
            //so entra o que é do fillable e validado,permitindo fazer isso
            $user->guest()->create($request ->validated()); //cria junto
            return $user->load('guest'); //na resposta da requisicao, retorna user com o guest associado
        });

        return $guest; //retorna toda a logica acima
    }

    /**
     * Display the specified resource.
     */
    public function show(Guest $guest) //funciona igual,buscando pelo id
    {
        // GET -> http://localhost:8000/api/guests/1
        //return $guest;
        
        return $guest->load(['user','phones']); //pega do relacionamento
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuestUpdateRequest $request, Guest $guest)
    {
         //transacition: commit se der certo e rollback se der errado , segurança
        $guest = DB::transaction(function () use($request,$guest){
        $guest->update($request ->validated()); //pelo body da requisicao
        $guest->user->update($request ->validated()); //permitido pois so pega o $fillable
        return $guest; // jaz faz o load
        });

        return $guest; //retorna toda a logica acima
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        
        $user = auth()->user();
        $user->guest()->delete(); //deleta guest
        $user->delete(); //deleta user vinculado ao guest

        return response()->noContent();
    }

    /**
     * Retorna todas as reservas associadas a um Guest pelo guest_id.
     */
    public function getReservas(Guest $guest)
    {
        $reservas = $guest->reservations()->get();
        return response()->json($reservas, 200);
    }
}
