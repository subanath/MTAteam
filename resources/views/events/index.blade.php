@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row">
    <div class="col-md-12"><a class="btn btn-warning"  href="{{ route('createEvents') }}">Create Event</a></div>
        <div class="col-md-12">
<table id="events-table" class="table">
    <thead>
        <tr>
            <th>Event Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
            <!-- Add more columns if needed -->
        </tr>
    </thead>
    <tbody>
        <!-- Loop through events data and display rows -->
        @foreach ($events as $event)
            <tr>
                <td>{{ $event->eventName }}</td>
                <td>{{ $event->startDate }}</td>
                <td>{{ $event->endDate }}</td>
                <td><button type="button" class="btn btn-info btn-lg" onclick="getInvitedUsers(<?=$event->id?>)" >Users List</button></td>
                <!-- Add more columns if needed -->
            </tr>
        @endforeach
    </tbody>
</table>



<!-- Modal -->
<div id="userModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="closePopup()">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body" >
        
       
<div id="usersList">
</div>

       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closePopup()">Close</button>
      </div>
    </div>

  </div>
</div>
        </div>
    </div>
</div>









<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#events-table').DataTable();
    });


    function getInvitedUsers(eventid)
   {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "/getInvitedUsers",
            data : {'eventid':eventid},
            type : 'post',
            dataType : 'json',
            success : function(response){




                var table = $('<table>').attr('id', 'myTable').addClass('table');
        var tableBody = $('<tbody>');

       
        $.each(response.invited_users, function(index, data) {
            var row = $('<tr id="row_'+data.user.id+'">'); 
            row.append($('<td>').text(data.user.fname+' '+data.user.lname)); 
            row.append($('<td>').text(data.user.email)); 
            var button = $('<button>').text('Remove').attr('class', 'btn btn-primary');
            button.on('click', function() {
///////////////////////////////////Remove Users
                            $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url : "/removeInvitedUsers",
                        data : {'id':data.user.id},
                        type : 'post',
                        dataType : 'html',
                        success : function(response){
                            $('#row_' + data.user.id).remove();
                        }
                        });
///////////////////////////////////Remove Users
               
            });
            row.append($('<td>').append(button)); 
            tableBody.append(row); 
        });

        table.append(tableBody); 
        console.log(table);
        $('#usersList').empty().append(table);
      
        // Show the modal popup
        $('#userModal').modal('show');




            }
        });
   }  

   function closePopup()
   {
    $('#userModal').modal('hide');
   }
</script>
@endsection