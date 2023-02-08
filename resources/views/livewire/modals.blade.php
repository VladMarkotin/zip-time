<!-- Add backlogModal -->
@auth
<div> 



<div wire:ignore.self class="modal fade" id="AddbacklogModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header " style="background-color:#A10000;">
            <h5 class="modal-title text-white " id="exampleModalLabel"> Add useful thoughts or whatever you want here</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 

        <form wire:submit.prevent="storeBacklogInfo">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Title:</label>
                    <input type="text" class="form-control" id="recipient-name" wire:model="title">
                    @error('title') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Choose a saved task that connected with
                        your thoughts</label>

                    <select  wire:model.defer="task_id" id="" class="form-control">
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
                <button type="submit" class="text-white p-2 rounded"  style="background-color: #A10000;">Save Log</button>
            </div>
        </form>
    </div>
</div>
</div>





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
                    <label for="recipient-name" class="col-form-label">Title:</label>
                    <input type="text" class="form-control" id="recipient-name" wire:model="type">
                    @error('type') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Content:</label>
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



 <!-- Modal Создать уведомление-->
 <div class="modal fade" id="addNotification" tabindex="-1" role="dialog"
 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLongTitle">Create notification</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         <div class="modal-body">

             <div class="row">

                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>Notification`s type:</strong>
                         <input id="typeNotification" type="text" name="typeNotification"
                             class="form-control"
                             placeholder='Придумайте тип напоминания (например "Важное")'>
                     </div>
                 </div>

                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>Notification`s text:</strong>
                         <input id="dataNotification" type="text" name="dataNotification"
                             class="form-control" placeholder="Notification`s text">
                     </div>
                 </div>

                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>Notification`s date:</strong>
                         <input id="dateNotification" type="date" name="dateNotification"
                             class="form-control">
                     </div>
                 </div>

                 <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                     <p></p>
                     <button id="saveNotification" class="btn btn-light">
                         Save
                     </button>
                 </div>

             </div>
         </div>
     </div>
 </div>
</div>

<!-- Modal Отправить через Pusher-->
<div class="modal fade" id="sendToPusher" tabindex="-1" role="dialog"
 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLongTitle">Отправить через Pusher</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         <div class="modal-body">

             <div class="row">

                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>Тип уведомления:</strong>
                         <input id="typeNotificationPusher" type="text"
                             name="typeNotification" class="form-control" value="Pusher"
                             readonly>
                     </div>
                 </div>

                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>Notification`s text:</strong>
                         <input id="dataNotificationPusher" type="text"
                             name="dataNotification" class="form-control"
                             placeholder="Notification`s text">
                     </div>
                 </div>

                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>Notification`s date:</strong>
                         <input id="dateNotificationPusher" type="date"
                             name="dateNotification" class="form-control">
                     </div>
                 </div>

                 <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                     <p></p>
                     <button id="sendNotification" class="btn btn-light">
                         Send notification
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>

</div>
@endauth