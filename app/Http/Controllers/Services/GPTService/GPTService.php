<?php

namespace App\Http\Controllers\Services\GPTService;

use Illuminate\Support\Facades\Http;



class GPTService
{
   

    public function chatGPT(string $prompt)
    {
        $openai_secret = config('services.gpt.openai_secret');
        $openai_model =  config('services.gpt.openai_model');
        $openai_tokens = (int)config('services.gpt.openai_tokens');
        $openai_temperature =  config('services.gpt.openai_temperature');
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
           
            // return $this->transformData($data);
            // $errorCode = $response['error']['code'] ?? null;
            // $errorType = $response['error']['type'] ?? null;
            return $response;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
