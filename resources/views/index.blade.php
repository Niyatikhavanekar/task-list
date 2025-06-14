@extends('layouts.app')

@section('title','The list of tasks')
{{-- <h1>hello Im a blade template</h1>
@isset($name)
    Name is : {{ $name }}
@endisset --}}
@section('content')
    {{-- @if(count($tasks))
        <h2>The list of tasks</h2>
        @foreach($tasks as $task)
            <div>{{$task->title}}</div>
        @endforeach
    @else
        <div>There is no tasks</div>
    @endif

    @forelse ($tasks as $task)
        <div>{{$task->title}}</div>
    @empty
        <div>There is no tasks</div>
    @endforelse --}}
    <nav class="mb-4">
        <a href="{{route('task.create')}}" class="link">Add Task</a>
    </nav>
    @forelse ($tasks as $task)
        <div>
            <a href="{{route('task.show',['task'=>$task])}}" @class(['font-bold','line-through' => $task->completed])>{{$task->title}}</a>
        </div>
    @empty
        <div>There is no tasks</div>
    @endforelse

    @if($tasks->count())
        <nav class="mt-4">
            {{ $tasks->links()}}
        </nav>
    @endif
@endsection
