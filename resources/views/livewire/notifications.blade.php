<div>
    @include('livewire.modals')
    {{-- <div class="col-md-7 mx-auto rounded">
        <div class="card rounded-5 ">
            <div class="card-header ">
                <h3 class=" fw-semibold" style="color:  #A10000">
                    Notifications
                    <a class="btn float-end text-white" data-bs-toggle="collapse" style="background-color:  #A10000"
                        href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Filter
                    </a>
                </h3>
            </div>
            <div wire:ignore.self class="card-header collapse background white" id="collapseExample">

                <input type="radio" wire:model="sortNotifications" value="read" />Read &nbsp;&nbsp;

                <input type="radio" wire:model="sortNotifications" value="unread" />Unread&nbsp;&nbsp;

                <input type="radio" wire:model="sortNotifications" value="all" />All

                <span style="float: right">
                    start: &nbsp; <input type="date" wire:model="startDate">
                    end: &nbsp;<input type="date" wire:model="endDate">
                </span>
            </div>
            <div class="card-body ">
                <div class="panel pt-3">
                    @foreach ($notifications as $notification)
                        <details class="show_edit_delete" id={{ $notification->id }}>
                            <summary>
                                <ul>
                                    <li class="date">
                                        {{ $notification->created_at->format('d.m.Y') }}
                                    </li>
                                    <li class="title">

                                        <span style=" font-weight: 900;">{{ $notification->type }}</span>

                                    </li>
                                    <li>
                                        <div class="action-content action{{ $notification->id }} "
                                            style="display: none; margin-right:5em">
                                            <a class="btn btn-outline-secondary  p-0" href="#"
                                                wire:click="editNotification({{ $notification->id }})"
                                                data-bs-toggle="modal" data-bs-target="#editNotificationModal">

                                                <i class="fa fa-pencil p-1 "> Edit</i>
                                            </a>
                                            <a class="btn btn-outline-secondary  p-0" href="#"
                                                wire:click="deleteNotification({{ $notification->id }})"
                                                data-bs-toggle="modal" data-bs-target="#deleteNotificationModal">
                                                <i class="fa fa-trash p-1 "> <span class="text-danger "> delete</span>
                                                </i>

                                            </a>
                                        </div>

                                    </li>
                                </ul>
                            </summary>
                            <div class="content">
                                <p style="text-align: justify;">
                                    {{ $notification->data }}
                                </p>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}




 
    
    <section class="section-50">
        <div class="container">
            <h3 class="m-b-50 heading-line">Notifications <i class="fa fa-bell text-muted"></i></h3>
    
            <div class="notification-ui_dd-content">



             @foreach ($notifications as $notification)
             
                <div class="notification-list  {{$notification->read_at == 0 ?'notification-list--unread' : ''}}">
                    <div class="notification-list_content">
                       
                        <div class="notification-list_detail">
                            <p><b>  {{ $notification->type }}</b></p>
                            <p class="text-muted">  {{ $notification->data }}</p>
                            <p class="text-muted"><small> {{Carbon\Carbon::parse($notification->notification_date)->diffForHumans()}}</small></p>
                        </div>
                    </div>
                    <div class="notification-list_feature-img">
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"  wire:click="deleteNotification({{ $notification->id }})"  data-bs-toggle="modal" data-bs-target="#deleteNotificationModal"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-pen"  wire:click="editNotification({{ $notification->id }})"  data-bs-toggle="modal" data-bs-target="#editNotificationModal"></i> Edit</button>
                                </div>
                            </div>
                            <br />
                    
                        </span>
                    </div>
                </div>
           
                @endforeach            

            </div>
    
            <div class="text-center">
                <a href="#!" class="dark-link">Load more activity</a>
            </div>
    
        </div>
    </section>

    @push('script')
        <script>
            window.addEventListener('close-modal', event => {

                $('#editNotificationModal').modal('hide');
                $('#deleteNotificationModal').modal('hide');
            });
        </script>
    @endpush
</div>

