<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressCreateRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Contact;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $idContact, AddressCreateRequest $addressCreateRequest): JsonResponse {
        $user = Auth::user();
        $contact = Contact::where('id', $idContact)->where('user_id', $user->id)->first();
        if (!$contact) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "Id:" . $idContact . " Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $data = $addressCreateRequest->validated();

        $address = new Address($data);
        $address->contact_id = $contact->id;
        $address->save();

        return (new AddressResource($address))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $idContact, int $idAddress): AddressResource {
        $user = Auth::user();
        $contact = Contact::where('id', $idContact)->where('user_id', $user->id)->first();
        if (!$contact) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "Id:" . $idContact . " Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $address = Address::where('id', $idAddress)->where('contact_id', $contact->id)->first();
        if (!$address) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "Id:" . $idAddress . " Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        return (new AddressResource($address));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address) {
        //
    }
}
