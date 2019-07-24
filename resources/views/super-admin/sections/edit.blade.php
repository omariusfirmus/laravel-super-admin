@php
    $ignored =['id'];
@endphp
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{$title}} <small>#{{$id}}</small></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb ">
            <li>
                <a href="{{url('/super-admin/') }}">Home</a><i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('/super-admin/section/view/'.$table) }}">{{$title}}</a><i class="fa fa-circle"></i>
            </li>
            <li class="active">
                {{  \Illuminate\Support\Str::singular($title) }} #{{$id}}
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row">
            <div class="col-sm-12">

                <div class="portlet box ">
                    <div class="portlet-title">
                        <a href="{{url('/super-admin/section/view/'.$table)}}" class="btn margin-v btn-primary "><i class="fa fa-angle-left"></i> Back to {{$title}}</a>
                     </div>
                    <div class="portlet-body">
                        @if (Session::has('message'))
                            <div class="card-body margin-v">
                                <div class="alert alert-info text-center">{{Session::get('message')}}</div>
                                @php Session::forget('message'); @endphp
                            </div>
                        @endif
                        <div class="card-success margin-v card">
                            <form class="row form-clean " action="{{url('/super-admin/section/update/'.$table.'/'.$id)}}" method="post" enctype="multipart/form-data">
                                <div class="col-sm-12">
                                    @csrf
                                @foreach($fields as $field)
                                    @php
                                        $field->display_name = str_replace('_',' ',ucfirst($field->display_name));
                                    @endphp
                                    @if (in_array($field->field,$ignored)) @continue @endif
                                        @switch($field->type)

                                            @case ('text')
                                            {!!   \App\Helpers::shortcode($field->optional_details)!!}

                                            <div class="col-sm-12">
                                                    <label for="form_control_1">{{ucfirst($field->display_name)}}</label>
                                                    <input type="text" value="{{$row[$field->field]}}" name="{{$field->field}}" class="form-control" id="">
                                            </div>
                                            @break

                                            @case ('textarea')
                                            <div class="col-sm-12">

                                                    <label for="form_control_1">{{ $field->display_name}}</label>
                                                    <textarea class="form-control" name="{{$field->field}}" rows="3">{{$row[$field->field]}}</textarea>

                                            </div>
                                            @break

                                            @case ('select')
                                            <div class="col-sm-12">
                                                <label>{{$field->display_name}}</label>
                                                <select class="form-control" required name="{{$field->field}}" >
                                                            <option value=""></option>

                                                            {!!   \App\Helpers::shortcode($field->optional_details.'<>[selected='.$row[$field->field].']')!!}
                                                    </select>

                                            </div>
                                            @break

                                            @case ('hidden')
                                              @if ($field->optional_details != '[remove]')
                                                {!!   \App\Helpers::shortcode($field->optional_details)!!}

                                                <input type="hidden"  name="{{$row[$field->field]}}" value="">
                                              @endif
                                            @break

                                            @case ('editor')
                                            <div class="col-sm-6 col-sm-offset-3 margin-v">
                                                    <label   class="margin-v" style="color:#777; text-transform: capitalize">{{ $field->display_name}}</label>
                                                    <textarea class="form-control editor" name="{{$field->field}}" rows="3">{{$row[$field->field]}}</textarea>
                                            </div>
                                        <div class="col-sm-3"></div>
                                            @break

                                            @case ('checkbox')
                                            <div class="col-sm-12 margin-v">
                                                    <label  class="margin-v" style="color:#777; text-transform: capitalize">
                                                        <input type="checkbox" {{$row[$field->field] == 1 ? 'checked':''}} name="{{$field->field}}" value="1">
                                                        {{ $field->display_name}}
                                                  </label>
                                            </div>
                                            @break

                                            @case ('multiple_checkbox')
                                            <div class="col-sm-12 margin-v">
                                                <span>{{$field->display_name}} <br></span>
                                                @foreach(\App\Helpers::shortcode($field->optional_details) as $checkbox)
                                                    <label class="margin-v" style="color:#777; text-transform: capitalize">
                                                        <input type="checkbox" name="{{$field->field}}[]" {{$row[$field->field] == $checkbox ? 'checked':'' }} value="{{$checkbox}}"> {{ucfirst($checkbox)}}
                                                    </label>
                                                @endforeach
                                            </div>
                                            @break

                                            @case ('radio')
                                            <div class="col-sm-12 margin-v"  style="margin-top:20px">
                                                <span>{{$field->display_name}} <br></span>
                                                @foreach(\App\Helpers::shortcode($field->optional_details) as $radio)
                                                    <label class="margin-v" style="color:#777; text-transform: capitalize">
                                                        <input type="radio" name="{{$field->field}}" {{$row[$field->field] == $radio ? 'checked':''}} value="{{$radio}}"> {{ucfirst($radio)}}
                                                    </label>
                                                @endforeach
                                            </div>
                                            @break

                                            @case ('image')
                                            <div class="col-sm-12   fileupload-buttonbar">
                                                <label class="center-block">
                                                    {{$field->display_name}} </label>
                                                    <input  class="form-control" type="file" name="{{$field->field}}">
                                                @if ($row[$field->field] != '')
                                                    <img src="{{url('uploads/'.$row[$field->field])}}" width="100" alt="">
                                                @endif

                                            </div>
                                            @break

                                            @case ('multiple_images')
                                            <div class="col-sm-12  fileupload-buttonbar">
                                                <label class="margin-v center-block">
                                                    {{$field->display_name}}</label>
                                                    <input  class="form-control" type="file" multiple name="{{$field->field}}[]"  >
                                                @if ($row[$field->field] != '' && is_array(json_decode($row[$field->field])))
                                                    <div class="images margin-v">
                                                    @foreach(json_decode($row[$field->field]) as $img)
                                                            <div class="image margin-right-10" style="position: relative;display: inline-block;float: left;">
                                                                <i class="delete-img fa fa-close" style="color:darkred;cursor: pointer; position: absolute; top: -10px;right:-5px " ></i>
                                                                <img src="{{url('uploads/'.$img)}}" style="background: #fafafa;display: inline-block;vertical-align: baseline;border:1px solid #999" width="100" alt="">
                                                                <input type="hidden" name="{{$field->field.'_old'}}[]" value="{{$img}}">
                                                            </div>
                                                    @endforeach
                                                        <div class="clearfix"></div>
                                                    </div>
                                                @endif
                                            </div>
                                            @break

                                            @case ('file')
                                            <div class="col-sm-12   fileupload-buttonbar">
                                                <label class="center-block">
                                                    {{$field->display_name}}  </label>
                                                    <input  class="form-control" type="file" name="{{$field->field}}"  >
                                                    @if(is_file(url('uploads/'.$row[$field->field])))
                                                    <a href="{{url('uploads/'.$row[$field->field])}}"><i class="icon-doc"></i> Download</a>
                                                    @endif
                                            </div>
                                            @break
                                            @case ('datetime')
                                            <div class="col-sm-12">

                                                    <label for="form_control_1">{{$field->display_name}}</label>
                                                    <input type="text" name="{{$field->field}}"  class="form-control" value="{{$row[$field-> field]}}">
                                                    <span class="help-block"></span>

                                            </div>
                                            @break
                                        @endswitch
                                @endforeach
                                    <input type="hidden" name="isUserRoles" value="0">
                                    @if ($table === 'user_roles' && $id !=1)
                                        <style>
                                            .sections-module label{
                                                display: block;
                                            }
                                        </style>
                                        <input type="hidden" name="isUserRoles" value="1">
                                        @foreach($sections as $key => $sec)
                                            <div class="col-sm-2 col-xs-4 sections-module margin-v">

                                                <h4>{{$sec->table}}</h4>
                                                <label  class="margin-v" style="color:#777; text-transform: capitalize">
                                                    @php
                                                        $perm = DB::table('permissions')->where(['user_role_id'=>$id, 'section_id'=> $sec->id])->first();
                                                    @endphp
                                                    <input type="hidden" name="perms[{{$sec->table}}][add]" value="0">
                                                    <input type="checkbox" name="perms[{{$sec->table}}][add]" {{$perm->add ? 'checked':''}} value="1">  Add
                                                </label>
                                                <label  class="margin-v" style="color:#777; text-transform: capitalize">
                                                    <input type="hidden" name="perms[{{$sec->table}}][edit]" value="0">
                                                    <input type="checkbox" name="perms[{{$sec->table}}][edit]" {{$perm->edit ? 'checked':''}}  value="1">  Edit
                                                </label>
                                                <label  class="margin-v" style="color:#777; text-transform: capitalize">
                                                    <input type="hidden" name="perms[{{$sec->table}}][view]" value="0">
                                                    <input type="checkbox" name="perms[{{$sec->table}}][view]" {{$perm->view ? 'checked':''}}  value="1">  View
                                                </label>
                                                <label  class="margin-v" style="color:#777; text-transform: capitalize">
                                                    <input type="hidden" name="perms[{{$sec->table}}][read]" value="0">
                                                    <input type="checkbox" name="perms[{{$sec->table}}][read]" {{$perm->read ? 'checked':''}}  value="1">  Read
                                                </label>
                                                <label  class="margin-v" style="color:#777; text-transform: capitalize">
                                                    <input type="hidden" name="perms[{{$sec->table}}][delete]" value="0">
                                                    <input type="checkbox" name="perms[{{$sec->table}}][delete]" {{$perm->delete ? 'checked':''}}  value="1">  Delete
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-12 margin-v">
                                <button class="btn btn-success btn-circle btn-block" type="submit">Save</button>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->
