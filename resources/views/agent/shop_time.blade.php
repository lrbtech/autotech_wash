@extends('agent.layouts')
@section('extra-css')
@endsection
@section('body-section')
<!-- BEGIN: Content -->
<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Shop Time
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button id="add_new" class="button text-white bg-theme-1 shadow-md mr-2">Update Time</button>
        </div>
    </div>
    <!-- BEGIN: Datatable -->
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="text-center border-b-2 whitespace-no-wrap">Days</th>
                    <th class="text-center border-b-2 whitespace-no-wrap">Open/Closed</th>
                    <th class="text-center border-b-2 whitespace-no-wrap">Opening Time</th>
                    <th class="text-center border-b-2 whitespace-no-wrap">Closing Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shop_time as $key => $row)
                <tr>
                    <td class="text-center border-b">{{$row->days}}</td>
                    <td class="text-center border-b">
                        @if($row->status == 1)
                        Open
                        @else
                        Closed
                        @endif
                    </td>
                    <td class="text-center border-b">{{$row->open_time}}</td>
                    <td class="text-center border-b">{{$row->close_time}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Datatable -->
</div>
<!-- END: Content -->

<!-- BEGIN: Header & Footer Modal -->
<div class="modal" id="time_modal">
    <div class="modal__content modal__content--xl">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 id="modal-title" class="font-medium text-base mr-auto">
                Update Time
            </h2>
        </div>
        <form id="time_form" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id">
        <!-- <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
        </div> -->
        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="text-center border-b-2 whitespace-no-wrap">Days</th>
                            <th class="text-center border-b-2 whitespace-no-wrap">Open/Closed</th>
                            <th class="text-center border-b-2 whitespace-no-wrap">Opening Time</th>
                            <th class="text-center border-b-2 whitespace-no-wrap">Closing Time</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$time = array('12:00 AM','12:30 AM','01:00 AM','01:30 AM','02:00 AM','02:30 AM','03:00 AM','03:30 AM','04:00 AM','04:30 AM','05:00 AM','05:30 AM','06:00 AM','06:30 AM','07:00 AM','07:30 AM','08:00 AM','08:30 AM','09:00 AM','09:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','01:00 PM','01:30 PM','02:00 PM','02:30 PM','03:00 PM','03:30 PM','04:00 PM','04:30 PM','05:00 PM','05:30 PM','06:00 PM','06:30 PM','07:00 PM','07:30 PM','08:00 PM','08:30 PM','09:00 PM','09:30 PM','10:00 PM','10:30 PM','11:00 PM','11:30 PM');
?>
                    @foreach($shop_time as $key => $row)
                    <tr>
                        <td class="text-center border-b">
                            {{$row->days}}
                            <input value="{{$row->id}}" type="hidden" name="timing_id[]">
                        </td>
                        <td class="text-center border-b">
                            <select name="status[]" class="form-control">
                                <option value="">SELECT</option>
                                <option {{$row->status == 1 ?'selected':''}} value="1">Open</option>
                                <option {{$row->status == 2 ?'selected':''}} value="2">Closed</option>
                            </select>
                        </td>

                        <td class="text-center border-b">
                            <select name="open_time[]" class="form-control">
                                <option value="">SELECT</option>
                                @for ($i = 0; $i < 48; $i++) {
                                <option {{$row->open_time == $time[$i] ?'selected':''}} value="{{$time[$i]}}">{{$time[$i]}}</option>
                                @endfor
                            </select>
                        </td>
                        <td class="text-center border-b">
                            <select name="close_time[]" class="form-control">
                                <option value="">SELECT</option>
                                @for ($i = 0; $i < 48; $i++) {
                                <option {{$row->close_time == $time[$i] ?'selected':''}} value="{{$time[$i]}}">{{$time[$i]}}</option>
                                @endfor
                            </select>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
        </div>
        </form>
        <div class="px-5 py-3 text-right border-t border-gray-200">
            <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button>
            <button onclick="timeUpdate()" id="saveButton" type="button" class="button w-20 bg-theme-1 text-white">Save</button>
        </div>
    </div>
</div>
<!-- END: Header & Footer Modal -->
@endsection
@section('extra-js')
<script type="text/javascript">
$('.menu-settings').addClass('top-menu--active');
//$('.product').addClass('top-menu--active');

$('#add_new').click(function(){
    $('#time_modal').modal('show');
    $("#time_form")[0].reset();
});

function timeUpdate(){
  var formData = new FormData($('#time_form')[0]);
    $.ajax({
        url : '/agent/update-store-time',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {                
            $("#time_form")[0].reset();
            $('#time_modal').modal('hide');
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Update',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
              location.reload();
            });
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
@endsection
            
        