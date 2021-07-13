@extends('admin.layouts')
@section('extra-css')
@endsection
@section('body-section')
<div class="content">
    <!-- BEGIN: Top Bar -->
    <div class="top-bar">
        <!-- BEGIN: Breadcrumb -->
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Application</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Dashboard</a> </div>
        <!-- END: Breadcrumb -->
        @include('admin.header')
    </div>
    <!-- END: Top Bar -->
    <h2 class="intro-y text-lg font-medium mt-10">
    Mobile App About Us
    </h2>
    <form action="/admin/update-app-about" class="validate-form" id="form" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" value="{{$settings->id}}" name="id" id="id">
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div>
                    <label>About Us English</label>
                    <textarea rows="7" class="input w-full border mt-2" name="about_english" id="about_english">{{$settings->about_english}}</textarea>
                </div>
                <br>
                <div>
                    <label>About Us Arabic</label>
                    <textarea rows="7" class="input w-full border mt-2" name="about_arabic" id="about_arabic">{{$settings->about_arabic}}</textarea>
                </div>
    
                <div class="text-right mt-5">
                    <!-- <button type="button" class="button w-24 border text-gray-700 mr-1">Cancel</button> -->
                    <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
    </form>
</div>
<!-- END: Content -->

@endsection
@section('extra-js')
<script type="text/javascript">
$('.app-about').addClass('side-menu--active');
$('.app_settings_master').addClass('side-menu--active side-menu--open');
$('.app_settings').addClass('side-menu__sub-open');
</script>
@endsection
            
        