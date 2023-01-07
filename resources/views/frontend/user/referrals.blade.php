
<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Your Referrals" title="Your Referrals" :links="['dashboard' => 'dashboard']"/>
    </x-slot>
    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title fw-normal mb-2">Your Referrals</h4>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </x-slot>
    <div class="nk-block">
        <div class="card card-bordered card-stretch">
            <div class="card-inner-group">
                <div class="card-inner position-relative card-tools-toggle">
                    <div class="card-title-group" data-select2-id="16">
                        <div class="card-tools" data-select2-id="15">
                            
                        </div><!-- .card-tools -->
                        <div class="card-tools mr-n1">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                    <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                </li><!-- li -->
                            </ul><!-- .btn-toolbar -->
                        </div><!-- .card-tools -->
                    </div><!-- .card-title-group -->
                    <x-search-input url="referrals.table" placeholder="Search by name"/>
                </div><!-- .card-inner -->
                <div id="table"></div>
            </div><!-- .card-inner-group -->
        </div><!-- .card -->
    </div>

    <x-slot name="scripts">
        <script>
            NioApp.coms.docReady.push(function(){ 
                ajax("{{ route('referrals.table') }}", 'GET', function(response){
                    $('#table').html(response)
                })
            })
        </script>
    </x-slot>
</x-app-layout>