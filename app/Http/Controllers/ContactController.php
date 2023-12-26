<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ContactResource;
use App\Http\Requests\ContactAddRequest;
use App\Http\Resources\ContactCollection;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\ContactUpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactController extends Controller {
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
    public function show(int $id): ContactResource {
        $user = Auth::user();
        $contact = Contact::where('id', $id)->where('user_id', $user->id)->first();
        if (!$contact) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "Id:" . $id . " Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, ContactUpdateRequest $request): ContactResource {
        $user = Auth::user();
        $contact = Contact::where('id', $id)->where('user_id', $user->id)->first();

        if (!$contact) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "Id:" . $id . " Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $data = $request->validated();
        $contact->fill($data);
        $contact->save();

        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response {
        $user = Auth::user();
        $contact = Contact::where('id', $id)->where('user_id', $user->id)->first();
        if (!$contact) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        "Id:" . $id . " Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $contact->delete();
        return response(null, 204);
    }

    /**
     * Display a listing of the resource.
     */
    public function search(Request $request): ContactCollection {
        $user = Auth::user();
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);


        $contacts = Contact::where('user_id', $user->id);

        $contacts = $contacts->where(function (Builder $builder) use ($request) {
            $name = $request->input('name');
            if ($name) {
                $builder->where(function (Builder $builder) use ($name) {
                    $builder->orWhere('first_name', 'like', "%" . $name . "%");
                    $builder->orWhere('last_name', 'like', "%" . $name . "%");
                });
            }
            $email = $request->input('email');
            if ($email) {
                $builder->where('email', 'like', '%' . $email . '%');
            }
            $phone = $request->input('phone');
            if ($phone) {
                $builder->where('phone', 'like', "%" . $phone . "%");
            }
        });

        $contacts = $contacts->paginate(perPage: $size, page: $page);

        return new ContactCollection($contacts);
    }
}
