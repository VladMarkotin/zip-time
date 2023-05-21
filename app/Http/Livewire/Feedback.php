<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Mail\FeedbackMail;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Feedback extends Component
{
    use WithFileUploads;

    public const PATH = 'public/uploads/images';
    public $message;
    public $subject;
    public $email;
    // public $isSent = false;
    public $files = [];
    protected $rules = [
        'message' => 'required|min:50',
        'email' => 'required|email',
       
    ];

    public function sendFeedback(): void
    {
        // $this->isSent = true;
        $this->validate();
        $data = [
            'content' => $this->message,
            'date'    => Carbon::now(),
            'email'    => $this->email,
            'name'    => Auth::check() ? Auth::user()->name : null
        ];

        Mail::send('emails.feedback', $data, function ($e) {
            $e
                ->from($this->email, Auth::check() ? Auth::user()->name : null)
                ->to('quiplapp@gmail.com')
                ->subject($this->subject);
            foreach ( str_ireplace('public', 'storage', Storage::files(self::PATH)) as $file ) 
            {
                $e->attach($file);
            }
        });
    }

    public function updatedFiles()
    {

        //  $this->validate([
        //     'files.*' => 'image|max:1024', // 1MB Max
        // ]);
        $text = 'Maximum of 6 files';
        $files = Storage::files(self::PATH);
        $count = count($files);

        if (count($this->files) <= 6) {
            $i = 1;
            foreach ($this->files as $key => $imageFile) {
                if ($count < 6) {
                    $extension = $imageFile->extension();
                    $filename = time() . $i++ . '.' . $extension;
                    $imageFile->storeAs(self::PATH, $filename);
                    $this->files[$key] = $filename;
                    $count++;
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => $text,
                    ]);
                    break;
                }
            }
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => $text,
            ]);
        }
    }

    public function removeUpload($param)
    {
        foreach (Storage::files(self::PATH) as $key => $file) {
            if ($key == $param) {
                if (Storage::exists($file)) {
                    return Storage::delete($file);
                }
            }
        }
    }

    public function resetErrors(): void
    {

     $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.feedback');
    }
}
