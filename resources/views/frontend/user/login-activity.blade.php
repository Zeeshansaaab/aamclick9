<x-app-layout>
    <x-slot name="title">Profile</x-slot>

    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Profile" title="Profile" :links="['dashboard' => 'dashboard']"/>
    </x-slot>

    <x-slot name="header">
    </x-slot>
    <div class="card card-bordered">
        <div class="card-aside-wrap">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head nk-block-head-lg">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title">Login Activity</h4>
                            <div class="nk-block-des">
                                <p>Here is your login activities log. <span class="text-soft"><em class="icon ni ni-info"></em></span></p>
                            </div>
                        </div>
                        <div class="nk-block-head-content align-self-start d-lg-none">
                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="nk-block card card-bordered">
                    <table class="table table-ulogs">
                        <thead class="thead-light">
                            <tr>
                                <td class="tb-col-os" style="background-color: #f5f6fa;"><span class="overline-title">#</span></td>
                                <th class="tb-col-os"><span class="overline-title">Browser <span class="d-sm-none">/ IP</span></span></th>
                                <th class="tb-col-ip"><span class="overline-title">IP</span></th>
                                <th class="tb-col-time"><span class="overline-title">Time</span></th>
                                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
                            </tr>
                        </thead>
                        <tbody id="notification_tbody">
                            
                        </tbody>
                    </table>
                </div><!-- .nk-block-head -->
            </div>
            <x-users.profile-sidebar :user="auth()->user()"/>
        </div><!-- .card-aside-wrap -->
    </div>
    <x-slot name="scripts">
        <script>
            NioApp.coms.docReady.push(function(){
                axios.get('{{route('profile.login-logs.item')}}')
                .then((response) => {
                    $('#notification_tbody').html(response.data)
                })
            })
        </script>
    </x-slot>
</x-app-layout>