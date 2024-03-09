<table class="table table-bordered border-primary saved-tasks-table">
    <thead class="thead" style="background-color: #A10000;color:#ffffff">
        <tr class="saved-tasks-table-head">
            <th scope="col">#</th>
            <th scope="col">Task name</th>
            <th scope="col">Type</th>
            <th scope="col">Priority</th>
            <th scope="col">Time</th>
            <th scope="col" style="text-align: center">Actions</th>
        </tr>
    </thead>
    @foreach ($savedTasks as $sT)
        <tr >
            <td class="col-1">{{ $sT->hash_code }}</td>
            <td class="col-4">{{ $sT->task_name }}</td>
            <td class="col-1">{{ $sT->type }}</td>
            <td class="col-1">{{ $sT->priority }}</td>
            <td class="col-1">{{ $sT->time }}</td>
            <td class="col-4" >
                <div class="buttons-wrapper">
                    <div>
                        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#infoModal"
                            wire:click="getInfo({{ $sT['id'] }})">
                            Info
                        </button>
        
                        <button class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#noteModal" wire:click="getNote({{ $sT['id'] }})">
                            Notes
                        </button>
        
                        <button class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#updateModal" wire:click="edit({{ $sT['id'] }})">
                            Edit
                        </button>
                    </div>
    
                    @if (!$sT->status)
                        <button wire:click="destroy({{ $sT['id'] }})" class="btn btn-outline-secondary" style="min-width: 75px">Enable</button>
                    @else
                        <button wire:click="destroy({{ $sT['id'] }})" class="btn btn-danger" style="min-width: 75px">Disable</button>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
</table>
