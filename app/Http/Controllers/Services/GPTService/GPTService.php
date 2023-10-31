<?php

namespace App\Http\Controllers\Services\GPTService;

use Illuminate\Support\Facades\Http;

class GPTService
{

    public function chatGPT(string $prompt)
    {
        $openai_secret =  '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';
        $openai_model =  'gpt-3.5-turbo';
        $openai_tokens =  100;
        $openai_temperature =  0.1;
        try {
            $response = Http::timeout(80)->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $openai_secret,
            ])->post('https://api.openai.com/v1/chat/completions', [

                'model' => $openai_model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant',
                    ],
                    [
                        'role' => 'user',
                        'content' =>  $prompt
                    ],
                ],

                'max_tokens' => $openai_tokens,
                'temperature' => floatval($openai_temperature)
            ]);
            $response = $response->json();
            return  $response;
            $errorCode = $response['error']['code'] ?? null;
            $errorType = $response['error']['type'] ?? null;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
