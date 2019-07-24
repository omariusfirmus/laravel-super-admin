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
                <form method="post" action="{{url('super-admin/database/store')}}" class="portlet-body">
                        @csrf
                        @if (Session::has('message'))
                <div class="alert alert-warning text-center">{{Session::get('message')}}</div>
                    @php Session::forget('message'); @endphp
                    @endif
                    <div class="card-body margin-v">
                            <div class="col-sm-4"><label style="transform: translateY(-10px);">Table Name <input required type="text" name="table_name" class="form-control" ></label></div>
                            <div class="col-sm-4"><label style="transform: translateY(10px);"><input type="checkbox" checked name="create_model"> Create Model</label></div>
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

                                    <tr>
                                         <td><input class="form-control" type="text" value="id" name="name[]"></td>
                                        <td>
                                            <select class="form-control" name="type[]" >
                                                <option value="integer" >integer</option>
                                                <option value="biginteger" selected>biginteger</option>
                                                <option value="varchar">varchar</option>
                                                <option value="text">text</option>
                                                <option value="float">float</option>
                                                <option value="decimal">decimal</option>
                                                <option value="datetime">timestamp</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="nullable[]" >
                                                <option value="1" selected>NULL</option>
                                                <option value="0" >NOT NULL</option>
                                            </select>                                </td>
                                        <td>
                                            <select name="increment[]" >
                                                <option value="0" >NO</option>
                                                <option value="1" >Yes</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="index[]" class="form-control">
                                                <option value=""></option>
                                                <option value="primary" selected>primary</option>
                                                 <option value="unique">unique</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="default[]"></td>
                                    </tr>
                            @for ($i = 1; $i <= 20 ; $i++)


                                <tr>
                                     <td><input class="form-control" type="text" value="" name="name[]"></td>
                                    <td>
                                        <select class="form-control" name="type[]" >
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
                                            <select name="nullable[]" >
                                                <option value="1" selected>NULL</option>
                                                <option value="0" >NOT NULL</option>
                                            </select>                                </td>
                                        <td>
                                            <select name="increment[]" >
                                                <option value="0" >NO</option>
                                                <option value="1" >Yes</option>
                                            </select>
                                        </td>
                                    <td>
                                        <select name="index[]" class="form-control">
                                            <option value=""></option>
                                            <option value="primary">primary</option>
                                            <option value="index">index</option>
                                            <option value="unique">unique</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="default[]"></td>
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
