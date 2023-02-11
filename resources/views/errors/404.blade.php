<x-guest-layout :header="false">
    <div class="nk-block-content nk-error-ld text-center">
        <img class="nk-error-gfx" src="/images/svg/error-404.svg" alt="">
        <div class="wide-xs mx-auto">
            <h3 class="nk-error-title">Oops! Why you’re here?</h3>
            <p class="nk-error-text">We are very sorry for inconvenience. It looks like you’re try to access a page that either has been deleted or never existed.</p>
            <a href="{{route('dashboard')}}" class="btn btn-lg btn-primary mt-2">Back To Home</a>
        </div>
    </div>
</x-guest-layout>