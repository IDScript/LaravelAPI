<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Contact;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AddressResource;
use App\Http\Requests\AddressCreateRequest;
use App\Http\Requests\AddressUpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressController extends Controller {
    private function getContact(User $user, int $idContact): Contact {
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

        return $contact;
    }

    private function getAddress(Contact $contact, int $idAddress): Address {
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

        return $address;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $idContact, AddressCreateRequest $addressCreateRequest): JsonResponse {
        $user = Auth::user();
        $contact = $this->getContact($user, $idContact);
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
        $contact = $this->getContact($user, $idContact);
        $address = $this->getAddress($contact, $idAddress);
        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $idContact, int $idAddress, AddressUpdateRequest $addressUpdateRequest): AddressResource {
        $user = Auth::user();
        $contact = $this->getContact($user, $idContact);
        $address = $this->getAddress($contact, $idAddress);

        $data = $addressUpdateRequest->validated();
        $address->fill($data);
        $address->save();

        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $idContact, int $idAddress): Response {
        $user = Auth::user();
        $contact = $this->getContact($user, $idContact);
        $address = $this->getAddress($contact, $idAddress);
        $address->delete();
        return response(null, 204);
    }
}
