   <div class="card mb-3 ">
       <h5 class="card-header personal-settings-title">Timezone settings </h5>
       <div class="card-body personal-settings-card-body">
           <h5 class="card-title" style="text-align: center">Choose your timezone for application`s correct work </h5>
           <p class="card-text" style="text-align: center">If you haven't closed your plan by 11:59 p.m., Quipl will do so automatically.</p>
           <div class="form-row" style="margin-top: 15px">
               <div class="form-group col-md-8">
                <div class="personal-settings-label-wrapper">
                    <label class="personal-settings-label" for="timezoneState">Timezone</label>
                </div>
                   <select id="timezoneState" class="form-select personal-settings-select" wire:model="timezone">
                       @foreach ($timezones as $t)
                           @if ($t == $currentTz)
                               <option selected>{{ $t }}</option>
                           @else
                               <option>{{ $t }}</option>
                           @endif
                       @endforeach
                   </select>
               </div>
           </div>
       </div>

   </div>
