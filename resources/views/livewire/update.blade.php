<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit saved task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <input type="hidden" wire:model="userId">
                        <label for="exampleFormControlInput1">Task Name</label>
                        <input type="text" class="form-control" wire:model="taskName" id="exampleFormControlInput1" placeholder="Enter Name">
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput2">Type</label>
                        <input type="email" class="form-control" wire:model="type" 
                           id="exampleFormControlInput2" placeholder="Choose task`s type">
                        @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Priority</label>
                        <input type="" class="form-control" wire:model="priority" id="exampleFormControlInput4"
                            placeholder="Choose default priority">
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput5">Time</label>
                        <input type="time" class="form-control" wire:model="time" id="exampleFormControlInput5"  
                            placeholder="Set default time">
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Save changes</button>
            </div>
       </div>
    </div>
</div>
