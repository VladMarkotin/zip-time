<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Mail\FeedbackMail;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class Feedback extends Component
{
    use WithFileUploads;

    public const PATH = 'public/uploads';
    private const MAX_FILES_TEXT = 'Maximum of 6 files';
    private const MAX_FILES = 6;

    public $message;
    public $subject;
    public $email;
    public $files = [];
    protected $listeners = ['refresh' => '$refresh'];

    public function rules()
    {
        return [
            'message' => 'required|string|min:10',
            'email' => 'required|email',
        ];
    }

    /**
     * @return void
     */
    public function sendFeedback(): void
    {
        $to = config('mail.from.address');
        $this->validate();
        $data = [
            'content' => $this->message,
            'date' => Carbon::now(),
            'email' => $this->email,
            'name' => Auth::check() ? Auth::user()->name : null,
        ];

        Mail::send('emails.feedback', $data, function ($e) use ($to) {
            $e
                ->from($this->email, Auth::check() ? Auth::user()->name : null)
                ->to($to)
                ->subject($this->subject);
            foreach (
                str_ireplace('public', 'storage', Storage::files(self::PATH))
                as $file
            ) {
                $e->attach($file);
            }
        });
        $this->resetData();
        $this->dispatchBrowserEvent('message', [
            'text' => 'Thank You For Your Feedback!',
        ]);
    }


    /**
     * @return void
     */

    public function updatedFiles(): void
    {

        $this->validate([
            'files.*' => 'mimes:jpg,jpeg,png,gif,mp4,avi,mov,wmv,flv,pdf,doc,docx,xlsx|max:50000',
        ]);

        $existingFiles = $this->uploads();

        $existingCount = $existingFiles ? count($existingFiles) : 0;

        if ($existingCount >= self::MAX_FILES || count($this->files) >= self::MAX_FILES) {
            $this->dispatchBrowserEvent('message', ['text' => self::MAX_FILES_TEXT]);
            return;
        }

        $i = 1;
        foreach ($this->files as $key => $imageFile) {

            $filename = time() . $i++ . '.' . $imageFile->extension();
            $path = $imageFile->storeAs(self::PATH, $filename);
            $existingFiles[] =
                str_ireplace('public/', '', $path);

        }
        Cookie::queue('uploaded_files', json_encode($existingFiles), 60);
        $this->emitSelf('refresh');

    }

    /**
     * @param string $key
     * @return void
     */
    public function removeUpload(string $key): void
    {
        $files = $this->uploads();

        if (isset($files[$key])) {

            $filePath = self::PATH . '/' . basename($files[$key]);
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            unset($files[$key]);
            Cookie::queue('uploaded_files', json_encode(($files)), 60);
            $this->emitSelf('refresh');
        }
    }


    /**
     * @return void
     */
    public function resetErrors(): void
    {
        $this->resetErrorBag();
    }

    /**
     * @return void
     */
    private function resetData()
    {
        $this->message = null;
        $this->subject = null;
        $this->email = null;

        $files = $this->uploads();
        Storage::delete($files);
        Cookie::queue('uploaded_files', json_encode([]), 60);
    }

    /**
     * @return array
     */
    public function uploads(): array
    {
        return json_decode(Cookie::get('uploaded_files', '[]'), true);
    }

    public function render()
    {
        return view('livewire.feedback');
    }

}
