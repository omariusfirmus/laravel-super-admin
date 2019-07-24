@include ('super-admin.inc.header');
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    @include('super-admin.inc.sidebar')

    @include('super-admin.sections.'.$section)
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
@include ('super-admin.inc.footer')
