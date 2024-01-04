<div>

    <div class="container" style="display:flex; justify-content:space-around; width:100%">
        @include('livewire.update')
        @include('livewire.info')
        @include('livewire.notes')
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab"
                aria-controls="v-pills-home" aria-selected="true" wire:ignore>
                Saved tasks
            </a>
            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab"
                aria-controls="v-pills-profile" aria-selected="false"wire:ignore>
                Statistic
            </a>
            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab"
                aria-controls="v-pills-messages" aria-selected="false" wire:ignore>
                Personal settings
            </a>

        </div>

        <!--  Saved tasks   -->
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"
                wire:ignore.self>


                <x-saved-tasks :savedTasks="$savedTasks" />


                {{ $savedTasks->links('livewire.pagination') }}
            </div>
            <!--  Saved tasks end  -->



            <!--  static   start-->
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"
                wire:ignore.self>10</div>

            <!--  static end -->





            <!--  Personal Settings   -->
            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab"
                wire:ignore.self>

           
                   <x-timezone :timezones="$timezones" :currentTz="$currentTz" />

            <x-week-ends  />
  
           








            </div>



            <!--  Personal Settings  end -->


        </div>
      </div>
