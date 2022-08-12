<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\URLRequest;
use App\Contracts\URLShorterInterface;

class URLController extends Controller
{
    public function getApicreate(URLRequest $request, URLShorterInterface $shorter)
    {
        $validated = $request->safe()->only(['url']);

        try {
            $response = $shorter->getApicreate($validated['url']);

            if ($response->successful()) {
                return response()->json(["url" => $response->body()]);
            }
            else {
                return response()->json(["error" => 'A error has occurred: '.$response->status()]);
            }

        } catch (\Throwable $th) {
            return response()->json(["error" => 'A error has occurred: '.$th->getMessage()]);
        }
    }
}
