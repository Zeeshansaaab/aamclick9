<form action="{{ route('installments.store') }}" method="POST" enctype="multipart/form-data" data-form="ajax-form">
    <div class="row">
        <div class="col-12 mt-1">
            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <div class="form-group">
                <label class="form-label" for="phone">Phone</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="03001212123">
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="email" name="email" placeholder="john@gmail.com">
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <div class="form-group">
                <label class="form-label" for="amount">Amount</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="amount" name="amount" placeholder="1000">
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <div class="form-group">
                <label class="form-label" for="image">Image</label>
                <div class="form-control-wrap">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="image" accept=".jpg,.png,.jpeg">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <div class="form-group">
                <label class="form-label" for="address">Address</label>
                <div class="form-control-wrap">
                    <textarea class="form-control" id="address" name="address" ></textarea>
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <button class="btn btn-primary float-right" type="submit">Submit</button>
        </div>
        
    </div>
</form>