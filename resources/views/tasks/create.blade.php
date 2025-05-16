@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Add Task</h2>
    <form id="task-form">
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control">
        </div>
        <button class="btn btn-primary">Add Task</button>
    </form>
    <div id="task-message" class="text-danger mt-2"></div>
    <div id="task-success" class="text-success mt-2"></div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
$('#task-form').on('submit', function(e) {
    e.preventDefault();
    $('#task-message').text('');
    $.ajax({
        url: "{{ route('tasks.store') }}",
        type: "POST",
        data: $(this).serialize(),
        headers: { 'Accept': 'application/json' },
        success: function(res) {
            $('#task-form')[0].reset();
            $('#task-success').text('Task added successfully!');
        },
        error: function(xhr) {
            $('#task-message').text('Failed to add task.');
        }
    });
});
</script>
@endsection