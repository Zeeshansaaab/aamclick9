<x-guest-layout :header="false">
    <div class="nk-block-content nk-error-ld text-center">
        <img class="nk-error-gfx" src="/images/svg/error-504.svg" alt="">
        <div class="wide-xs mx-auto">
            <h3 class="nk-error-title">Internal Server Error</h3>
            <p class="nk-error-text">We are very sorry for inconvenience. 
                It looks like some how our server has internal error.</p>
            <a href="{{route('dashboard')}}" class="btn btn-lg btn-primary mt-2">Back To Home</a>
        </div>
    </div>
</x-guest-layout>