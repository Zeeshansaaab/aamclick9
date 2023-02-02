<x-guest-layout>
{{-- slider --}}
    <div id="carouselExFade" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ getFile('images/slides/slide1.jpeg') }}" class="d-block w-100" alt="carousel">
            </div>
            <div class="carousel-item">
                <img src="{{ getFile('images/slides/slide2.jpeg') }}" class="d-block w-100" alt="carousel">
            </div>
            <div class="carousel-item">
                <img src="{{ getFile('images/slides/slide3.jpeg') }}" class="d-block w-100" alt="carousel">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExFade" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExFade" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    {{-- sliderend --}}
    <h3>
        How AAM CLICK WORKS
    </h3>
</x-guest-layout>
