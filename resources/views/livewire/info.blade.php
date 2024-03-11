<!-- Modal -->
<div>
<div wire:ignore.self class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header bg-danger mb-3">
                <h5 class="modal-title" style="color:white;"  id="exampleModalLabel">Info about saved task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">×</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center align-items-center statistic-wrapper">

                <div class="card text-white bg-danger mb-3" style="width: 90%">
                <div class="card-header text-center statistic-title">Statistics</div>
                    <div wire:loading>Loading info..</div>
                    <div class="card-body p-1">
                   {{-- <!--<h5 class="card-title">Danger card title</h5>--> --}}
                        <div class="statistic-content">
                            @foreach($info as $key => $v)
                            <div class="statisic-item-key">{{$key}}:</div>
                            <div class="statisic-item-value">{{$info[$key]}}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-start align-items-center">
                <button type="button" style="background: #FCFCFB;color:#747474;" class="btn btn-secondary" 
                        data-dismiss="modal">Close</button>
            </div>
       </div>
    </div>
</div>
</div>