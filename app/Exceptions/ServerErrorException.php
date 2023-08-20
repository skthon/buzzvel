<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ServerErrorException extends HttpException
{
    public function render(Request $request)
    {
        return response()->json([
            'message' => 'Server error, please try again after some time.',
            'code'    => 500,
        ], 401);
    }
}
