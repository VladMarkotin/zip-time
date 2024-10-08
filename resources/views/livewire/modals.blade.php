<!-- Add backlogModal -->

<div> 
    @auth


<!-- edit backlogModal -->
<div wire:ignore.self class="modal fade" id="editBacklogModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header " style="background-color:#A10000;">
            <h5 class="modal-title text-white " id="exampleModalLabel"> Update Logs</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 

        <form wire:submit.prevent="updateBacklogInfo">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Title:</label>
                    <input type="text" class="form-control" id="recipient-name" wire:model="title">
                    @error('title') <span class="error text-danger">{{ $message }}</span> @enderror
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
                    @error('content') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white p-2" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="text-white p-2 rounded"  style="background-color: #A10000;">Update Log</button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- delete backlogModal -->
<div wire:ignore.self class="modal fade" id="deleteBacklogModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header " style="background-color:#A10000;">
            <h5 class="modal-title text-white " id="exampleModalLabel"> Delete Logs</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 


        <form wire:submit.prevent="destroyBacklogInfo">

            <div class="modal-body">
                <h6>Are you sure you wanna delete?</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white p-2" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="text-white p-2 rounded"  style="background-color: #A10000;">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- deletenotificationModal -->
<div wire:ignore.self class="modal fade" id="deleteNotificationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header " style="background-color:#A10000;">
            <h5 class="modal-title text-white " id="exampleModalLabel"> Delete Notification</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 


        <form wire:submit.prevent="destroyNotification">

            <div class="modal-body">
                <h6>Are you sure you wanna delete?</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white p-2" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="text-white p-2 rounded"  style="background-color: #A10000;">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
</div>




<!-- edit editNotificationModal -->
<div wire:ignore.self class="modal fade" id="editNotificationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header " style="background-color:#A10000;">
            <h5 class="modal-title text-white " id="exampleModalLabel"> Update Notification</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 

        <form wire:submit.prevent="updateNotification">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Notification Type:</label>
                    <input type="text" class="form-control" id="recipient-name" wire:model="type">
                    @error('type') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Notification Date:</label>
                    <input type="date" class="form-control" id="recipient-name" wire:model="date">
                    @error('date') <span class="error text-danger">{{ $date }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="message-text" class="col-form-label"> Notification Data:</label>
                    <textarea class="form-control" id="message-text" wire:model.defer="data" rows="5"></textarea>
                    @error('data') <span class="error text-danger">{{ $data }}</span> @enderror
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white p-2" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="text-white p-2 rounded"  style="background-color: #A10000;">Update Notification</button>
            </div>
        </form>
    </div>
</div>
</div>



</div>
@endauth