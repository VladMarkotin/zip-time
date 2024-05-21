<div>
    {{-- {{dd( $config) }} --}}
    <div class="container" style="width:100%; position: relative;">
        @include('livewire.update')
        @include('livewire.info')
        @include('livewire.notes')
        <button class="settings-sidebar-btn" style="display: none"></button>
        <div class="settings-table-wrapper">
            <div class="settings-table-tabs-wrapper sidebar-mobile">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab"
                        aria-controls="v-pills-home" aria-selected="true" wire:ignore>
                        Saved tasks
                    </a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab"
                        aria-controls="v-pills-messages" aria-selected="false" wire:ignore>
                        Personal settings
                    </a>
                </div>
            </div>

            <!--  Saved tasks   -->
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"
                    wire:ignore.self>
                    <x-saved-tasks :savedTasks="$savedTasks" />
                    {{ $savedTasks->links('livewire.pagination') }}
                </div>
                <!--  Saved tasks end  -->
    
                <!--  Personal Settings   -->
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab"
                    wire:ignore.self>
                    <div class="personal-settings-wrapper">
                        <x-timezone :timezones="$timezones" :currentTz="$currentTz" />
    
                        <x-week-ends :personal="$config['personalConfigs']" :default="$config['defaultConfigs']" :isWeekendTaken="$config['isWeekendTaken']"/>
                       
                        <x-daily-plan :personal="$config['personalConfigs']" :default="$config['defaultConfigs']" :isDayPlanCompleted="$config['isDayPlanCompleted']"/>
                    </div>
    
                </div>
                <!--  Personal Settings  end -->
            </div>
        </div>

    </div>
