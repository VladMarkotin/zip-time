<!-- Modal -->
<div wire:ignore.self class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger mb-3">
                <h5 class="modal-title" style="color:white;" id="exampleModalLabel">All notes for this saved task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-white bg-danger mb-15" style="max-width: 18rem;">
                    <div class="card-header"> <input type="checkbox"  wire:model="selectAll" > Notes</div>
                    <div wire:loading wire:target="getNote" wire:key="getNote"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> loading...</div>
                    
                    <div class="card-body">
                        <div class="center">
 
                            @php $Sn = 1; @endphp    <!--variable to store task_id-->
                            @foreach ($notes as $savedNotes)
                            
                           <input type="checkbox" wire:model="selectedNotes" value="{{$savedNotes->id}}" >
                              @php echo $Sn++; @endphp. 
                              <b> {{$savedNotes->note }}</b>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" style="color: #ffffff;" class="btn btn-danger"
                    wire:click="clearNotes()">Clear notes</button>  
               
               
                <button type="button" style="background: #FCFCFB;color:#747474;" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
