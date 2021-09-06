@extends('layouts.app')

@section('contents')
<div class="container" style="margin-top:200px;">
    <div class="row d-flex justify-content-center">
        <div class="col-md-2">
            <label for="">Enter Task</label>
            <input type="text" placeholder="Enter task" class="form-control form-control-sm" name="task_name"  id="task_name" value="">
            <font style="color:red"> {{ $errors->has('task_name') ?  $errors->first('task_name') : '' }} </font>
        </div>
        <div class="col-md-2">
            <label for="">Enter Cost</label>
            <input type="number" placeholder="Enter task" class="form-control form-control-sm" name="cost"  id="cost" value="">
            <font style="color:red"> {{ $errors->has('cost') ?  $errors->first('cost') : '' }} </font>
        </div>
        <div class="col-md-2" style="margin-top:26px;">
            <button id="addMore" class="btn btn-success btn-sm">Add More </button>
        </div>
    </div>
    <div class="row d-flex justify-content-center" style="margin-top:26px;">
        <div class="col-md-6">
            <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
                <table class="table table-sm table-bordered" style="display: none;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Cost</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                <tbody id="addRow" class="addRow">

                </tbody>
                <tbody>
                    <tr>
                        <td colspan="1" class="text-right">
                            <strong>Total:</strong>
                        </td>
                        <td>
                            <input type="number" id="estimated_ammount" class="estimated_ammount" value="0" readonly>
                        </td>
                    </tr>
                </tbody>

                </table>
                <button type="submit" class="btn btn-success btn-sm" id="submit">Submit</button>
            </form>

        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-6">
            <table class="table table-border table-striped">
                <tr>
                    <th>Task</th>
                    <th>Cost</th>
                </tr>

                @forelse ($tasks as $task)
                    <tr>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->cost }}</td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <th colspan="2">no data found</th>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</div>


<script src="//code.jquery.com/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>

<script id="document-template" type="text/x-handlebars-template">
<tr class="delete_add_more_item" id="delete_add_more_item">

    <td>
      <input type="text" name="task_name[]" value="@{{ task_name }}">
    </td>
    <td>
      <input type="number" class="cost" name="cost[]" value="@{{ cost }}">
    </td>

    <td>
     <i class="removeaddmore" style="cursor:pointer;color:red;">Remove</i>
    </td>

</tr>
</script>

<script type="text/javascript">
$('#submit').hide();

$(document).on('click','#addMore',function(){

   $('.table').show();
   $('#submit').show();

   var task_name = $("#task_name").val();
   var cost = $("#cost").val();
   var source = $("#document-template").html();
   var template = Handlebars.compile(source);


   var data = {
      task_name: task_name,
      cost: cost
   }

   var html = template(data);
   $("#addRow").append(html)

   total_ammount_price();
});

$(document).on('click','.removeaddmore',function(event){
  $(this).closest('.delete_add_more_item').remove();
  total_ammount_price();
});

function total_ammount_price() {
  var sum = 0;
  $('.cost').each(function(){
    var value = $(this).val();
    if(value.length != 0)
    {
      sum += parseFloat(value);
    }
  });
  $('#estimated_ammount').val(sum);
}

</script>
@endsection
