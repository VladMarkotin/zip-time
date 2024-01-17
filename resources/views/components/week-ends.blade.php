 <div class="card mb-3">
     <h5 class="card-header">Week-end settings </h5>
     <div class="card-body">
         <div class="form-row">
             <div class="form-group col-md-8">
                 <label for="inputState">Set weekend amount per week</label>
                 <select id="inputState" class="form-control" wire:model="setWeekendDays">
                     {{-- <option selected>Your current weekend days a week is {{ $personal['weekends'] }}</option> --}}
                     <option {{ $isWeekendTaken ? 'disabled' : '' }} value="{{ $default['weekends'] }}">Default *(
                         {{ $default['weekends'] }} day a week)</option>
                     <option {{ $isWeekendTaken ? 'disabled' : '' }} value="2">2 days a week</option>
                 </select>
             </div>
         </div>
     </div>

 </div>
