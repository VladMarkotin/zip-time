 <div>
    


























    @include('livewire.modals')

    <div class="col-md-7 mx-auto rounded ">
        <section class="section-50">
            <div class="container">
                <div class="card-header  border">
                    <h3 class=" heading-line">Notifications <i class="fa fa-bell text-muted"></i> 

                     <div wire:loading wire:target="sortNotifications" wire:key="sortNotifications"><i
                                class="fa fa-spinner fa-spin  ml-2" style="color: #A10000;  font-size: 19px;"></i> </div>
                        <div wire:loading wire:target="readNotification" wire:key="readNotification"><i
                                class="fa fa-spinner fa-spin  ml-2" style="color: #A10000;  font-size: 19px;"></i>
                        </div>

                        <div class="float-end">
                            <a class="btn btn-secondary btn-sm  text-white ">
                                <b> {{ $total }} Notifications [ {{ $count_unread }} Unread {{ $count_read }}
                                    Read ]</b>
                            </a>

                            <a class="btn text-white btn-sm" style="background-color:  #A10000"
                                data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                                aria-controls="collapseExample">
                                Filter
                            </a>
                        </div>

                    </h3>

                </div> 

                <div wire:ignore.self class="collapse" id="collapseExample">

                    <div class="card-header d-flex justify-content-between">

                        <div>
                            <input type="radio" wire:model="sortNotifications" value="read" />Read &nbsp;

                            <input type="radio" wire:model="sortNotifications" value="unread" />Unread&nbsp;

                            <input type="radio" wire:model="sortNotifications" value="all" />All
                        </div>

                        <input type="search" wire:model="search" placeholder="Search" class="  w-25">


                        <div>
                            <span style="float: right">
                                Start: &nbsp; <input type="date" wire:model="startDate">
                                End: &nbsp;<input type="date" wire:model="endDate">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="notification-ui_dd-content">
                    @foreach ($notifications as $notification)
                        <div
                            class="notification-list  {{ $notification->read_at == 0 ? 'notification-list--unread' : '' }}">
                            <a wire:click="readNotification({{ $notification->id }})" class="w-100 text-dark text-decoration-none"  role="button">
                                <div class="notification-list_content">

                                    <div class="notification-list_detail">
                                        <p> <span style=" font-weight: 900;"> {{ $notification->type }}</span></p>
                                        <p class="text-muted"> {{ $notification->data }}</p>
                                        <p class="text-muted"><small>
                                                {{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <div class="notification-list_feature-img">
                                <span class="ml-auto mb-auto">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-light btn-sm rounded"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button class="dropdown-item" type="button"
                                                wire:click="deleteNotification({{ $notification->id }})"
                                                data-bs-toggle="modal" data-bs-target="#deleteNotificationModal"><i
                                                    class="mdi mdi-delete"></i> Delete</button>


                                            <button class="dropdown-item" type="button"
                                                wire:click="editNotification({{ $notification->id }})"
                                                data-bs-toggle="modal" data-bs-target="#editNotificationModal" {{ $notification->type == 'Pusher' ? 'disabled' : ''}}><i
                                                    class="mdi mdi-pen"></i> Edit</button>



                                        </div>
                                    </div>
                                    <br />

                                </span>

                            </div>
                        </div>
                    @endforeach

                </div>

                {{ $notifications->links('livewire.pagination') }}
            </div>
        </section>
    </div>

    @push('script')
        <script>
            window.addEventListener('close-modal', event => {
                $('#editNotificationModal').modal('hide');
                $('#deleteNotificationModal').modal('hide');
            });
        </script>
    @endpush
</div>




