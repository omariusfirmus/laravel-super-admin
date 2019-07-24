@include ('super-admin.inc.header');
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    @include('super-admin.inc.sidebar')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <a href="{{url('super-admin/database/view')}}" class="btn btn-success margin-v"> <i class="fa fa-angle-left"></i> Back</a>
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">Edit Section of table: {{$table_name}}</div>
                    </div>
                    <form action="{{url('super-admin/crud/update/'.$table_name)}}" method="post" class="portlet-body">
                        @csrf
                        @if (Session::has('message'))
                            <div class="card-body margin-v">
                                <div class="alert alert-info text-center">{{Session::get('message')}}</div>
                                @php Session::forget('message'); @endphp
                            </div>
                        @endif

                        <div class=" ">
                            <div class="margin-v">

                            </div>
                            <table class="table table-bordered table-hover table-responsive">
                                <tr>
                                    <th style="width:190px">Column</th>
                                    <th  style="width:190px">Field Type</th>
                                    <th>Display Name</th>
                                    <th>optional details</th>
                                </tr>
                                @foreach($cols as $k => $col)
{{--                                    @dd(count($details) )--}}
                                    {{--@if ($k+1 > count($details) )--}}
                                            {{--@php--}}
                                           {{--$data = [];--}}
                                           {{--$data['field'] = $col->Field;--}}
                                           {{--$data['type'] = $col->Type;--}}
                                           {{--$data['display_name'] = $col->Field;--}}
                                           {{--$data['optional_details'] = $r->optional_details[$key];--}}
                                           {{--$data['section_id'] = $section->id;--}}
                                           {{--\App\SectionDetail::create($data);--}}
                                           {{--@endphp--}}

                                    {{--@endif--}}
                                    <tr>

                                        <td>
                                            <input type="text" name="field[]" value="{{$col->Field}}" class="form-control" readonly>
                                            <small><b>type: </b>{{$col->Type}}</small><br>
                                            <small>{{$col->Null == 'YES' ? 'Null':'NOT NULL' }}</small><br>
                                            <small>
                                                @php
                                                    $key = '';
                                                switch ($key)
                                                {
                                                    case "PRI":
                                                        $key = "Primary";
                                                    break;
                                                    case "UNI":
                                                        $key = "Unique";
                                                    break;
                                                    case "Mul":
                                                        $key = "Index";
                                                    break;
                                                }

                                                @endphp {{$key}}</small><br>
                                        </td>

                                        <td>

                                            <select name="type[]" class="form-control">
                                                <option value="text" {{$details[$k]->type == 'text' ? 'selected':''}}>Text</option>
                                                <option value="textarea" {{$details[$k]->type == 'textarea' ? 'selected':''}}>TextArea</option>
                                                <option value="select" {{$details[$k]->type == 'select' ? 'selected':''}}>DropDown Menu</option>
                                                <option value="hidden" {{$details[$k]->type == 'hidden' ? 'selected':''}}
                                                        {{in_array($col->Field,['id','created_at','updated_at']) ? 'selected':'' }}
                                                >Hidden</option>
                                                <option value="editor" {{$details[$k]->type == 'editor' ? 'selected':''}}>Editor</option>
                                                <option value="checkbox" {{$details[$k]->type == 'checkbox' ? 'selected':''}}>Checkbox</option>
                                                <option value="multiple_checkbox" {{$details[$k]->type == 'multiple_checkbox' ? 'selected':''}}>Multiple Checkbox</option>
                                                <option value="radio" {{$details[$k]->type == 'radio' ? 'selected':''}}>Radio</option>
                                                <option value="image" {{$details[$k]->type == 'image' ? 'selected':''}}>Image</option>
                                                <option value="multiple_images " {{$details[$k]->type == 'multiple_images' ? 'selected':''}}>MultipleImage</option>
                                                <option value="file" {{$details[$k]->type == 'file' ? 'selected':''}}>File</option>
                                                <option value="datetime" {{$details[$k]->type == 'datetime' ? 'selected':''}}>DateTime</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" value="{{ $details[$k]->display_name }}" name="display_name[]"></td>
                                        <td><textarea class="form-control" name="optional_details[]" rows="6">{{ $details[$k]->optional_details }}</textarea></td>
                                    </tr>
                                @endforeach


                            </table>
                            <div class="margin-v text-right">
                                <button type="submit" class="btn btn-circle btn-block btn-success btn-inverse">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
@include ('super-admin.inc.footer')
