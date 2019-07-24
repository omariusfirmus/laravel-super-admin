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
                            <div class="caption">Database</div>
                    </div>
                <form method="post" action="{{url('super-admin/database/update')}}" class="portlet-body">
                        @csrf

                        @if (Session::has('message'))
                <div class="alert alert-warning text-center">{{Session::get('message')}}</div>
                    @php Session::forget('message'); @endphp
                    @endif
                    <div class="card-body margin-v">
                    <div class="col-sm-4"><label style="transform: translateY(-10px);">Table Name <input readonly required type="text" name="table_name" class="form-control" value="{{$name}}" ></label></div>
                            {{-- <div class="col-sm-4"><label style="transform: translateY(10px);"><input type="checkbox" checked name="create_model"> Create Model</label></div> --}}
                            <div class="col-sm-4"><button type="submit" class="btn btn-success btn-block" >Save</button></div>
                        </div>
                        <table class="table table-bordered table-responsive">
                                <tr>
                                        <th>Column name</th>
                                        <th>Column Type</th>
                                        <th>Nullable</th>
                                        <th>Auto increment</th>
                                        <th>Index</th>
                                        <th>Default</th>
                                    </tr>
                                    {{-- @dd($table) --}}
                                    @php $i = 0 @endphp
                            @foreach ($table as $col)
                                <tr>
                                <td>
                                    {{-- <input type="hidden" name="old_id[]" = "{{$col->Field }}" > --}}

                                    <input type="hidden" name="old_name[]" value="{{$col->Field}}" >
                                    <input class="form-control" type="text" value="{{$col->Field}}" name="name[]"></td>
                                    <td>
                                    <input type="hidden" name="old_type[]" value="{{$col->Type }}" >
                                        <select class="form-control" name="type[]" >
                                            <option value="integer" {{ $col->Type == 'int' ? 'selected':'' }}>integer</option>
                                            <option value="biginteger" {{ $col->Type == 'bigint' ? 'selected':'' }}>biginteger</option>
                                            <option value="varchar" {{ $col->Type == 'varchar' ? 'selected':'' }}>varchar</option>
                                            <option value="text" {{ $col->Type == 'text' ? 'selected':'' }} >text</option>
                                            <option value="float" {{ $col->Type == 'double' ? 'selected':'' }} >float</option>
                                            <option value="decimal" {{ $col->Type == 'decimal' ? 'selected':'' }}>decimal</option>
                                             <option value="datetime" {{ $col->Type == 'datetime' ? 'selected':'' }}>timestamp</option>
                                        </select>
                                    </td>
                                    <td>
                                    <input type="hidden" name="old_nullable[]" value="{{ $col->Null == 'YES' ? 1:0 }}" >
                                        <select name="nullable[]" >
                                            <option value="1" {{ $col->Null == 'YES' ? 'selected':''}}>NULL</option>
                                            <option value="0" {{ $col->Null == 'YES' ? '':'selected'}} >NOT NULL</option>
                                        </select>
                                    </td>
                                    <td>
                                    <input type="hidden" name="old_increment[]" value= "{{$col->Extra }}" >

                                    <select name="increment[]" >
                                        <option value="1" {{ $col->Extra == 'auto_increment' ? 'selected':''}}>Yes</option>
                                        <option value="0" {{ $col->Extra == 'auto_increment' ? '':'selected'}} >NO</option>
                                    </select>
                                    </td>
                                    <td>
                                    <input type="hidden" name="old_index[]" value="{{$col->Key }}" >
                                        <select name="index[]" class="form-control">
                                            <option value=""></option>
                                            <option value="primary" {{ $col->Key == 'PRI' ? 'selected':'' }}>primary</option>
                                            <option value="index" {{ $col->Key == 'MUL' ? 'selected':'' }}>index</option>
                                            <option value="unique" {{ $col->Key == 'UNI' ? 'selected':'' }}>unique</option>
                                        </select>
                                    </td>
                                    <input type="hidden" name="old_default[]" value="{{$col->Default }}" >
                                    <td><input type="text" class="form-control" value="{{ $col->Default != null ? $col->Default:''}}" name="default[]"></td>
                                </tr>
                                @php $i++ @endphp
                            @endforeach

                            @for ($i = 1; $i <= 20 ; $i++)


                            <tr>
                                 <td>
                                     <input class="form-control" type="text" value="" name="new_name[]"></td>
                                <td>
                                    <select class="form-control" name="new_type[]" >
                                        <option value="integer" >integer</option>
                                        <option value="biginteger">biginteger</option>
                                        <option value="varchar">varchar</option>
                                        <option value="text">text</option>
                                        <option value="float">float</option>
                                        <option value="decimal">decimal</option>
                                         <option value="datetime">timestamp</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="new_nullable[]" >
                                        <option value="1"  >NULL</option>
                                        <option value="0"  >NOT NULL</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="new_increment[]" >
                                        <option value="0" >NO</option>
                                        <option value="1" >Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="new_index[]" class="form-control">
                                        <option value=""></option>
                                        <option value="primary">primary</option>
                                        <option value="index">index</option>
                                        <option value="unique">unique</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="new_default[]"></td>
                            </tr>
                        @endfor
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

 </div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
@include ('super-admin.inc.footer')
