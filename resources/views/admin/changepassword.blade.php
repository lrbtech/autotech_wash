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
        Change Password
    </h2>
    <form class="validate-form" id="form" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" value="{{ $user->id }}" name="id" id="id">
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div>
                    <label>Old Password</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Enter Old Password" name="oldpassword" id="oldpassword">
                </div>  
                <div>
                    <label>New Password</label>
                    <input type="password" class="input w-full border mt-2" placeholder="Enter your New Password" name="password" id="password">
                </div> 
                <div>
                    <label>Confirm Password</label>
                    <input type="password" class="input w-full border mt-2" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation">
                </div>               
                <button onclick="Save()" type="button" class="button bg-theme-1 text-white mt-4">Change Password</button>
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
$('.change-password').addClass('side-menu--active');
$('.settings_master').addClass('side-menu--active side-menu--open');
$('.settings').addClass('side-menu__sub-open');

function Save(){
    $(".label-error").remove();
    $('.input').removeClass('error');
    //alert($("#service_id").val());
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : '/admin/update-password',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
        console.log(data);                
            if(data.status == 1){
                Swal.fire({
                    //title: "Please Check Your Email",
                    text: 'Change Password Successfully',
                    type: "success",
                    confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                    buttonsStyling: false,
                }).then(function() {
                    window.location.href="/agent/dashboard/";
                });
            }
            else{
                Swal.fire({
                    //title: "Please Check Your Email",
                    text: data.message,
                    type: "error",
                    confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                    buttonsStyling: false,
                });
            }
        },
        error: function (data, errorThrown) {
        var errorData = data.responseJSON.errors;
        $.each(errorData, function(i, obj) {
            $("#"+i).after('<label class="label-error error" for="'+i+'">'+obj[0]+'</label>');
            $('#'+i).addClass('error');
        });
        }
    });
}
</script>
@endsection
            
        