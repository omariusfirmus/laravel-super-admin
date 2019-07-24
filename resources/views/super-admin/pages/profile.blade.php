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
                     <form action="{{url('super-admin/updateProfile')}}" method="post">
                         @csrf
                         <label class="margin-v col-sm-6"> Name
                             <input type="text" name="name" value="{{$user->name}}" class="form-control" >
                         </label>
                         <label class="margin-v col-sm-6"> UserName
                             <input type="text" name="username" value="{{$user->username}}" class="form-control" >
                         </label>
                         <label class="margin-v col-sm-6"> E-mail
                             <input type="text" name="email" value="{{$user->email}}" class="form-control" >
                         </label>
                         <label class="margin-v col-sm-6"> Created At
                             <input type="text" readonly value="{{$user->created_at}}" class="form-control" >
                         </label>
                         <div class="col-sm-12 text-right">
                             <button type="submit" class="btn btn-success">Update</button>
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
