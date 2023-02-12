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
                            link="{{ route('dashboard') }}"
                            icon="icon ni ni-box-view-fill"
                        />
                        <li class="nk-menu-heading mt-2">
                            <h6 class="overline-title">Plans</h6>
                        </li>
                        <x-nav-link
                            title="Plans"
                            link="{{ route('plans.index') }}"
                            icon="icon ni ni-sign-waves-alt"
                        />
                        <x-nav-link
                            title="Committee Plans"
                            link="{{ route('committees.index') }}"
                            icon="icon ni ni-folders-fill"
                        />
                        <li class="nk-menu-heading mt-2">
                            <h6 class="overline-title">Referrals</h6>
                        </li>
                        <x-dropdown
                            title="Referrals"
                            icon="ni-users-fill"
                            :links="[
                                'Level 1 Referrals' => 'referrals, 1', 
                                'Level 2 Referrals' => 'referrals, 2', 
                                'Level 3 Referrals' => 'referrals, 3',
                                'Level 4 Referrals' => 'referrals, 4',
                            ]"
                        />
                        <li class="nk-menu-heading p-4">
                            <h6 class="overline-title">Payments</h6>
                        </li>
                        <x-nav-link 
                            title="Deposit Now" 
                            link="{{ route('payment', 'deposit') }}" 
                            icon="icon ni ni-wallet-fill" 
                        />
                        <x-nav-link
                            title="Withdraw"
                            link="{{ route('payment', 'withdrawal') }}"
                            icon="icon ni ni-coin-alt-fill"
                        />
                        <li class="nk-menu-heading mt-2">
                            <h6 class="overline-title">Installments</h6>
                        </li>

                        <x-nav-link
                            title="Apply for installments"
                            link="{{ route('installments.create') }}"
                            icon="icon ni ni-cc-secure-fill"
                        />

                        <li class="nk-menu-heading mt-2">
                            <h6 class="overline-title">Reports</h6>
                        </li>

                        <x-dropdown
                            title="Reports"
                            icon="ni-files"
                            :links="[
                                'Deposit History'      => 'reports.payments, deposited,default', 
                                'Withdraw History'     => 'reports.payments, withdrawal,default', 
                                'Committee History'    => 'reports.committee',
                                'Installment History'  => 'reports.installments',
                                'Transactions'         => 'reports.transactions',
                                'Commission'           => 'reports.commissions',
                            ]"
                        />

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
