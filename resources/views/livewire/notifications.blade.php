<div>
    @include('livewire.modals')

    <div class="col-md-7 mx-auto rounded ">
        <section class="section-50">
            <div class="container">
                <div class="card-header border">
                    <h4 class=" heading-line">Notifications <i class="fa fa-bell text-muted"></i>

                        <div wire:loading wire:target="sortNotifications" wire:key="sortNotifications"><i
                                class="fa fa-spinner fa-spin  ml-2" style="color: #A10000;  font-size: 19px;"></i> </div>
                        <div wire:loading wire:target="readNotification" wire:key="readNotification"><i
                                class="fa fa-spinner fa-spin  ml-2" style="color: #A10000;  font-size: 19px;"></i>
                        </div>

                        <div class="float-end">
                            <a class="btn text-white btn-sm float-end" style="background-color:  #A10000"
                                data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                                aria-controls="collapseExample">

                                <span class="filter mx-2">
                                    <b>
                                        {{ $total }} Notifications [{{ $count_unread }} Unread
                                        {{ $count_read }}
                                        Read]
                                    </b>
                                </span>

                                <i class="bi bi-funnel-fill"></i>
                            </a>
                        </div>

                    </h4>
                </div>

                <div wire:ignore.self class="collapse" id="collapseExample">

                    <div class="card-header d-flex justify-content-between ">

                        <div class="d-flex mt-2 "  role="button">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault1" wire:model="sortNotifications" value="all"  role="button">
                                <label class="form-check-label" for="flexRadioDefault1"  role="button">
                                    all
                                </label>
                            </div>

                            <div class="form-check ml-3" role="button">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault2" wire:model="sortNotifications" value="read"  role="button">
                                <label class="form-check-label" for="flexRadioDefault2"  role="button">
                                    read
                                </label>
                            </div>

                            <div class="form-check ml-3" role="button" >
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault3" wire:model="sortNotifications" value="unread"  role="button">
                                <label class="form-check-label" for="flexRadioDefault3"  role="button">
                                    unread
                                </label>
                            </div>
                        </div>


                        <input type="search" wire:model="search" placeholder="Search" class=" form-control w-25">


                        <div>
                            <span class="d-flex">
                                <input type="date" class="form-control " wire:model="startDate">
                                <input type="date" class="form-control" wire:model="endDate">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="notification-ui_dd-content">
                    @foreach ($notifications as $notification)
                        <div @class(['notification-list ', 'notification-list--unread' =>  $notification->read_at == 0 ])>
                            <a wire:click="readNotification({{ $notification->id }})"
                                class="w-100 text-dark text-decoration-none" role="button">
                                <div class="notification-list_content">

                                    <div class="notification-list_detail">
                                        <p> <span style=" font-weight: 900;"> {{ $notification->type }}</span></p>
                                        <p class="text-muted text-justify"> {{ $notification->data }}</p>
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


                                            <button  type="button"
                                                wire:click="editNotification({{ $notification->id }})"
                                                data-bs-toggle="modal" data-bs-target="#editNotificationModal"

                                              @class(['dropdown-item', 'd-none' => $notification->broadcast_type == 'public'])>
                                              <i class="mdi mdi-pen"></i>
                                               Edit
                                            </button>
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
