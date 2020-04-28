<?php

namespace App\Http\Controllers\Birthdays;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contact;
use Illuminate\Http\Request;

class BirthdaysController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $contacts = request()->user()->contacts()->birthdays()->get();
        return Contact::collection($contacts);
    }

}
