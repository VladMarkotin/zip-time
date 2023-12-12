<div>
  
<div class="container" style="display:flex; justify-content:space-around;">
   @include('livewire.update')
   @include('livewire.info')
   @include('livewire.notes')
  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" >
    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab"
           aria-controls="v-pills-home" aria-selected="true" wire:ignore>
           Saved tasks
    </a>
    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab"
     aria-controls="v-pills-messages" aria-selected="false" wire:ignore>
        Personal settings
    </a>
    
  </div>
  <div class="tab-content" id="v-pills-tabContent" >
    <div class="tab-pane fade show active" id="v-pills-home"
         role="tabpanel" aria-labelledby="v-pills-home-tab" wire:ignore.self>
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
       {{ $savedTasks->links('livewire.pagination') }}
    </div>
    <div class="tab-pane fade" id="v-pills-profile"
        role="tabpanel" aria-labelledby="v-pills-profile-tab" wire:ignore.self>10</div>
    <div class="tab-pane fade" id="v-pills-messages"
         role="tabpanel" aria-labelledby="v-pills-messages-tab" wire:ignore.self>
        
         <div class="card">
            <h5 class="card-header">Setting timezone</h5>
            <div class="card-body">
              <h5 class="card-title">Choose your timezone for application`s correct work </h5>
              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <div class="form-row">
                <div class="form-group col-md-8">
                  <label for="inputState">Timezone</label>
                  <select id="inputState" class="form-control" wire:model="timezone" wire:change="change()" >
                    @foreach ($timezones as $t)
                      @if($t == $currentTz)
                        <option selected>{{$t}}</option>
                      @else
                        <option >{{$t}}</option>
                      @endif
                    @endforeach
                  </select>
                  
            
                  
                </div>
          </div>    
    </div>
    
  </div>
  
</div>
</div>
