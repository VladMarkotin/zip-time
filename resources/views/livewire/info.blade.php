<!-- Modal -->
<div wire:ignore.self class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header bg-danger mb-3">
                <h5 class="modal-title" style="color:white;"  id="exampleModalLabel">Info about saved task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">Statistics</div>
                    <div wire:loading>Loading info..</div>
                    <div class="card-body">
                   {{-- <!--<h5 class="card-title">Danger card title</h5>--> --}}
                        <div class="center">
                            @foreach($info as $key => $v)
                            <div>{{$key}}: {{$info[$key]}}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" style="background: #FCFCFB;color:#747474;" class="btn btn-secondary" 
                        data-dismiss="modal">Close</button>
            </div>
       </div>
    </div>
</div>