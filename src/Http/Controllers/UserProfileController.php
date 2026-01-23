<?php

namespace DFSmania\LaradminLte\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserProfileController extends Controller
{
    /**
     * Show the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('ladmin::profile.show', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
