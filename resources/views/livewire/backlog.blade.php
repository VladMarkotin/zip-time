<div>
    @include('livewire.backlog-modal')
    <div class="col-md-6 mx-auto rounded">
        <div class="card rounded-5 ">
            <div class="card-header">
                <h3 style="color: #f93b3b;">
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
                        <details >
                            <summary>
                                <ul>
                                    <li class="date"> {{ $backlog->created_at->format('d.m.Y') }}</li>
                                    <li class="title">
                                        @if ($backlog->saved_task_id !== null)
                                            #{{ $backlog->savedTasks->task_name }}->
                                            {{ $backlog->title }}
                                        @else
                                            {{ $backlog->title }}
                                        @endif
                                    </li>
                                    <li class="actions"  >
                                        <div class="action-content ">
                                            <a href="#" wire:click="editBacklogInfo({{ $backlog->id }})"
                                                data-bs-toggle="modal" data-bs-target="#editBacklogModal">
                                                <i class="fa fa-square text-secondary  "></i>
                                            </a>
                                            <a href="#" wire:click="deleteBacklogInfo({{ $backlog->id }})"
                                                data-bs-toggle="modal" data-bs-target="#deleteBacklogModal">
                                                <i class="fa fa-trash text-secondary "></i>
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
