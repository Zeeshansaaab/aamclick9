
<x-app-layout>
    <x-slot name="title">Transactions</x-slot>

    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Transactions" title="Transactions" :links="['dashboard' => 'dashboard']"/>
    </x-slot>
    <x-slot name="header">

    </x-slot>
    <div class="nk-block">
        <div class="card card-bordered card-stretch">
            <div class="card-inner-group">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h5 class="title">Transactions</h5>
                        </div>
                        <div class="card-tools mr-n1">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                    <a href="#" class="search-toggle toggle-search btn btn-icon" data-target="search"><em class="icon ni ni-search"></em></a>
                                </li>
                            </ul><!-- .btn-toolbar -->
                        </div>
                        <x-search-input url="{{ route('reports.transactions.table') }}?remark={{request()->query('remark')}}&&reward={{request()->query('reward')}}" placeholder="Search by trx or remark"/>
                    </div><!-- .card-title-group -->
                </div><!-- .card-inner -->

                <div id="table">

                </div>
            </div><!-- .card-inner-group -->
        </div><!-- .card -->
    </div>

    <x-slot name="scripts">
        <script>
            NioApp.coms.docReady.push(function(){
                ajax("{{ route('reports.transactions.table') }}?remark={{request()->query('remark')}}&&reward={{request()->query('reward')}}", 'GET', function(response){
                    $('#table').html(response)
                })
            })
        </script>
    </x-slot>
</x-app-layout>
