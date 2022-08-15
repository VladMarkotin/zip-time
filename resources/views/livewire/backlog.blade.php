<div>
    @include('livewire.backlog-modal')
    <div class="backlog-container">
        <div class="backlog-wrapper">
            <div class="backlog-header">
                <h4>Backlog</h4>
            </div>

            <div class="backlog-content">

                @foreach ($backlogs as $backlog)
                    <div class="content-header">
                        <div class="content-date">
                            <p> {{ $backlog->created_at }}</p>
                        </div>
                        <div class="content-title">
                            <h5>
                                @if ($backlog->saved_task_id !== null)
                                    #{{ $backlog->savedTasks->task_name }}->
                                    {{ $backlog->title }}
                            </h5>
                        @else
                            <h5>{{ $backlog->title }}</h5>
                @endif
            </div>
            <div class="content-action">

                <a href="#" wire:click="editBacklogInfo({{ $backlog->id }})" data-bs-toggle="modal"
                    data-bs-target="#editBacklogModal">
                    <i class="fa fa-edit text-success" style="padding:0px 5px;"></i>
                </a>

                <a href="#" wire:click="deleteBacklogInfo({{ $backlog->id }})" data-bs-toggle="modal"
                    data-bs-target="#deleteBacklogModal">
                    <i class="fa fa-trash text-danger" style="padding:0px 5px;"></i>
                </a>
            </div>
        </div>
        <div class="content-text">
            <p>
            {{ $backlog->content }}
            </p>
        </div>
        @endforeach
    </div>

         @forelse ($backlogTitles as $backlogTitle)
            <div class="backlog-title">
                <a wire:click="getBacklogContentByTitle({{ $backlogTitle->id }})">

                <h5>{{ $backlogTitle->title }}</h5>
            </a>
            </div>      
        @empty
            <div class="backlog-title">
                <h5>No Backlogs to display</h5>
            </div>
        @endforelse
    </div>
</div>

{{-- modal pop up --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddbacklogModal">
    Launch demo modal
</button>

{{-- close backlog modal --}}

@push('script')
    <script>
        window.addEventListener('close-modal', event => {
            $('#AddbacklogModal').modal('hide');
            $('#editBacklogModal').modal('hide');
            $('#deleteBacklogModal').modal('hide');
        });
    </script>
@endpush
