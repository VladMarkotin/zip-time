<div>
    <a class="feedback-button" id="feedback">
        send feedback </a>
    <div class="main-wrapper " wire:ignore.self>

        {{-- REPORT MAIN --}}
        <div class="feedback-main" wire:ignore.self>
            <div class="d-flex justify-content-between p-4 text-white ">
                <span>
                    <h3 class="fw-bold zoom">Quipl</h3>
                </span>
                <span style="font-size: 20px" role="button" id="feedback-close" class="zoom"
                      wire:click="resetErrors()"><i class="fa fa-times"></i></span>
            </div>
            <div class="card-header mt-4">
                <h2 class="fw-bold mx-4"><span class="text-secondary"> Hi </span><img
                        src="{{ asset('images/wave.png') }}" alt="" width="35px"><br>
                    <span class="text-white">How can we help?</span>
                </h2>

            </div>

            <div class="card-body p-4 mt-2 mb-0">


                <div class="d-flex flex-column ">
                    <div class="feedback-select" role="button" id="feedback-report">
                        <p><span class="fw-bold">Report an issue</span><br><span class="text-secondary">Found a bug?
                                Let us
                                know.</span> <span class="float-end mx-3" style="font-size: 20px; color:#d42929"><i
                                    class="fa fa-bug" aria-hidden="true"></i></span></p>
                    </div>
                    <div class="feedback-select" role="button" id="feedback-request">
                        <p><span class="fw-bold">Request a feature</span><br><span class="text-secondary">What would
                                you
                                like to see next?</span><span class="float-end  mx-3"
                                                              style="font-size: 23px; color:rgb(190, 190, 67)"><i
                                    class="fa fa-lightbulb-o"
                                    aria-hidden="true"></i></span></p>
                    </div>
                    <div class="feedback-select" role="button" id="feedback-contact">
                        <p><span class="fw-bold">Contact us</span><br><span class="text-secondary">We are here to
                                help.</span><span class="float-end mx-3"
                                                  style="font-size: 20px; color:rgb(80, 21, 134)"><i
                                    class="fa fa-envelope"
                                    aria-hidden="true"></i></span></p>
                    </div>
                </div>
            </div>

        </div>


        <div class="card feedback-bug border-0 " style="border-radius:17px;" wire:ignore.self>
            <div class="d-flex flex-row justify-content-between p-3 adiv text-white">

                <span id="feedback-back" role="button" class="zoom" wire:click="resetErrors()"> <i
                        class="fa fa-chevron-left"></i></span>
                <span class="fw-bold">Report an issue</span>
                <span id="feedback-close" role="button" class="zoom" wire:click="resetErrors()"> <i
                        class="fa fa-times"></i></span>
            </div>
            <form wire:submit.prevent="sendFeedback" enctype="multipart/form-data">
                <div class="mt-2 p-4 ">

                    <h6 class="mb-0 ">Found a bug? Let us know.</h6>


                    <label for="message" class="fw-bold mt-3 mb-0">Describe the issue<span
                            class="text-danger">*</span></label>
                    @error('message')
                    <span class="error  text-danger fw-bold mx-1" style="font-size: 13px">{{ $message }}</span>
                    @enderror
                    <div class="form-group ">
                        <textarea class="form-control " placeholder="The more information, the better"
                                  wire:model="message"></textarea>

                    </div>

                    <label for="message" class="fw-bold mt-2 mb-0">Email<span class="text-danger">*</span></label>
                    @error('email')
                    <span class="error  text-danger  fw-bold mx-3" style="font-size: 13px">{{ $message }}</span>
                    @enderror
                    <div class="form-group mt-1">
                        <input class="form-control" type="email" placeholder="Email" wire:model="email">

                    </div>

                    <div class="flex-row d-flex justify-content-evenly mt-4 mb-0">

                        <div class="input-group">
                            <input type="file" class="form-control" id="inputGroupFile02" multiple
                                   wire:model="files">
                            <div wire:loading wire:target="files" wire:key="files"><i
                                    class="fa fa-spinner fa-spin mt-2 mx-2"
                                    style="color: #A10000;  font-size: 20px;"></i></div>
                            <div wire:loading wire:target="removeUpload"><i
                                    class="fa fa-spinner fa-spin mt-2 mx-2"
                                    style="color: #A10000;  font-size: 20px;"></i></div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        @foreach ($this->uploads() as $key => $file)
                            <div class="col-2 image">
                                @php
                                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ url('storage/' . $file) }}" width="50px" height="50px"
                                         class="rounded mb-1">
                                @elseif (in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv', 'flv']))
                                    <i class="fa fa-video-camera" style="font-size: 50px;"></i>
                                @elseif (in_array($fileExtension, ['pdf', 'doc', 'docx', 'xlsx']))
                                    <i class="fa fa-file" style="font-size: 50px;"></i>
                                @endif

                                <a role="button" wire:click="removeUpload({{ $key }})">
                <span class="remove-upload">
                    <i class="fa fa-trash"></i>
                </span>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="{{ count(Storage::files(self::PATH)) < 1 ? 'mt-4' : 'mt-2' }}">
                        <button class="btn btn- btn-block text-white"
                                style="background: #a10000; border-radius:8px"><span>Send feedback</span>
                            <div wire:loading wire:target="sendFeedback" wire:key="sendFeedback"><i
                                    class="fa fa-spinner fa-spin  ml-2" style="color: #fff;  font-size: 17px;"></i>
                            </div>

                        </button>
                    </div>

                </div>
            </form>
            @if (count( json_decode(Cookie::get('uploaded_files', '[]'), true)) < 1)
                <div class="footer mt-5">
                    <p class=" text-center text-secondary fw-bold  fst-italic">Your feedback will help us improve.
                    </p>
                </div>
            @endif
        </div>


        {{-- REQUEST FEATURE --}}

        <div class="card feedback-request border-0" style="border-radius:17px; " wire:ignore.self>
            <div class="d-flex flex-row justify-content-between p-4 adiv text-white">

                <span id="feedback-back" role="button" class="zoom" wire:click="resetErrors()"> <i
                        class="fa fa-chevron-left"></i></span>
                <span class="fw-bold">Request a feature</span>
                <span id="feedback-close" role="button" class="zoom" wire:click="resetErrors()"> <i
                        class="fa fa-times"></i></span>
            </div>
            <form wire:submit.prevent="sendFeedback">
                <div class="mt-0 p-4 ">
                    <h6 class="mb-0 ">Let us know what you would like to see next.</h6>

                    <label for="message" class="fw-bold mt-3 mb-0">subject <span
                            class="text-danger">*</span></label>
                    @error('subject')
                    <span class="error text-danger fw-bold mx-1" style="font-size: 13px">{{ $message }}</span>
                    @enderror
                    <div class="form-group ">

                        <input class="form-control" type="text" placeholder="The more details, the better."
                               name="subject" wire:model="subject">
                    </div>


                    <label for="message" class="fw-bold mt-1 mb-0">Description<span
                            class="text-danger">*</span></label>
                    @error('message')
                    <span class="error text-danger fw-bold mx-2" style="font-size: 13px">{{ $message }}</span>
                    @enderror
                    <div class="form-group mt-0">
                        <textarea class="form-control " placeholder="What feature would you like top see next?"
                                  name="description"
                                  wire:model="message"></textarea>
                    </div>

                    <label for="email" class="fw-bold mt-1 mb-0">Email<span class="text-danger">*</span></label>
                    @error('email')
                    <span class="error text-danger fw-bold mx-3" style="font-size: 13px">{{ $message }}</span>
                    @enderror
                    <div class="form-group mt-0 mb-3">
                        <input class="form-control" type="email" placeholder="Email" wire:model="email">
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn- btn-block text-white "
                                style="background: #a10000; border-radius:8px"><span>Send feedback</span></button>
                    </div>

                </div>
            </form>
            <div class="p-0, mt-3">
                <p class=" text-center text-secondary fw-bold  fst-italic">Your feedback will help us improve.</p>
            </div>
        </div>


        {{-- CONTACT US --}}

        <div class="card feedback-contact" style="border-radius:17px; " wire:ignore.self>
            <div class="d-flex flex-row justify-content-between p-4 adiv text-white">

                <span id="feedback-back" role="button" class="zoom" wire:click="resetErrors()"> <i
                        class="fa fa-chevron-left"></i></span>
                <span class="fw-bold">Contact us</span>
                <span id="feedback-close" role="button" class="zoom" wire:click="resetErrors()"> <i
                        class="fa fa-times"></i></span>
            </div>
            <form wire:submit.prevent="sendFeedback">
                <div class="mt-2 p-4 ">
                    <h6 class="mb-0 ">We are happy to answer any of your questions.</h6>

                    <label for="message" class="fw-bold mt-3">Message <span class="text-danger">*</span></label>
                    @error('message')
                    <span class="error text-danger fw-bold mx-2" style="font-size: 13px">{{ $message }}</span>
                    @enderror
                    <div class="form-group ">

                        <textarea class="form-control " rows="4" placeholder="Your message" name="contact"
                                  wire:model="message"></textarea>
                    </div>


                    <label for="message" class="fw-bold mt-2">Email<span class="text-danger">*</span></label>
                    @error('email')
                    <span class="error text-danger fw-bold mx-2" style="font-size: 13px">{{ $message }}</span>
                    @enderror
                    <div class="form-group ">
                        <input class="form-control" type="email" placeholder="Email" wire:model="email">
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn- btn-block text-white "
                                style="background: #a10000; border-radius:8px"><span>Send feedback</span></button>
                    </div>
                </div>
            </form>
            <div class="p-2">
                <p class=" text-center text-secondary fw-bold  fst-italic">Your feedback will help us improve.</p>
            </div>
        </div>

    </div>

</div>
