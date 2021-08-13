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
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Chat with Customer
        </h2>
    </div>
    <div class="intro-y chat grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Chat Side Menu -->
        <div class="col-span-12 lg:col-span-4 xxl:col-span-3">
            <!-- <div class="intro-y pr-1">
                <div class="box p-2">
                    <div class="chat__tabs nav-tabs justify-center flex"> <a data-toggle="tab" data-target="#chats" href="javascript:;" class="flex-1 py-2 rounded-md text-center active">Chats</a> <a data-toggle="tab" data-target="#friends" href="javascript:;" class="flex-1 py-2 rounded-md text-center">Friends</a> <a data-toggle="tab" data-target="#profile" href="javascript:;" class="flex-1 py-2 rounded-md text-center">Profile</a> </div>
                </div>
            </div> -->
            <div class="tab-content">
                <div class="tab-content__pane active" id="chats">
                    <!-- <div class="pr-1">
                        <div class="box px-5 pt-5 pb-5 lg:pb-0 mt-5">
                            <div class="relative text-gray-700">
                                <input type="text" class="input input--lg w-full bg-gray-200 pr-10 placeholder-theme-13" placeholder="Search for messages or users...">
                                <i class="w-4 h-4 hidden sm:absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
                            </div>
                        </div>
                    </div> -->
                    <div class="chat__chat-list overflow-y-auto scrollbar-hidden pr-1 pt-1 mt-4">
                        @foreach($customer as $row)
                        <div onclick="viewChat({{$row->id}})" class="intro-x cursor-pointer box relative flex items-center p-5 ">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img class="rounded-full" src="/admin-assets/dist/images/profile-4.jpg">
                                <!-- <div class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div> -->
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium">{{$row->first_name}} {{$row->last_name}}</a> 
                                    <!-- <div class="text-xs text-gray-500 ml-auto">01:10 PM</div> -->
                                </div>
                                <div class="w-full truncate text-gray-600">
                                    {{$row->mobile}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- <div class="intro-x cursor-pointer box relative flex items-center p-5 mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="/admin-assets/dist/images/profile-9.jpg">
                                <div class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium">Leonardo DiCaprio</a> 
                                    <div class="text-xs text-gray-500 ml-auto">06:05 AM</div>
                                </div>
                                <div class="w-full truncate text-gray-600">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500</div>
                            </div>
                            <div class="w-5 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-theme-1 font-medium -mt-1 -mr-1">3</div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Chat Side Menu -->
        <!-- BEGIN: Chat Content -->
        <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9">
            <div class="chat__box box">
                <!-- BEGIN: Chat Active -->
                <div id="full_view" class="hidden h-full flex flex-col">
                
                </div>
                <!-- END: Chat Active -->
                <!-- BEGIN: Chat Default -->
                <div class="h-full flex items-center">
                    <div class="mx-auto text-center">
                        <div class="w-16 h-16 flex-none image-fit rounded-full overflow-hidden mx-auto">
                            <img alt="Midone Tailwind HTML Admin Template" src="/admin-assets/dist/images/profile-4.jpg">
                        </div>
                        <div class="mt-3">
                            <div class="font-medium">Hey, Admin!</div>
                            <div class="text-gray-600 mt-1">Please select a chat to start messaging.</div>
                        </div>
                    </div>
                </div>
                <!-- END: Chat Default -->
            </div>
        </div>
        <!-- END: Chat Content -->
    </div>
</div>
<!-- END: Content -->
@endsection
@section('extra-js')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script type="text/javascript">
$('.chat-customer').addClass('side-menu--active');

// Pusher.logToConsole = true;
// var channel_name = '1';
// //var channel_name = $('#salon_id').val();
// //alert(channel_name);
// var pusher = new Pusher('d879bbf970b3d6f5d84c', {
//     cluster: 'ap2'
// });
// var channel = pusher.subscribe(channel_name);
// channel.bind('chat-admin', function(data) {
//     //console.log(data);
//     alert('hi');
//     //viewChat(channel_name);
// });

function viewChat(id)
{
    $.ajax({
    url : '/admin/get-customer-chat/'+id,
    type: "GET",
    success: function(data)
    {
        $('#full_view').html(data.html);
        callpusher(data.channel_name);
        var element = document.getElementById("chat_view");
        element.scrollTop = element.scrollHeight;
    }
  });
}

function callpusher(name){
    Pusher.logToConsole = true;
    var pusher = new Pusher('d879bbf970b3d6f5d84c', {
        cluster: 'ap2'
    });
    var channel = pusher.subscribe(''+name+'');
    channel.bind('chat-admin', function(data) {
        //console.log(data);
        viewchatpartial(name);
    });
}

function viewchatpartial(id)
{
    $.ajax({
    url : '/admin/view-customer-chat/'+id,
    type: "GET",
    success: function(data)
    {
        $('#chat_view').html(data.html);
        var element = document.getElementById("chat_view");
        element.scrollTop = element.scrollHeight;
    }
  });
}

function SaveChat(){
  //alert($("#service_id").val());
  var formData = new FormData($('#chat_form')[0]);
  $.ajax({
      url : '/admin/save-customer-chat',
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "JSON",
      success: function(data)
      {
        console.log(data);                
        $("#chat_form")[0].reset();
        //toastr.success('Chat Send Successfully', 'Successfully Update');
        Swal.fire({
            //title: "Please Check Your Email",
            text: 'Successfully Send',
            type: "success",
            confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
            buttonsStyling: false,
        }).then(function() {
            viewchatpartial(data);
        });

      },
      error: function (data, errorThrown) {
        var errorData = data.responseJSON.errors;
        $.each(errorData, function(i, obj) {
            //toastr.error();
            Swal.fire({
                //title: "Please Check Your Email",
                text: obj[0],
                type: "error",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            });
        });
      }
  });
}
</script>
@endsection