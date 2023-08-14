<?php

namespace App\Http\Livewire\Gpt;

use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Messages extends Component
{

    public $input;
    public $response = null;
    protected $listeners = ['pushMessage' => 'pushMessage'];
    protected $rules = [
        'input' => 'required',
    ];
 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->response = Message::where('conversationID', Auth::id())->get();
        // $this->dispatchBrowserEvent('rowChatToBottom');
    }

    public function prompt()
    {
        $validatedData = $this->validate();
        $message = Message::create([
            'conversationID' => Auth::id(),
            'senderID' => Auth::id(),
            'text' =>  $this->input,
        ]);
        $this->emitSelf('pushMessage', $message->id);
        // $this->emitTo('settings', 'gpt', $this->input);
        $this->input = null;
     
    }

    public function pushMessage($messageID)
    {
        $newMessage = Message::find($messageID);
        $this->response->push($newMessage);
        $this->dispatchBrowserEvent('rowChatToBottom');
       
    }


    public function render()
    {
        return view('livewire.gpt.messages');
    }
}
