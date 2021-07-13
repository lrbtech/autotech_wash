<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="/images/logo_icon.png" rel="shortcut icon">
        <title>Create Password</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="/admin-assets/dist/css/app.css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('toastr/toastr.css')}}">
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Register Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="" class="-intro-x flex items-center pt-5">
                        <img alt="Midone Tailwind HTML Admin Template" class="w-6" src="/admin-assets/dist/images/logo.svg">
                        <span class="text-white text-lg ml-3"> Mid<span class="font-medium">One</span> </span>
                    </a>
                    <div class="my-auto">
                        <img alt="Midone Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="/admin-assets/dist/images/illustration.svg">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            A few more clicks to 
                            <br>
                            sign up to your account.
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white">Manage all your e-commerce accounts in one place</div>
                    </div>
                </div>
                <!-- END: Register Info -->
                <!-- BEGIN: Register Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <?php
                    $today = date('Y-m-d');
                    ?>
                    @if($agent->status == '0')
                    @if($agent->end_date >= $today)
                    <form id="form" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id" value="{{$id}}">
                    <input type="hidden" name="agent_id" id="agent_id" value="{{$agent->agent_id}}">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Create Password
                        </h2>
                        <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                        <div class="intro-x mt-8">

                            <input type="text" class="intro-x login__input input input--lg border border-gray-300 block mt-4" placeholder="Password">

                            <input type="text" class="intro-x login__input input input--lg border border-gray-300 block mt-4" placeholder="Password Confirmation">

                        </div>
                        <!-- <div class="intro-x flex items-center text-gray-700 mt-4 text-xs sm:text-sm">
                            <input type="checkbox" class="input border mr-2" id="remember-me">
                            <label class="cursor-pointer select-none" for="remember-me">I agree to the Envato</label>
                            <a class="text-theme-1 ml-1" href="">Privacy Policy</a>. 
                        </div> -->
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button type="button" onclick="Save()" class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3">Register</button>
                            <button class="button button--lg w-full xl:w-32 text-gray-700 border border-gray-300 mt-3 xl:mt-0">Sign in</button>
                        </div>
                    </form>
                    @else
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Your Link has Expired
                    </h2>
                    @endif
                    @else
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Already Register Your Password
                    </h2>
                    @endif
                    </div>
                </div>
                <!-- END: Register Form -->
            </div>
        </div>
        <!-- BEGIN: JS Assets-->
        <script src="/admin-assets/dist/js/app.js"></script>
        <script src="{{ asset('toastr/toastr.min.js')}}"></script>
        <!-- END: JS Assets-->
    </body>
<script type="text/javascript">
// $('.salon').addClass('active');
function Save(){
  var formData = new FormData($('#form')[0]);
    $.ajax({
        url : '/agent-update-password',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {                
            $("#form")[0].reset();
            //toastr.success(data, 'Successfully Update');
            alert('Successfully Update');
            window.location.href="/login";
        },error: function (data) {
            var errorData = data.responseJSON.errors;
            $.each(errorData, function(i, obj) {
                //toastr.error(obj[0]);
                alert(obj[0]);
            });
        }
    });
}
</script>
</html>