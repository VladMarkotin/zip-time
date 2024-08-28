<div class="card mb-3 ">
    <h5 class="card-header personal-settings-title">Daily Plan Settings </h5>
    <div class="card-body personal-settings-card-body">
        <div class="form-row">
            {{-- <div class="form-group col-md-8">
                <label for="inputState">Set day`s plan minimal mark <br> Min mark can not be less than
                    {{ $default['minFinalMark'] }}</label>
                <form wire:submit.prevent="minFinalMark">
                    <div class=" d-flex">
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">Mark:</label>
                        </div>
                        <div class="col-auto d-flex">
                            <input type="text" class="form-control mr-1" wire:model="minMark">
                            <button type="submit" class="btn btn-primary"
                                {{ $isDayPlanCompleted ? 'disabled' : '' }}>Set</button>
                        </div>

                    </div>
                </form>
            </div> --}}

            <div class="form-group col-md-8">
                <div class="personal-settings-label-wrapper">
                    <label class="personal-settings-label" for="minJobAmountState">Set day`s plan minimal required jobs amount</label>
                </div>
                <form wire:submit.prevent="minmark">
                    <select id="minJobAmountState" class="form-select personal-settings-select" wire:model="minJobAmount">
                        <option value="">Default *( {{ $default['minRequiredTaskQuantity'] }} tasks per day)
                        </option>
                        <option value="3">3 tasks per day</option>
                        <option value="4">4 tasks per day</option>
                        <option value="5">5 tasks per day</option>
                        <option value="6">6 tasks per day</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>
