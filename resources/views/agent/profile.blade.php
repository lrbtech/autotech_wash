@extends('agent.layouts')
@section('extra-css')
@endsection
@section('body-section')
<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Profile Update
    </h2>
    <form class="validate-form" id="form" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="mt-3">
                    <div class="sm:grid grid-cols-2 gap-6">
                        <div class="relative mt-2">
                          <label>Select Service</label>
                          <select multiple class="select2 w-full" name="service_ids[]" id="service_ids">
                          <?php
                          $arraydata=array();
                          foreach(explode(',',$profile->service_ids) as $service_id){
                            $arraydata[]=$service_id;
                          }
                          ?>
                          @foreach ($service as $value)
                            @if(in_array($value->id , $arraydata))
                              <option selected value="{{$value->id}}">{{$value->service_name_english}}</option>
                            @else
                              <option value="{{$value->id}}">{{$value->service_name_english}}</option>
                            @endif
                          @endforeach
                          </select>
                        </div>
                        <div class="relative mt-2">
                          <label>Other Service</label>
                          <select class="input w-full border mt-2" name="other_service" id="other_service">
                            <option {{ ($profile->other_service == '0' ? ' selected' : '') }} value="0">Home Services</option>
                            <option {{ ($profile->other_service == '1' ? ' selected' : '') }} value="1">Visitus</option>
                          </select>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="sm:grid grid-cols-2 gap-6">
                        <div class="relative mt-2">
                          <label>Busisness Name</label>
                          <input value="{{$profile->busisness_name}}" type="text" class="input w-full border mt-2" name="busisness_name" id="busisness_name">
                        </div>
                        <div class="relative mt-2">
                          <label>Name</label>
                          <input value="{{$profile->name}}" type="name" class="input w-full border mt-2" name="name" id="name">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="sm:grid grid-cols-2 gap-6">
                        <div class="relative mt-2">
                          <label>Mobile</label>
                          <input value="{{$profile->mobile}}" type="text" class="input w-full border mt-2" name="mobile" id="mobile">
                        </div>
                        <div class="relative mt-2">
                          <label>Email</label>
                          <input value="{{$profile->email}}" type="email" class="input w-full border mt-2" name="email" id="email">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="sm:grid grid-cols-2 gap-6">
                        <div class="relative mt-2">
                          <label>About Us English</label>
                          <textarea rows="5" class="input w-full border mt-2" name="about_us_english" id="about_us_english">{{$profile->about_us_english}}</textarea>
                        </div>
                        <div class="relative mt-2">
                          <label>About Us Arabic</label>
                          <textarea rows="5" class="input w-full border mt-2" name="about_us_arabic" id="about_us_arabic">{{$profile->about_us_arabic}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="sm:grid grid-cols-2 gap-6">
                        <div class="relative mt-2">
                          <label>Profile Image</label>
                          <input type="file" class="input w-full border mt-2" name="profile_image" id="profile_image">
                          <img style="width:200px;" src="/upload_files/{{$profile->profile_image}}">
                        </div>
                        <div class="relative mt-2">
                          <label>Cover Image</label>
                          <input type="file" class="input w-full border mt-2" name="cover_image" id="cover_image">
                          <img style="width:200px;" src="/upload_files/{{$profile->cover_image}}">
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="sm:grid grid-cols-3 gap-5">
                        <div class="relative mt-2">
                          <label>Passport Copy</label>
                          <input type="file" class="input w-full border mt-2" name="passport_copy" id="passport_copy">
                          <img style="width:200px;" src="/upload_files/{{$profile->passport_copy}}">
                        </div>
                        <div class="relative mt-2">
                          <label>Trade License</label>
                          <input type="file" class="input w-full border mt-2" name="trade_license" id="trade_license">
                          <img style="width:200px;" src="/upload_files/{{$profile->trade_license}}">
                        </div>
                        <div class="relative mt-2">
                          <label>Emirated Id Copy</label>
                          <input type="file" class="input w-full border mt-2" name="emirated_id_copy" id="emirated_id_copy">
                          <img style="width:200px;" src="/upload_files/{{$profile->emirated_id_copy}}">
                        </div>
                    </div>
                </div>
                
                
                <div class="text-right mt-5">
                    <button type="button" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                    <button onclick="Save()" type="button" class="button w-24 bg-theme-1 text-white">Save</button>
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
$('.menu-settings').addClass('top-menu--active');

function Save(){
    $(".label-error").remove();
    $('.input').removeClass('error');
    //alert($("#service_id").val());
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : '/agent/update-profile',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
        console.log(data);                
        $("#form")[0].reset();
        Swal.fire({
            //title: "Please Check Your Email",
            text: 'Successfully Update',
            type: "success",
            confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
            buttonsStyling: false,
        }).then(function() {
            location.reload();
        });
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
            
        