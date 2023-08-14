<div>
    <a class="gpt" id="gpt">
        chatGPT
    </a>


    <div class="test" wire:ignore.self>

        <div class="card gpt-wrapper">
            <div class="card-header gpt-card" style="border-radius: 17px 17px 0 0">
                <b>chatGPT</b>

                <div wire:loading wire:target="$emitTo('settings', 'gpt')"><i class="fa fa-spinner fa-spin mt-2 mx-2"
                        style="color: #A10000;  font-size: 20px;"></i> </div>

                <span id="gpt-close" role="button" class="zoom float-end "> <i class="fa fa-times"></i></span>
            </div>


            <div class="card-body message">
                @foreach ($response as $item)
                    @if ($item->senderID == null)
                        <div class="d-flex justify-content-start mb-3">
                            <div class="msg_cotainer fw-bold">
                                <p style="text-align: justify"> {{ $item->text }} </p>
                                <span class="msg_time"> {{ $item->created_at->format('m: i a') }}</span>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-end mb-3">
                            <div class="msg_cotainer_send fw-bold">
                                <p style="text-align: justify"> {{ $item->text }} </p>
                                <span class="msg_time_send"> {{ $item->created_at->format('m: i a') }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="card-footer border" style=" border-radius: 0 0 17px 17px  ">
            @error('input')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
            <form wire:submit.prevent="prompt">
                <input type="text" class="form-control" wire:model="input">
            </form>
        </div>
    </div>



    <script>
        window.addEventListener('rowChatToBottom', event => {
            $('.message').scrollTop($('.message')[0].scrollHeight); // roll up scrollbar if new message
        });
    </script>

</div>
