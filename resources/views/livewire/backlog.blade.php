<div>
    @include('livewire.backlog-modal')
    <div class="col-md-7 mx-auto rounded">
        <div class="card rounded-5 ">
            <div class="card-header ">
                <h4 style="color: #D40000;">
                  Backlog
                    <button type="button" class="btn btn-secondary float-end text-white" data-bs-toggle="modal"
                        data-bs-target="#AddbacklogModal">
                        Add Log
                    </button>
                </h4>
            </div>
            <div class="card-body ">
                <div class="panel ">
                    @foreach ($backlogs as $backlog)
                        <details class="add" id={{ $backlog->id }}>
                            <summary>
                                <ul>
                                    <li style="color: #D40000; font-size:12px">
                                        {{ $backlog->created_at->format('d.m.Y') }}</li>
                                    <li style="color: #D40000; width:400px; margin-right:1em">
                                        @if ($backlog->saved_task_id !== null)
                                            <span class="text-sm fst-italic">
                                                <small>#</small> {{ $backlog->savedTasks->task_name }}<small>-></small>
                                            </span>
                                            <span style=" font-weight: 900;">{{ $backlog->title }}</span>
                                        @else
                                            <span style=" font-weight: 900;">{{ $backlog->title }}</span>
                                        @endif
                                    </li>
                                    <li>
                                        <div class="action-content action{{ $backlog->id }}"
                                            style="display: none; margin-right:4em">
                                            <a class="btn btn-outline-secondary  p-0" href="#"
                                                wire:click="editBacklogInfo({{ $backlog->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editBacklogModal">

                                                <i class="fa fa-pencil p-1 "></i>
                                            </a>
                                            <a class="btn btn-outline-secondary  p-0" href="#"
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
