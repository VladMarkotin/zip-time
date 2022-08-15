<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="AddbacklogModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel"> Add useful thoughts or whatever you want here</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form wire:submit.prevent="storeBacklogInfo">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Title:</label>
                    <input type="text" class="form-control" id="recipient-name" wire:model.defer="title">
                </div>

                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Choose a saved task that connected with
                        your thoughts</label>

                    <select name="task_id" id="" class="form-control">
                        <option value="">#Tasks</option>
                        @foreach ($tasks as $task)
                        <option value="{{ $task->id}}">{{ $task->task_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Content:</label>
                    <textarea class="form-control" id="message-text" wire:model.defer="content" rows="5"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Log</button>
            </div>
        </form>
    </div>
</div>
</div>





<!-- edit Modal -->
<div wire:ignore.self class="modal fade" id="editBacklogModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel"> Add useful thoughts or whatever you want here</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form wire:submit.prevent="updateBacklogInfo">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Title:</label>
                    <input type="text" class="form-control" id="recipient-name" wire:model.defer="title">
                </div>

                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Choose a saved task that connected with
                        your thoughts</label>

                    <select wire:model.defer="task_id" id="" class="form-control">
                        <option value="">#Tasks</option>
                        @foreach ($tasks as $task)
                        <option value="{{ $task->id}}">{{ $task->task_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Content:</label>
                    <textarea class="form-control" id="message-text" wire:model.defer="content" rows="5"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Log</button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- delete Modal -->
<div wire:ignore.self class="modal fade" id="deleteBacklogModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Log delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <form wire:submit.prevent="destroyBacklogInfo">

            <div class="modal-body">
                <h6>Are you sure you wanna delete?</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
</div>
