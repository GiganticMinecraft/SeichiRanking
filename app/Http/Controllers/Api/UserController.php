<?php
  
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }

}
