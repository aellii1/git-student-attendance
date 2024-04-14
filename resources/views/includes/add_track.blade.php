<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
            <h5 class="modal-title"><b>Add New Track</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>

            
            <div class="modal-body">

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('tracks.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="track">Track</label>
                            <input type="text" class="form-control" id="track" name="track" placeholder="Enter Track | e.g. Academic, TVL" autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="strand">Strand</label>
                            <input type="text" class="form-control" id="strand" name="strand" placeholder="Enter Strand | e.g. STEM, ABM, HUMMS, ETC." id="strand" name="strand"
                                required />
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-danger waves-effect m-l-5" data-dismiss="modal">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</div>
</div>