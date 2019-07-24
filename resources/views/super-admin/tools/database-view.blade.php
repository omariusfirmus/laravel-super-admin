@include ('super-admin.inc.header');
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
@include('super-admin.inc.sidebar')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            <a href="{{url('super-admin/database/add')}}" class="btn btn-primary margin-v">Create new table</a>
                <div class="portlet box blue">
                    <div class="portlet-title">
                            <div class="caption">Database</div>
                    </div>
                    <div class="portlet-body">
                        @if (Session::has('message'))
                            <div class="card-body margin-v">
                                <div class="alert alert-info text-center">{{Session::get('message')}}</div>
                                @php Session::forget('message'); @endphp
                            </div>
                        @endif
                        <table class="table table-hover table-bordered table-striped table-responsive">
                            <tr>
                                <th>#</th>
                                <th>Table</th>
                                <th>Actions</th>
                            </tr>
                            @php $i = 1;  @endphp
                            @foreach ($tables as $table)
                                <tr>
                                    <td>{{$i}}</td>
                                @foreach($table as $name)

                                        <td><a
                                                    @php
                                                        if (
                                                            $name == 'migrations' ||
                                                            $name == 'password_resets'
                                                            ) echo "onclick='return false'";
                                                    @endphp
                                         href="{{url('super-admin/database/table/'.$name)}}">{{$name}}</a></td>
                                        <td>

                                                @if (
                                                    $name != 'migrations' &&
                                                    $name != 'password_resets' &&
                                                    $name != 'permissions' &&
                                                    $name != 'sections' &&
                                                    $name != 'section_details' &&
                                                    $name != 'settings' &&
                                                    $name != 'user_roles' &&
                                                    $name != 'users'
                                                    )

                                                 <a class="btn btn-danger pull-right" href="{{ url('super-admin/database/delete/'.$name) }}"><i class="fa fa-trash"></i></a>
                                            @endif
                                            @php
                                                $section = DB::table('sections')->where('table',$name)->count();
                                            @endphp
                                            @if (!$section)
                                                        <a href="{{url('super-admin/crud/add/'.$name)}}" class="btn btn-default"><i class="fa fa-table"></i> Create Section</a>
                                            @else
                                                        <a href="{{url('super-admin/crud/edit/'.$name)}}" class="btn btn-primary"><i class="fa fa-table"></i> Edit Section</a>
                                                        <a href="{{url('super-admin/database/table/'.$name)}}" class="btn btn-success"><i class="fa fa-database"></i> Edit Table</a>
                                            @endif

                                        </td>
                                @endforeach
                                </tr>
                            @php $i++;  @endphp
                            @endforeach
                            <tr></tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

 </div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
@include ('super-admin.inc.footer')
