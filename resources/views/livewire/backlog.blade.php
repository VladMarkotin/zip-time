<div>
    @include('livewire.backlog-modal')
     {{-- <div class="col-md-6 mx-auto rounded">
        <div class="card rounded-5 ">
            <div class="card-header ">
                <h3 style="color: #D40000;">
                    Backlog

                    <button type="button" class="btn btn-primary float-end text-white" data-bs-toggle="modal"
                        data-bs-target="#AddbacklogModal">
                        Add Log
                    </button>

                </h3>
            </div>
            <div class="card-body ">
                <div class="panel ">
                    @foreach ($backlogs as $backlog)
                        <details class="add" id={{ $backlog->id }}>
                            <summary>
                                <ul>
                                    <li class="date"> {{ $backlog->created_at->format('d.m.Y') }}</li>
                                    <li class="title">
                                        @if ($backlog->saved_task_id !== null)
                                            <span style=" font-weight:normal;">
                                                #{{ $backlog->savedTasks->task_name }}-></span>
                                            {{ $backlog->title }}
                                        @else
                                            {{ $backlog->title }}
                                        @endif
                                    </li> 
                                    <li class="actions">

                                         <div class="action-content action{{ $backlog->id }}" style="display: none">
                                            <a class="text-secondary p-1" href="#"
                                                wire:click="editBacklogInfo({{ $backlog->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editBacklogModal">
                                              
                                                <i class="fa fa-pencil-square " ></i>
                                            </a>
                                            <a  class="text-secondary  " href="#"
                                                wire:click="deleteBacklogInfo({{ $backlog->id }})"
                                                data-bs-toggle="modal" data-bs-target="#deleteBacklogModal">
                                               </span><i class="fa fa-trash-o "> <span class="fst-italic"> </i>
                                            </a>
                                        </div>

                                    </li>
                                </ul>
                            </summary>
                            <div class="content">
                                <p style="text-align: justify;">
                                    {{ $backlog->content }}
                                </p>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}

   

    <div class="col-md-6 mx-auto rounded">
        <div class="card rounded-5 ">
            <div class="card-header ">
                <h3 style="color: #D40000;">
                    Backlog

                    <button type="button" class="btn btn-primary float-end text-white" data-bs-toggle="modal"
                        data-bs-target="#AddbacklogModal">
                        Add Log
                    </button>

                </h3>
            </div>
            <div class="card-body ">
                <div class="panel ">
                    @foreach ($backlogs as $backlog)
                        <details class="add" id={{ $backlog->id }}>
                            <summary>
                                <ul>
                                    <li style="color: #D40000; font-size:13px"> {{ $backlog->created_at->format('d.m.Y') }}</li>
                                    <li style="color: #D40000; width:250px; margin-right:4em">
                                        @if ($backlog->saved_task_id !== null)
                                            <span class="text-sm fst-italic">
                                               <small>#</small> {{ $backlog->savedTasks->task_name }}<small>-></small> 
                                            </span>
                                            <span style=" font-weight: 900;">{{ $backlog->title }}</span>
                                        @else
                                        <span style=" font-weight: 900;">{{ $backlog->title }}</span>
                                        @endif
                                    </li> 
                                    <li >

                                         <div class="action-content action{{ $backlog->id }}" style="display: none; margin-right:4em">
                                            <a class="btn btn-light p-1" href="#"
                                                wire:click="editBacklogInfo({{ $backlog->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editBacklogModal">
                                              
                                                <i class="fa fa-pencil p-1 " ></i>
                                            </a>
                                            <a class="btn btn-light p-1" href="#"
                                                wire:click="deleteBacklogInfo({{ $backlog->id }})"
                                                data-bs-toggle="modal" data-bs-target="#deleteBacklogModal">
                                              <i class="fa fa-trash-o p-1 "> <span class="fst-italic"></i></span>
                                            </a>
                                        </div>

                                    </li>
                                </ul>
                            </summary>
                            <div class="content">
                                <p style="text-align: justify;">
                                    {{ $backlog->content }}
                                </p>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



















</div>

{{-- close backlog modal script --}}

@push('script')
    <script>
        window.addEventListener('close-modal', event => {
            $('#AddbacklogModal').modal('hide');
            $('#editBacklogModal').modal('hide');
            $('#deleteBacklogModal').modal('hide');
        });
    </script>
@endpush
