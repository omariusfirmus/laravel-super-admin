<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{\Illuminate\Support\Facades\Auth::user()->name}} Profile</h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb  ">
            <li>
                <a href="javascript;">Home</a><i class="fa fa-circle"></i>
            </li>
            <li class="active">
                 profile
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row margin-top-10">
             <div class="portlet box green">
                 <div class="portlet-title">
                     @php $user = \Illuminate\Support\Facades\Auth::user(); @endphp
                     <h4>{{$user->name}}</h4>
                 </div>
                 <div class="portlet-body">
                     @if (Session::has('message'))
                         <div class="card-body margin-v">
                             <div class="alert alert-info text-center">{{Session::get('message')}}</div>
                             @php Session::forget('message'); @endphp
                         </div>
                     @endif
                     <form action="{{url('super-admin/change-password')}}" method="post">
                         @csrf
                         <label class="margin-v col-sm-4"> Old Password
                             <input type="text" name="old_pass"   class="form-control" >
                         </label>
                         <label class="margin-v col-sm-4"> New Password
                             <input type="text" name="new_pass"   class="form-control" >
                         </label>
                         <label class="margin-v col-sm-4"> Confirm New Password
                             <input type="text" name="conf_new_pass"   class="form-control" >
                         </label>
                         <div class="col-sm-12 text-right">
                             <button type="submit" class="btn btn-success">Submit</button>
                         </div>
                         <div class="clearfix"></div>
                     </form>
                 </div>
             </div>

        </div>

         <div class="row">

         </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->
