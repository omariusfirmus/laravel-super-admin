@php
$ignored =['created_at','updated_at'];
@endphp
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{$title}} <small></small></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb ">
            <li>
                <a href="{{url('/super-admin/') }}">Home</a><i class="fa fa-circle"></i>
            </li>
            <li class="active">
                {{$title}}
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE CONTENT INNER -->
<div class="row margin-v">

</div>
        <div class="row">
            <div class="col-sm-12">

                <div class="portlet box ">
                    <div class="portlet-title">
                        <a href="{{url('/super-admin/section/add/'.$table)}}" class="btn margin-v btn-primary "><i class="fa fa-plus"></i> Add {{\Illuminate\Support\Str::singular($title)}}</a>
                        <label for="" class="col-sm-4 pull-right margin-v"><input placeholder="search" type="text" class="form-control"></label>
                    </div>
                    @if (Session::has('message'))
                        <div class="card-body margin-v">
                            <div class="alert alert-info text-center">{{Session::get('message')}}</div>
                            @php Session::forget('message'); @endphp
                        </div>
                    @endif
                    <div class="portlet-body">
                        <div class="card-success margin-v card">
                            
                         </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->
