<!DOCTYPE html>
<html>
<head>
    <title>Невыполненные задачи</title>
</head>
<body>
<h1>Твои невыполненные задачи</h1>
    <ul>
        @foreach($tasks as $task)
            <li>{{ $task->name }}
        @endforeach
    </ul>
</body>
</html>
