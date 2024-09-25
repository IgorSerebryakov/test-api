<!DOCTYPE html>
<html>
<head>
    <title>Uncompleted Tasks</title>
</head>
<body>
<h1>Your Uncompleted Tasks</h1>

@if($tasks->isEmpty())
    <p>You have no uncompleted tasks at the moment.</p>
@else
    <ul>
        @foreach($tasks as $task)
            <li>{{ $task->name }}
        @endforeach
    </ul>
@endif
</body>
</html>
