 <div class="card mb-3 ">
     <h5 class="card-header personal-settings-title">Week-end settings </h5>
     <div class="card-body personal-settings-card-body">
         <div class="form-row">
             <div class="form-group col-md-8">
                <div class="personal-settings-label-wrapper">
                    <label class="personal-settings-label" for="weekendDaysState">Set weekend amount per week</label>
                </div>
                 <select id="weekendDaysState" class="form-select personal-settings-select" wire:model="setWeekendDays">
                     {{-- <option selected>Your current days` off number per week is {{ $personal['weekends'] }}</option> --}}
                     <option {{ $isWeekendTaken ? 'disabled' : '' }} value="{{ $default['weekends'] }}">
                        Default *({{ $default['weekends'] }} day off per week)
                    </option>
                     <option {{ $isWeekendTaken ? 'disabled' : '' }} value="2">
                        2 days off per week
                    </option>
                 </select>
             </div>
         </div>
     </div>
 </div>
