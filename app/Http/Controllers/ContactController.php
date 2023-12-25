<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactAddRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactAddRequest $request): JsonResponse {
        $data = $request->validated();
        $user = Auth::user();
        $contact = new Contact($data);
        $contact->user_id = $user->id;
        $contact->save();

        return (new ContactResource($contact))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact) {
        //
    }
}
