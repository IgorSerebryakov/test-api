<!DOCTYPE html>
<html>
<head>
    <title>Невыполненные задачи</title>
</head>
<body>
<h1>Твои невыполненные задачи</h1>

@if($tasks->isEmpty())
    <p>У тебя нет невыполненных задач.</p>
@else
    <ul>
        @foreach($tasks as $task)
            <li>{{ $task->name }}
        @endforeach
    </ul>
@endif
</body>
</html>
