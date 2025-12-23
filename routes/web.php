<?php

use App\Events\MessageSent;
use App\Models\MasterMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonashExport;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/form', function () {
    return view('form');
})->name('form');

Route::post('/form', function (Request $request) {
    $data = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'message' => 'required|string|max:5000',
    ]);

    // Simpan ke DB langsung dari $data
    $message = MasterMessage::create($data);

    // Broadcast event
    MessageSent::dispatch($message->name, $message->email, $message->message);

    return redirect()->route('success');
})->name('form.submit');

Route::get('/messages', function () {
    // Ambil 20 pesan terakhir, urut dari yang paling baru ke lama
    $messages = MasterMessage::orderBy('created_at', 'desc')->take(20)->get();

    return response()->json($messages);
});

Route::post('/search', function (Request $request) {
    $search = $request->input('search');
    $results = MasterMessage::where('name', 'like', "%{$search}%")
        ->orWhere('email', 'like', "%{$search}%")
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($results);
});
Route::get('/user/{id}', function ($id) {
    $result = MasterMessage::findOrFail($id);
    return response()->json($result);
});

Route::get('/user/download/{name}', function ($name) {
    $result = MasterMessage::where('name', $name)->firstOrFail();
    $mergedImage = $result->merged_image;

    return view('download', ['mergedImage' => $mergedImage]);
});

Route::get('/search/user', function () {
    return view('search');
});

Route::get('/success', function () {
    return view('success');
})->name('success');

Route::get('/cms', function () {
    $dataMaster = MasterMessage::all();
    return view('master-dashboard', ['dataMaster' => $dataMaster]);
});

// FORM EDIT
Route::get('/cms/message/{id}/edit', function ($id) {
    $data = MasterMessage::findOrFail($id);
    return view('edit-message', ['data' => $data]);
})->name('cms.message.edit');

// UPDATE MESSAGE
Route::put('/cms/message/{id}', function (Request $request, $id) {
    $request->validate([
        'name' => 'required|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    $data = MasterMessage::findOrFail($id);
    $data->name = $request->name;
    $data->message = $request->message;
    $data->save();

    return redirect('/cms')->with('success', 'Message updated successfully');
})->name('cms.message.update');

// DELETE MESSAGE
Route::delete('/cms/message/{id}', function ($id) {
    $data = MasterMessage::findOrFail($id);

    // jika ada file gambar, hapus
    if (!empty($data->merged_image) && Storage::disk('public')->exists($data->merged_image)) {
        Storage::disk('public')->delete($data->merged_image);
    }

    $data->delete();

    return redirect('/cms')->with('success', 'Message deleted');
})->name('cms.message.delete');


Route::get('/download', function () {
    return Excel::download(new MonashExport, 'monash-file.xlsx');
})->name('download');

Route::delete('/delete/all', function(){
    MasterMessage::truncate();
        return redirect('/cms')->with('success', 'All messages deleted successfully.');
})->name('deleteAll');
