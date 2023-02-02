<main style="width: 47%; margin:auto;">
    <div class="nk-block" style="height: 50vh;">
        <div class="card card-bordered text-light is-dark h-100">
            <div class="card-inner">
                <div class="nk-wg7">
                    <h5 class="ff-base fw-medium">Committee Number</h5>
                    <span id="ranNum" class="text-soft"></span>
                    @if(!$plan->committee_number)
                    <button style="position: relative; top: 26vh;" class="btn btn-primary text-center text-white" id="generate">Generate</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>