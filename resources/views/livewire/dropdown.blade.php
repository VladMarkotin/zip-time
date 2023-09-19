<div>
    @auth
        <div class="col-lg-3 h-50 notification-wrapper  bg-white p-0 overflow-auto" wire:ignore.self>
            <div class="box-title border-bottom ">
                <h6 class="fw-bold p-2 ">Notifications


                    <span class="float-end"><input type="checkbox" wire:model="unread" value="all" >
                        Unread</span>
                </h6>

         
                
                </div>
        <div class="box  bg-white " >

                
                <div class="box-body p-0 ">

                    @foreach ($notifications as $notification)
                        <div class="p-2 d-flex align-items-center border-bottom notification-dropdown-item ">
                            <div class="mr-3 pl-2" role="button" wire:click="readNotification( {{ $notification->id }})">
                           
                                <div @class([
                                    'text-justify',
                                    'font-weight-bold' => $notification->read_at == 0,
                                ])>
                                    {{ $notification->data }}
                                </div>
                            </div>
                            <span class="ml-auto mb-auto">
                                <div class="btn-group">
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

            <div class=" border-bottom p-2 bg-light  ">
                <a href="{{ url('notifications') }}" class="text-decoration-none">
                     <h6 class="text-center font-weight-bold" role="button">View all</h6>
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
                                 <strong>Notification`s type:</strong>
                                 <input type="text" class="form-control"
                                     placeholder='Придумайте тип напоминания (например "Важное")' wire:model="type">
                                 @error('type')
                                     <span class="error text-danger">{{ $message }}</span>
                                 @enderror
                             </div>

                         </div>

                         <div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                 <strong>Notification`s text:</strong>
                                 <input type="text" class="form-control" placeholder="Notification`s text"
                                     wire:model="data">
                                 @error('data')
                                     <span class="error text-danger">{{ $message }}</span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                 <strong>Notification`s date:</strong>
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
