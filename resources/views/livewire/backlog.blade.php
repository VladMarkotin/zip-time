<div>
    <div class="backlog-container">
        <div class="backlog-wrapper">
            <div class="backlog-header">
                <h4>Backlog</h4>
            </div>

            <div class="backlog-content">
                <div class="content-header">
                    <div class="content-date">
                        <p> 20-11-2022</p>
                    </div>
                    <div class="content-title">
                        <h5>TITLE</h5>
                    </div>
                    <div class="content-action">

                        <i class="fa fa-edit text-success" style="padding:0px 5px;"></i>


                        <i class="fa fa-trash text-danger" style="padding:0px 5px;"></i>

                    </div>
                </div>
                <i class="bi-trash"></i>
                <div class="content-text">
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book.Lorem Ipsum is simply dummy text of the
                        printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                        since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
                        specimen book.
                    </p>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book.Lorem Ipsum is simply dummy text of the
                        printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                        since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
                        specimen book.
                    </p>
                </div>
            </div>
            <a href="">
                <div class="backlog-title">
                    <h5>TITLE</h5>
                </div>
            </a>
            <div class="backlog-title">
                <h5>No Backlogs to display</h5>
            </div>




        </div>
    </div>



    {{-- modal pop up --}}


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#backlogModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="backlogModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"> Add useful thoughts or whatever you want here</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="storeBacklogInfo">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="recipient-name" wire:model.defer="title">
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Choose a saved task that connected with
                                your thoughts</label>
                            <select name="" id="" class="form-control">
                                <option value="">Tasks</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Content:</label>
                            <textarea class="form-control" id="message-text" wire:model.defer="content" rows="5"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Log</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>


    {{-- close backlog modal --}}

    @push('script')
        <script>
            window.addEventListener('close-modal', event => {
                $('#backlogModal').modal('hide');

            });
        </script>
    @endpush

