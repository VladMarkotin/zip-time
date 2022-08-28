<div>
    @include('livewire.backlog-modal')


    
       

   

    <div class="row ">
        <div class="col-md-7 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>
                       Backlog
                        
                    </h4>
                </div>
                <div class="card-body">
       
    <div id="aspect-content ">
        @foreach ($backlogs as $backlog)
        <div class="aspect-tab shadow-sm">
          <input id="item-18" type="checkbox" class="aspect-input" name="aspect">
          <label for="item-18" class="aspect-label"></label>
          <div class="aspect-content">
              <div class="aspect-info">
                  <div class="chart-pie negative over50">
                      <span class="chart-pie-count">-69</span>
                      <div>
                          <div class="first-fill"></div>
                          <div class="second-fill" style="transform: rotate(249deg)"></div>
                      </div>
                  </div>
                  <span class="aspect-name">{{ $backlog->title }}</span>
              </div>
              {{-- <div class="aspect-stat">
                  <div class="all-opinions">
                      <span class="all-opinions-count"></span>
                      <span>{{ $backlog->created_at->toDateString() }}</span>
                  </div>
                  <div>
                      <span class="positive-count"><i class="fa fa-trash border rounded p-2"></i></span>
                      <span class="neutral-count"><i class="fa fa-edit border rounded p-2"></i></span>
                   
                  </div>
              </div> --}}
          </div>
          <div class="aspect-tab-content">
              <div class="sentiment-wrapper">
                 <div>
                      <div>
                          <div class="negative-count opinion-header">
                              <span style="color: red; font-size:15px">
                                {{ $backlog->created_at->toDateString() }}</span>
                              <span style="font-size:15px">  <a href="#" wire:click="editBacklogInfo({{ $backlog->id }})" data-bs-toggle="modal"
                                data-bs-target="#editBacklogModal">
                                <i class="fa fa-edit text-secondary border p-1"></i>
                            </a>  
                            
                            <a href="#" wire:click="deleteBacklogInfo({{ $backlog->id }})" data-bs-toggle="modal"
                                data-bs-target="#deleteBacklogModal">
                                <i class="fa fa-trash text-secondary border p-1 "></i>
                            </a>
                        
                        </span>
                          </div>
                          <div>
                              <span> 
                                {{ $backlog->content }}
                            </span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        @endforeach
        
          </div>
        </div> 
    </div> 
</div> 
    
</div> 





















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
