<div>
    @include('livewire.modals')

    <div class="col-md-8 mx-auto rounded backlog_wrapper">

        <div class="card rounded-5">
            <div class="card-header ">
                <h3 class="text-danger fw-semibold">
                    Backlog
                </h3>
            </div>

            <div class="card-body ">
                <div class="panel pt-3">
                    @forelse ($backlogs as $backlog)
                        <details class="show_edit_delete" id={{ $backlog->id }} >
                            <summary class="backlog_item-header">
                                <ul>
                                    <li class="date backlog_date">
                                        {{ $backlog->created_at->format('d.m.Y') }}
                                    </li>
                                    <li class="title backlog_title">
                                        @if ($backlog->saved_task_id !== null)
                                            <p class="backlog_code-wrapper">
                                                <small>#</small>{{ $backlog->savedTasks->task_name }}
                                            </p>
                                            <p class="backlog_title-text" style=" font-weight: 900;">{{ $backlog->title }}</p>
                                        @else
                                            <p class="backlog_code-wrapper"></p>
                                            <p class="backlog_title-text" style=" font-weight: 900;">{{ $backlog->title }}</p>
                                        @endif
                                    </li>
                                </ul>
                            </summary>
                            <div class="content backlog_item-body">
                                <p style="text-align: justify;" class="backlog_item-body-text">
                                    {{ $backlog->content }}
                                </p>
                                <div class="action-content action{{ $backlog->id }} backlog_item-body-buttonsWrapper"
                                    style="display: none;">
                                    <a class="backlog_customBtn backlog_edit-button" href="#"
                                        wire:click="editBacklogInfo({{ $backlog->id }})" data-bs-toggle="modal"
                                        data-bs-target="#editBacklogModal">
                                        <span>Edit</span>
                                    </a>
                                    <a class="backlog_customBtn backlog_delete-button" href="#"
                                        wire:click="deleteBacklogInfo({{ $backlog->id }})"
                                        data-bs-toggle="modal" data-bs-target="#deleteBacklogModal">
                                        <span>Delete</span>
                                    </a>
                                </div>
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


