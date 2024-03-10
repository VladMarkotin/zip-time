<!-- Modal -->
<div>
    <div wire:ignore.self class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content notes-update-card">
            <div class="modal-header bg-danger mb-3">
                <h5 class="modal-title" style="color:white;" id="exampleModalLabel">All notes for this saved task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-white bg-danger mb-15 notes-wrapper" style="max-width: 22rem;">
                    <div class="card-header"> 
                        <input type="checkbox" class="custom-control-input" id="allNotes"  wire:model="selectAll" > 
                        <label class="mb-0 label custom-control-label" for="allNotes">Notes</label>
                    </div>
                    <div wire:loading wire:target="getNote" wire:key="getNote"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> loading...</div>
                    
                    <div class="card-body">
                        <div class="center">
                            
                            @php $Sn = 1; @endphp    <!--variable to store task_id-->
                            @foreach ($notes as $savedNotes)
                            <div class="note-wrapper">
                                <span class="note-counter mr-2">
                                    @php echo $Sn++; @endphp. 
                                </span>
                                <input id="note-{{$savedNotes->id}}" class="mr-1 custom-control-input" type="checkbox" wire:model="selectedNotes" value="{{$savedNotes->id}}" >
                                <label for="note-{{$savedNotes->id}}" class="mb-0 label custom-control-label"> {{$savedNotes->note }}</label>
                                <hr>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" style="background: #FCFCFB;color:#747474;" class="btn btn-secondary"
                data-dismiss="modal">Close</button>

                <button type="submit" style="color: #ffffff;" class="btn btn-danger"
                wire:click="clearNotes()">Clear notes</button>  
            </div>
        </div>
    </div>
</div>
</div>

