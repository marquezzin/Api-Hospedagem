<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressStoreRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Models\Address;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Guest $guest)
    {
        $addresses = $guest->addresses()->get();
        return $addresses;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Guest $guest, AddressStoreRequest $request)
    {
        //Rollback caso der erro, + seguro
        $address = DB::transaction(function () use ($request, $guest) {
            return $guest->addresses()->create($request->validated());
        });
        // Retornar o endereço
        return response()->json([
            'success' => true,
            'data' => $address
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guest $guest, Address $address)
    {
        // Verificar se o endereço pertence ao hóspede
        if ($address->guest_id !== $guest->id) {
            return response()->json([
                'success' => false,
                'message' => 'O endereço não pertence ao hospede informado.'
            ], 404);
        }

        // Retornar o endereço
        return response()->json([
            'success' => true,
            'data' => $address
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Guest $guest, Address $address, AddressUpdateRequest $request)
    {
        // Verificar se o endereço pertence ao hóspede
        if ($address->guest_id !== $guest->id) {
            return response()->json([
                'success' => false,
                'message' => 'O endereço não pertence ao hospede informado.'
            ], 404);
        }

        $address = DB::transaction(function () use ($request, $address) {
            $address->update($request->validated());
            return $address->load('guest');
        });

        // Retornar o endereço
        return response()->json([
            'success' => true,
            'data' => $address
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guest $guest, Address $address)
    {
        // Verificar se o endereço pertence ao hóspede
        if ($address->guest_id !== $guest->id) {
            return response()->json([
                'success' => false,
                'message' => 'O endereço não pertence ao hospede informado.'
            ], 404);
        }

        // Deletar o endereço
        $address->delete();

        // Retornar resposta de sucesso
        return response()->json([
            'success' => true,
            'message' => 'Endereço deletado com sucesso.'
        ], 200);
    }
}
