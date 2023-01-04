<div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="html/crypto/index.html" class="logo-link nk-sidebar-logo">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                <span class="nio-version">{{ config('app.name') }}</span>
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
                            icon="icon ni ni-dashboard" 
                        />
                        <li class="nk-menu-heading mt-2">
                            <h6 class="overline-title">Plans</h6>
                        </li>
                        <x-nav-link 
                            title="Plans" 
                            link="{{ route('plans.index') }}" 
                            icon="icon ni ni-dashboard" 
                        />
                        <x-nav-link 
                            title="Committee Plans" 
                            link="{{ route('committee.plans.index') }}" 
                            icon="icon ni ni-dashboard" 
                        />
                        <li class="nk-menu-heading mt-2">
                            <h6 class="overline-title">Referrals</h6>
                        </li>
                        <x-nav-link 
                            title="Your Refferrals" 
                            link="referral.index" 
                            icon="icon ni ni-dashboard" 
                        />
                        <li class="nk-menu-heading mt-2">
                            <h6 class="overline-title">Payments</h6>
                        </li>
                        <x-nav-link 
                            title="Deposit Now" 
                            link="deposit.index" 
                            icon="icon ni ni-dashboard" 
                        />
                        <x-nav-link 
                            title="Withdraw" 
                            link="withdraw.index" 
                            icon="icon ni ni-dashboard" 
                        />
                        <li class="nk-menu-heading mt-2">
                            <h6 class="overline-title">Installments</h6>
                        </li>
                        
                        <x-nav-link 
                            title="Apply for installments" 
                            link="installments.index" 
                            icon="icon ni ni-dashboard" 
                        />

                        <li class="nk-menu-heading mt-2">
                            <h6 class="overline-title">Reports</h6>
                        </li>

                        <x-dropdown 
                            title="Reports" 
                            :links="[
                                'Deposit History'      => 'deposit.report', 
                                'Withdraw History'     => 'withdraw.report', 
                                'Committee History'    => 'committee.report',
                                'Installment History'  => 'installment.report',
                                'Transactions'         => 'transaction.report',
                                'Commission'           => 'commission.report',
                            ]" 
                        />
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
