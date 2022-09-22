<div>
    <div wire:ignore.self class="modal fade" id="AddbacklogModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="exampleModalLabel"> Add useful thoughts or whatever you want
                        here</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="storeBacklogInfo">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="recipient-name" wire:model="title">
                            @error('title')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Choose a saved task that connected with
                                your thoughts</label>

                            <select wire:model.defer="task_id" id="" class="form-control ">
                                <option value="">#Tasks</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Content:</label>
                            <textarea class="form-control" id="message-text" wire:model.defer="content" rows="5"></textarea>
                            @error('content')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white p-2"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="text-white p-2 rounded" style="background-color: #A10000;">Save
                            Log</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- close backlog modal script --}}
@push('script')
    <script>
        window.addEventListener('close-modal', event => {
            $('#AddbacklogModal').modal('hide');
        });
    </script>
@endpush
