<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Gpt extends Component
{
    // public function render()
    // {
    //     return view('livewire.gpt');
    // }

    public function chatGPT( $prompt)
    {
        $settings = DB::table('gpt')->first();
        $openai_secret =  $settings->openai_api_secret;
        $openai_model =  $settings->openai_model;
        $openai_tokens =  $settings->oai_tokens;
        $openai_temperature =  $settings->oai_temp;

 
        try{

            $response = Http::timeout(80)->withHeaders([

                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$openai_secret,
           
            ])->post('https://api.openai.com/v1/chat/completions' ,[

                'model' => $openai_model,
                'messages' => [

                    ['role' => 'system',
                     'content' => 'You are a helpful assistant',
                    ],

                    ['role' => 'user',
                     'content' =>  $prompt
                    ],
                ],

                'max_tokens' => $openai_tokens,
                'temperature' => floatval($openai_temperature) 
            ]);

          
            $response = $response ->json();
            //  dd( $response);

            if(isset($response['choices'][0]['message']['content']))
            {
                 $message = Message::create([
                'conversationID' => Auth::id(),
                'senderID' => null,
                'text' => $response['choices'][0]['message']['content'] ,
                 ]);
                 $this->emitTo('gpt.messages','pushMessage', $message->id); 
            }

            $errorCode = $response['error']['code'] ?? null;
            $errorType = $response['error']['type'] ?? null;
            $this->dispatchBrowserEvent('message', [
                'text' =>   $errorCode
            ]);


        }catch(\Exception $e){

            dd( $e->getMessage()) ;
        }
    }
}
