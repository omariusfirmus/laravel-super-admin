<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="start active ">
            <a href="{{url('super-admin')}}">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                </a>
            </li>
            @php
                $role = Auth::user()->user_role;
                $role_id = \App\UserRole::where('role_name',$role)->first()->id;
                $permissions = \App\Permission::where('user_role_id',$role_id)->orderBy('id','desc')->get();

            @endphp

                @foreach($permissions as $perm)
                    @php

                        $section = \App\Section::find($perm->section_id);
                        $str =  ucfirst($section->table) ;
                        $section_name = str_replace('_', ' ', $str);
                    @endphp
                <li class="start ">
                    <a href="{{url('super-admin/section/view/'.$section->table)}}">
                        <i class="icon-folder-alt"></i>
                        <span class="title">{{$section_name}}</span>
                    </a>
                </li>
                @endforeach

            <li class="start ">
                <a href="{{url('super-admin/page/settings')}}">
                    <i class="icon-settings"></i>
                    <span class="title">{{'Settings'}}</span>
                </a>
            </li>

            @if (Auth::user()->user_role=="super-admin")
                <li>
                <a href="javascript:;">
                <i class="icon-settings"></i>
                <span class="title">Tools</span>
                <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{url('super-admin/database/view')}}">
                        <i class="icon-layers"></i>
                        Database</a>
                    </li>

                </ul>
            </li>
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->


