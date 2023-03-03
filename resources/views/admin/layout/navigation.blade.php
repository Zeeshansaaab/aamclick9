<div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="{{route('dashboard')}}" class="logo-link nk-sidebar-logo">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu">
                <em class="icon ni ni-arrow-left"></em>
            </a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-body" data-simplebar>
            <div class="nk-sidebar-content">
                <div class="nk-sidebar-menu">
                    <!-- Menu -->
                    <ul class="nk-menu">
                        <li class="nk-menu-heading">
                            <h6 class="overline-title">Dashboard</h6>
                        </li>
                        <x-nav-link
                            title="Dashboard"
                            link="{{ route('admin.dashboard') }}"
                            icon="icon ni ni-box-view-fill"
                        />
                        @can('view_plans')
                            <li class="nk-menu-heading mt-2">
                                <h6 class="overline-title">Plans</h6>
                            </li>
                            <x-nav-link
                                title="Plans"
                                link="{{ route('admin.plans.index') }}"
                                icon="icon ni ni-sign-waves-alt"
                            />  
                        @endcan
                        {{-- <x-dropdown
                            title="Reports"
                            icon="ni-files"
                            :links="[
                                'Deposit History'      => 'reports.payments, deposited,default',
                                'Withdraw History'     => 'reports.payments, withdrawal,default',
                                'Committee History'    => 'reports.committee',
                                'Installment History'  => 'reports.installments',
                                'Transactions'         => 'reports.transactions',
                                'Reward'               => 'reports.transactions, reward=1&&remark=reward',
                                'Commission'           => 'reports.commissions'
                            ]"
                        /> --}}

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
