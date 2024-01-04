<table class="table">
    <thead class="thead" style="background-color: #CD0000;color:#ffffff">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Task name</th>
          <th scope="col">Type</th>
          <th scope="col">Priority</th>
          <th scope="col">Details</th>
          <th scope="col">Time</th>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      @foreach($savedTasks as $sT)
            
            <tr>
              <td>{{$sT->hash_code}}</td>
              <td>{{$sT->task_name }}</td>
              <td>{{$sT->type}}</td>
              <td>{{$sT->priority}}</td>
              <td>{{$sT->details}}</td>
              <td>{{$sT->time}}</td>
              <td>
                  <button class="btn btn-outline-primary" 
                    data-toggle="modal" data-target="#infoModal" wire:click="getInfo({{ $sT['id'] }})">
                    Info
                  </button>
              </td>
              <td>
                <button class="btn btn-outline-secondary" style="background-color: #f5f4f2;"
                    data-toggle="modal" data-target="#noteModal" wire:click="getNote({{ $sT['id'] }})">
                    Notes
                  </button>
              </td>
              <td>
                <button class="btn btn-outline-secondary" style="background-color: #f5f4f2;"
                    data-toggle="modal" data-target="#updateModal" wire:click="edit({{ $sT['id'] }})">
                    Edit
                  </button>
              </td>
              
              @if(!$sT->status)
                 <td><button wire:click="destroy({{ $sT['id'] }})" class="btn btn-outline-secondary">Enable</button></td>
              @else
                  <td><button wire:click="destroy({{ $sT['id'] }})" class="btn btn-danger">Disable</button></td>
              @endif
            </tr>
           
      @endforeach
   </table>