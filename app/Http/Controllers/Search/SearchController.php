<?php

namespace App\Http\Controllers\Search;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Resources\Contact as ContactResource;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke()
    {
        $data = request()->validate([
            'searchTerm' => 'required'
        ]);
        $contacts = Contact::search($data['searchTerm'])->where('user_id', auth()->user()->id)->get() ;
        return ContactResource::collection($contacts);
    }
}
