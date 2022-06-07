<div class="container" style="display:flex; justify-content:space-around;">
   @include('livewire.update')
   @include('livewire.info')
   @include('livewire.notes')
  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab"
           aria-controls="v-pills-home" aria-selected="true">
           Saved tasks
    </a>
    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" 
        role="tab" aria-controls="v-pills-profile" aria-selected="false">
        Statistic
    </a>
    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab"
     aria-controls="v-pills-messages" aria-selected="false">
        Personal settings
    </a>
    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab"
        aria-controls="v-pills-settings" aria-selected="false">I don`t know yet :)</a>
  </div>
  <div class="tab-content" id="v-pills-tabContent" >
    <div class="tab-pane fade show active" id="v-pills-home"
         role="tabpanel" aria-labelledby="v-pills-home-tab">
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
                        data-toggle="modal" data-target="#notesModal" wire:click="getNotes({{ $sT['id'] }})">
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
       {{ $savedTasks->links() }}
    </div>
    <div class="tab-pane fade" id="v-pills-profile"
        role="tabpanel" aria-labelledby="v-pills-profile-tab">10</div>
    <div class="tab-pane fade" id="v-pills-messages"
         role="tabpanel" aria-labelledby="v-pills-messages-tab">2</div>
    <div class="tab-pane fade" id="v-pills-settings"
         role="tabpanel" aria-labelledby="v-pills-settings-tab">3</div>
  </div>
  
</div>