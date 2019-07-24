<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Dashboard <small>Settings</small></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb hide">
            <li>
                <a href="{{url('/super-admin')}}">Home</a><i class="fa fa-circle"></i>
            </li>
            <li class="active">
                 Dashboard
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE CONTENT INNER -->


         <div class="row">
            @php
                $settings = DB::table('settings')->get();
            @endphp

             <form class="col-sm-12" action="{{url('super-admin/settings/save')}}" enctype="multipart/form-data" method="post">
@csrf
                 <div class="portlet box green">
                     <div class="portlet-title">
                         <div class="caption">
                             <i class="fa fa-gift"></i>Website Settings
                         </div>
                         <div class="tools">
                             <button type="submit" class="btn btn-primary btn block">Save</button>
                         </div>
                     </div>
                     <div class="portlet-body">
                         @if (Session::has('message'))
                             <div class="card-body margin-v">
                                 <div class="alert alert-info text-center">{{Session::get('message')}}</div>
                                 @php Session::forget('message'); @endphp
                             </div>
                         @endif
                         <ul class="nav nav-tabs">
                             @php
                                $grouped = DB::table('settings')->groupBy('group')->pluck('group')->all();
                             $i =0;
                             @endphp

                             @foreach($grouped as $group)
                                 <li class="{{$i == 0 ? 'active':''}}">
                                     <a href="#{{$group}}" data-toggle="tab" aria-expanded="{{$i == 0 ? 'true':'false'}}">
                                         {{ucfirst(str_replace('_',' ',$group))}} </a>
                                 </li>
                             @php $i++ @endphp
                             @endforeach
                         </ul>
                         <div class="tab-content">
                             @php $i =0;
                             @endphp

                             @foreach($grouped as $group)
                                 <div class="tab-pane fade {{$i == 0 ? 'active':''}} in" id="{{$group}}">
                                     @php $items = DB::table('settings')->where('group',$group)->orderBy('id','asc')->get() @endphp
                                       @foreach($items as $item)
                                         @switch ($item->type)
                                             @case ('text')
                                             <label for="" class="col-sm-6">
                                                 {{$item->_key}}
                                                 <input type="text" name="{{$item->_key}}" value="{{$item->_value}}" class="form-control">
                                             </label>
                                             @break

                                             @case ('textarea')
                                             <label class="col-sm-6">
                                                 {{$item->_key}}
                                                 <textarea name="{{$item->_key}}" class="form-control">{{$item->_value}}</textarea>
                                             </label>
                                             @break
                                             @case ('editor')
                                             <label class="col-sm-6">
                                                 {{$item->_key}}
                                                 <textarea name="{{$item->_key}}" class="editor form-control">{!! $item->_value !!}</textarea>
                                             </label>
                                             @break

                                             @case ('image')
                                             <label class="col-sm-6">
                                                 {{$item->_key}}
                                                 <input name="{{$item->_key}}" type="file" class="form-control">
                                                 {!!  $item->_value != '' ? '<img width="100" class="img-responsive" src="'.url('uploads/'. $item->_value ).'" >':''!!}
                                             </label>
                                             @break

                                             @case ('file')
                                             <label class="col-sm-6">
                                                 {{$item->_key}}
                                                 <input name="{{$item->_key}}" type="file" class="form-control">
                                                 {{$item->_value != '' ?  url('uploads/'. $item->_value ) :''}}
                                             </label>
                                             @break


                                             @case ('checkbox')
                                             <label class="col-sm-6">
                                                 {{$item->_key}}
                                                 <input name="{{$item->_key}}" type="checkbox" value="1" {{$item->_value == 1 ? 'checked':''}} class="form-control">
                                             </label>
                                             @break

                                             @case ('dropdown')
                                             <label class="col-sm-6">{{$item->_key}}
                                                 @php $keys = explode(',',$item->additional_info); @endphp
                                                 <select name="{{$item->_key}}" class="form-control">
                                                     <option value="" >Select {{$item->_key}}</option>
                                                 @foreach($keys as $k)
                                                         <option value="{{$k}}" {{$item->_value == $k ? 'selected':''}}>{{$k}}</option>
                                                     @endforeach
                                                 </select>
                                             </label>
                                             @break

                                            @default
                                                {{$item->_key}}

                                         @endswitch
                                       @endforeach

                                 </div>
                                 @php $i++ @endphp
                             @endforeach
                         </div>
                         <div class="clearfix  margin-v">
                             <button type="submit" class="btn btn-success btn block btn-block">Save</button>
                         </div>


                     </div>
                 </div>
             </form>
             <div class="clearfix margin-bottom-20">
             </div>
             @if (\Illuminate\Support\Facades\Auth::user()->user_role == 'super-admin')

                 <div class="col-sm-12">
                     <div class="portlet box blue">
                         <div class="portlet-title"><h4><i class="fa fa-plus"></i>  Add Setting</h4></div>
                         <div class="portlet-body">
                             <form action="{{url('super-admin/settings/add')}}" method="post">
                                 @csrf
                                 <div class="col-sm-3">
                                     <input type="text" placeholder="_key" required class="form-control" name="_key">
                                 </div>
                                 <div class="col-sm-3">
                                     <select class="form-control" required name="type">
                                         //types = text, textarea, editor, image, file, checkbox, dropdown, radio,
                                         <option value="">Select Type</option>
                                         <option value="text">text</option>
                                         <option value="textarea">Text Area</option>
                                         <option value="editor">Editor</option>
                                         <option value="image">Image</option>
                                         <option value="file">File</option>
                                         <option value="checkbox">Checkbox</option>
                                         <option value="dropdown">dropdown</option>
                                         <option value="radio">radio</option>
                                     </select>
                                 </div>
                                 <div class="col-sm-3">
                                     <input type="text" class="form-control" placeholder="group" name="group">
                                 </div>
                                 <div class="col-sm-3">
                                     <input type="text" class="form-control" placeholder="Additional Info" name="additional_info">
                                 </div>
                                 <div class="clearfix"></div>
                                 <div class="col-sm-12 text-right margin-v"><button type="submit" class="btn btn-success">Add</button></div>
                                 <div class="clearfix"></div>
                             </form>
                         </div>
                     </div>
                 </div>
                 @endif
         </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->
