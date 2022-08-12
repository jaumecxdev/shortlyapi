<?php

namespace App\Libraries;

use App\Contracts\URLShorterInterface;
use Illuminate\Support\Facades\Http;

class Tinyurl implements URLShorterInterface
{
    public function getApicreate(String $url)
    {
        try {
            return Http::acceptJson()->get('https://tinyurl.com/api-create.php', [
                'url' => $url,
            ]);

        } catch (\Exception $e) {
            return $e->getResponse();
        }
    }
}
