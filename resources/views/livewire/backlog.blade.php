<div>
    @include('livewire.modals')

    <div class="col-md-7 mx-auto rounded">

        <div class="card rounded-5 ">
            <div class="card-header ">
                <h3 class="text-danger fw-semibold">
                    Backlog
               
                </h3>
            </div>

            <div class="card-body ">
                <div class="panel pt-3">
                    @forelse ($backlogs as $backlog)
                        <details class="show_edit_delete" id={{ $backlog->id }}>
                            <summary>
                                <ul>
                                    <li class="date">
                                        {{ $backlog->created_at->format('d.m.Y') }}
                                    </li>
                                    <li class="title">
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
                                        <div class="action-content action{{ $backlog->id }} "
                                            style="display: none; margin-right:5em">
                                            <a class="btn btn-outline-secondary  p-0" href="#"
                                                wire:click="editBacklogInfo({{ $backlog->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editBacklogModal">

                                                <i class="fa fa-pencil p-1 "> Edit</i>
                                            </a>
                                            <a class="btn btn-outline-secondary  p-0" href="#"
                                                wire:click="deleteBacklogInfo({{ $backlog->id }})"
                                                data-bs-toggle="modal" data-bs-target="#deleteBacklogModal">
                                                <i class="fa fa-trash p-1 "> <span class="text-danger "> delete</span>
                                                </i>

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
                        @empty
                        <span>There are no notes here yet. Maybe it`s time to create the first one?</span>
                        @endforelse
                </div>
            </div>
        </div>

    </div>
    {{ $backlogs->links('livewire.pagination') }}
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

</div>


