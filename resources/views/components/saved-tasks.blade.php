<div class="saved-task-container">
    <div class="table-container">
        <div class="saved-task-table-wrapper">
            <table class="table table-bordered border-primary saved-tasks-table">
                <thead class="thead" style="background-color: #A10000;color:#ffffff">
                    <tr class="saved-tasks-table-head">
                        <th scope="col" class="table-head-code">#</th>
                        <th scope="col" class="table-head-name">Task name</th>
                        <th scope="col" class="table-head-type">Type</th>
                        <th scope="col" class="table-head-priority">Priority</th>
                        <th scope="col" class="table-head-time">Time</th>
                        <th scope="col" class="table-head-actions" style="text-align: center">Actions</th>
                    </tr>
                </thead>
                @foreach ($savedTasks as $sT)
                    <tr @if($sT->status == 0) class="disabled-saved-task" @endif>
                        <td class="col-1 saved-task-code">{{ $sT->hash_code }}</td>
                        <td class="col-4 saved-task-name">{{ $sT->task_name }}</td>
                        <td class="col-1 saved-task-type">{{ $sT->type }}</td>
                        <td class="col-1 saved-task-priority">{{ $sT->priority }}</td>
                        <td class="col-1 saved-task-time">{{ $sT->time }}</td>
                        <td class="col-4 saved-task-actions" >
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
        </div>
    </div>
</div>
