<?php

use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Task;
class Tasks
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public ?string $long_description,
        public bool $completed,
        public string $created_at,
        public string $updated_at
    ) {
    }
}

$tasks = [
    new Tasks(
        1,
        'Buy groceries',
        'Task 1 description',
        'Task 1 long description',
        false,
        '2023-03-01 12:00:00',
        '2023-03-01 12:00:00'
    ),
    new Tasks(
        2,
        'Sell old stuff',
        'Task 2 description',
        null,
        false,
        '2023-03-02 12:00:00',
        '2023-03-02 12:00:00'
    ),
    new Tasks(
        3,
        'Learn programming',
        'Task 3 description',
        'Task 3 long description',
        true,
        '2023-03-03 12:00:00',
        '2023-03-03 12:00:00'
    ),
    new Tasks(
        4,
        'Take dogs for a walk',
        'Task 4 description',
        null,
        false,
        '2023-03-04 12:00:00',
        '2023-03-04 12:00:00'
    ),
];

Route::get('/', function () {
    return redirect()->route('task.index');
});
// Route::get('/task', function () use($tasks) {
//     return view('index',['tasks'=>$tasks]);
// })->name('task.index');

Route::get('/task', function ()  {
    return view('index',['tasks'=>Task::all()]);
})->name('task.index');

// Route::get('/task', function ()  {
//     return view('index',['tasks'=>\App\Models\Task::latest()->get()]);
// })->name('task.index');

Route::get('/task', function ()  {
    //return view('index',['tasks'=>Task::latest()->where('completed',true)->get()]);
    return view('index',['tasks'=>Task::latest()->paginate(10)]);
})->name('task.index');

// Route::get('/{id}',function($id) use($tasks){
//     return 'single page!';
// })->name('task.show');

// Route::get('/task/{id}',function($id) use($tasks){
//     $task = collect($tasks)->firstWhere('id',$id);
//     if(!$task){
//         abort(Response::HTTP_NOT_FOUND);
//     }
//     return view('show',['task'=>$task]);
// })->name('task.show');

//if not passing any data call this
Route::view('/task/create','create')->name('task.create');


// Route::get('/task/{id}/edit',function($id) {
//     return view('edit',['task'=>Task::findOrFail($id)]);
// })->name('task.edit');

//route method binding in which id can be pass as task which is name of the model which take default id automatic
Route::get('/task/{task}/edit',function(Task $task) {
    return view('edit',['task'=>$task]);
})->name('task.edit');

// Route::get('/task/{id}',function($id) {
//     return view('show',['task'=>Task::findOrFail($id)]);
// })->name('task.show');

Route::get('/task/{task}',function(Task $task) {
    return view('show',['task'=> $task]);
})->name('task.show');

Route::post('/task',function(TaskRequest $request){
    // dd($request->all());
    $data = $request->validated();
    // $data = $request->validate([
    //     'title'=>'required|max:255',
    //     'description'=>'required',
    //     'long_description'=>'required']);
    //  $task = new Task;
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();
    $task = Task::create($data);
    return redirect()->route('task.show', ['task'=>$task->id])->with('success','Task created successfully');
})->name('task.store');


// Route::put('/task/{id}',function($id,Request $request){
//     // dd($request->all());
//     $data = $request->validate([
//         'title'=>'required|max:255',
//         'description'=>'required',
//         'long_description'=>'required']);
//     $task = Task::findOrFail($id);
//     $task->title = $data['title'];
//     $task->description = $data['description'];
//     $task->long_description = $data['long_description'];
//     $task->save();
//     return redirect()->route('task.show', ['id'=>$task->id])->with('success','Task edited successfully');
// })->name('task.edit');

Route::put('/task/{task}',function(Task $task,TaskRequest $request){
    $data = $request->validated();
    // dd($request->all());
    // $data = $request->validate([
    //     'title'=>'required|max:255',
    //     'description'=>'required',
    //     'long_description'=>'required']);
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();
    $task->update($data);
    return redirect()->route('task.show', ['task'=>$task->id])->with('success','Task edited successfully');
})->name('task.update');

Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();

    return redirect()->route('task.index')
        ->with('success', 'Task deleted successfully!');
})->name('task.destroy');

Route::put('/task/{task}/toggle-complete',function(Task $task){
    $task->toggleComplete();
    return redirect()->back()->with('success','Task updated successfully');
})->name('task-toggle-complete');
// Route::get('/hello', function () {
//     return 'Main hello Page';
// })->name('mainPage');

// Route::get('/greet/{name}',function($name){
//     return 'Main '.$name.'!';
// });

// Route::get('/hollo', function () {
//     return redirect('/hello');
// });

// Route::get('/hollo', function () {
//     return redirect()->route('mainPage');
// });
Route::fallback(function(){
    return 'Still got somewhere';
});
