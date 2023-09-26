<div>
    @auth  
        <div class="col-lg-3 notification-wrapper  bg-light p-0 overflow-auto rounded shadow-sm" wire:ignore.self> 
            
            <div class="box-title border-bottom ">
                <h6 class="fw-bold p-2 heading-line-drop ">Notifications

                    <div class="form-check float-end mr-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" wire:model="unread" value="all">
                        <label class="form-check-label mt-1" for="flexCheckDefault">
                            Unread 
                        </label>
                      </div>

                </h6>
            </div>
        <div class="box  bg-white p-1 " >
                <div class="box-body  ">
                    @foreach ($notifications as $notification)
                        <div class=" d-flex align-items-center notification-dropdown-item rounded">
                            <a class="mr-2 pl-2 w-100 text-dark text-decoration-none" role="button" wire:click="readNotification( {{ $notification->id }})">
                           
                                <div @class([ 'text-justify ','fw-bold' => $notification->read_at == 0, ])>
                                    {{ $notification->data }}
                                </div>
                            </a>
                            <span class="ml-auto mb-auto px-1">
                                <div class="btn-group ">
                                    <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <button type="button" class="dropdown-item"
                                            wire:click="addTask({{ $notification->id }})">
                                            <i class="bi bi-journal-arrow-up"></i>
                                            Add Job/Task
                                        </button>

                                        <button type="button" class="  dropdown-item"
                                            wire:click="deleteNotification( {{ $notification->id }})">
                                            <i class="mdi mdi-delete \f2b5"></i>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </span>
                        </div>
                    @endforeach
                </div>
               
            </div> 

            <div class=" p-2 bg-light  view-all border-top ">
                <a href="{{ url('notifications') }}" class="text-decoration-none">
                     <h6 class="text-center font-weight-bold">View all</h6>
                </a>              
            </div>
        </div>
        
    @endauth




     <!-- Modal Отправить через notification-->
     <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
     wire:ignore.self>
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLongTitle">Create notification</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">

                 <div class="row">

                     <form wire:submit.prevent="saveNotification">
                         <div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                 <strong>Notification type:</strong>
                                 <input type="text" class="form-control"
                                     placeholder='Придумайте тип напоминания (например "Важное")' wire:model="type">
                                 @error('type')
                                     <span class="error text-danger">{{ $message }}</span>
                                 @enderror
                             </div>

                         </div>

                         <div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                 <strong>Notification text:</strong>
                                 <textarea type="text" class="form-control" placeholder="Notification`s text"
                                     wire:model="data"></textarea>
                                 @error('data')
                                     <span class="error text-danger">{{ $message }}</span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                 <strong>Notification date:</strong>
                                 <input type="date" class="form-control" wire:model="date">
                                 @error('date')
                                     <span class="error text-danger">{{ $message }}</span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                             <button class="btn btn-light">
                                 Save
                             </button>
                         </div>
                     </form>
                 </div>
             </div>

         </div>
     </div>
 </div>






 <!-- Modal Отправить через Pusher-->
 <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Broadcast</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="row">


                <form wire:submit.prevent="pushNotification">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Notification type:</strong>
                            <input type="text" class="form-control"
                                     wire:model="type">
                            @error('type')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Notification text:</strong>
                            <textarea type="text" class="form-control" placeholder="Notification`s text"
                                wire:model="data"></textarea>
                            @error('data')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Notification date:</strong>
                            <input type="date" class="form-control" wire:model="date">
                            @error('date')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

             

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                        <button class="btn btn-light">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
      
    </div>
    </div>
</div> 



























 @push('script')
 <script>
     window.addEventListener('close-modal', event => {
         $('#exampleModal').modal('hide');
         $('#exampleModal2').modal('hide');
       
     });
 </script>
 @endpush


</div>
