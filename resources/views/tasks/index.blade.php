@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Your Tasks</h2>
    <form id="filter-form" class="form-inline mb-3">
    <label class="mr-2">Filter by Status:</label>
    <select name="status" class="form-control mr-2">
        <option value="">All</option>
        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
    </select>
    <input type="text" name="search" class="form-control mr-2" placeholder="Search title or description"
        value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Search</button>
</form>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr id="task-row-{{ $task->id }}">
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->due_date }}</td>
                <td>
                    <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $task->id }}"
                        data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                        data-status="{{ $task->status }}" data-due_date="{{ $task->due_date }}">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $task->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="edit-task-form">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-task-id">
                    <div class="form-group">
                        <label>Title</label>
                        <input name="title" id="edit-title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="edit-description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="date" name="due_date" id="edit-due-date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="edit-status" class="form-control">
                            <option>Pending</option>
                            <option>In Progress</option>
                            <option>Completed</option>
                        </select>
                    </div>
                    <div id="edit-task-message" class="text-danger mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(function() {
    
    $(document).on('click', '.edit-btn', function() {
        $('#edit-task-id').val($(this).data('id'));
        $('#edit-title').val($(this).data('title'));
        $('#edit-description').val($(this).data('description'));
        $('#edit-due-date').val($(this).data('due_date'));
        $('#edit-status').val($(this).data('status'));
        $('#edit-task-message').text('');
        $('#editTaskModal').modal('show');
    });

    $(document).on('click', '.delete-btn', function() {
        if (confirm('Delete this task?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '/tasks/' + id,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    $('#task-row-' + id).remove();
                },
                error: function() {
                    alert('Delete failed.');
                }
            });
        }
    });

    $('#edit-task-form').submit(function(e) {
        e.preventDefault();
        var id = $('#edit-task-id').val();
        $.post('/tasks/' + id, {
            _method: 'PUT',
            _token: '{{ csrf_token() }}',
            title: $('#edit-title').val(),
            description: $('#edit-description').val(),
            due_date: $('#edit-due-date').val(),
            status: $('#edit-status').val()
        }).done(function(res) {
            let row = $('#task-row-' + id);
            row.find('td').eq(0).text(res.task.title);
            row.find('td').eq(1).text(res.task.description);
            row.find('td').eq(2).text(res.task.status);
            row.find('td').eq(3).text(res.task.due_date);
            row.find('.edit-btn').data({
                title: res.task.title,
                description: res.task.description,
                status: res.task.status,
                due_date: res.task.due_date
            });
            $('#editTaskModal').modal('hide');
        }).fail(function() {
            $('#edit-task-message').text('Update failed.');
        });
    });

    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        $.get("{{ route('tasks.index') }}", $(this).serialize(), function(data) {
            var tbody = $(data).find('tbody').html();
            $('tbody').html(tbody);
        });
    });

    $('#filter-form select[name="status"]').on('change', function(e) {
        e.preventDefault();
        $('#filter-form').submit();
    });
});
</script>
@endsection