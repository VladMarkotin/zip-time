<div class="card mb-3">
    <h5 class="card-header">Daily Plan Settings </h5>
    <div class="card-body">
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
                <label for="inputState">Set day`s plan minimal required jobs amount</label>
                <form wire:submit.prevent="minmark">
                    <div class=" d-flex">
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">Amount:</label>
                        </div>

                        <div class="col-auto ">
                            <select id="inputState" class="form-control" wire:model="minJobAmount">
                                <option value="">Default *( {{ $default['minRequiredTaskQuantity'] }} day a week)
                                </option>
                                <option value="3">3 tasks</option>
                                <option value="4">4 tasks</option>
                                <option value="5">5 tasks</option>
                                <option value="6">6 tasks</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
