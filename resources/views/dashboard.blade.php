<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Dashboard" title="Dashboard"/>
    </x-slot>

    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Dashboard</h4>
                <div class="nk-block-des">
                    <p></p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li>
                        <a href="#" class="btn btn-primary"><span>Deposit</span> <em class="icon ni ni-arrow-long-right"></em></a>
                    </li>
                    <li><a href="#" class="btn btn-white btn-light"><span>Buy / Sell</span> <em class="icon ni ni-arrow-long-right d-none d-sm-inline-block"></em></a></li>
                    <li class="opt-menu-md dropdown">
                        <a href="#" class="btn btn-white btn-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-setting"></em></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="link-list-opt no-bdr">
                                <li><a href="#"><em class="icon ni ni-coin-alt"></em><span>Curreny Settings</span></a></li>
                                <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </x-slot>

    <div class="py-12">
        <div>
            <div>
                <div>
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
