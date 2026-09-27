<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [LoginController::class, 'submitForm']);

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/acara17/tambah-user', function () {
    DB::table('users')->insert([
        'name' => 'Budi',
        'email' => 'budi@gmail.com',
        'password' => bcrypt('password123'),
        'age' => 20,
        'status' => 'active',
        'points' => 50,
    ]);

    return 'User berhasil ditambahkan!';
});

Route::get('/acara17/insert-id', function () {
    $id = DB::table('users')->insertGetId([
        'name' => 'Jane Doe',
        'email' => 'janedoe@example.com',
        'password' => bcrypt('password123')
    ]);

    return 'Data berhasil ditambahkan dengan ID: ' . $id;
});

Route::get('/acara17/users', function () {
    $users = DB::table('users')->where('age', '>=', 18)->get();

    return $users;
});

Route::get('/acara17/update', function () {
    DB::table('users')
        ->where('email', 'johndoe@example.com')
        ->update(['status' => 'inactive']);

    return 'Data berhasil diperbarui!';
});

Route::get('/acara17/increment', function () {
    DB::table('users')
        ->where('id', 1)
        ->decrement('points', 5);

    return 'Points berhasil berkurang 5!';
});

Route::get('/acara17/delete', function () {
    DB::table('users')
        ->where('id', 1)
        ->delete();

    return 'Data berhasil dihapus!';
});

Route::get('/acara17/pluck', function () {
    $names = DB::table('users')->pluck('name', 'age');

    return $names;
});

Route::get('/acara17/sum', function () {
    $totalUsers = DB::table('users')->sum('points');

    return 'Point: ' . $totalUsers;
});

Route::get('/acara17/join', function () {
    $users = DB::table('users')
        ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
        ->get();

    return $users;
});

Route::get('/acara17/order-by', function () {
    $users = DB::table('users')
        ->orderBy('name', 'asc')
        ->get();

    return $users;
});

Route::get('/acara17/limit', function () {
    $users = DB::table('users')
        ->offset(1)
        ->limit(1)
        ->get();

    return $users;
});

Route::get('/acara17/subquery', function () {
    $users = DB::table('users')
        ->select('name')
        ->selectSub(function ($query) {
            $query->from('orders')
                ->selectRaw('count(*)')
                ->whereColumn('orders.user_id', 'users.id');
        }, 'order_count')
        ->get();

    return $users;
});

Route::get('/acara17/raw-select', function () {
    $users = DB::table('users')
        ->selectRaw('COUNT(*) as total_users, status')
        ->groupBy('status')
        ->get();

    return $users;
});

Route::get('/acara17/raw-where', function () {
    $users = DB::table('users')
        ->whereRaw('age > ? AND status = ?', [18, 'active'])
        ->get();

    return $users;
});

Route::get('/acara18/create', function () {
    User::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password')
    ]);

    return 'Data berhasil ditambahkan!';
});

Route::get('/acara18/save', function () {
    $user = new User;

    $user->name = 'Jane Doe';
    $user->email = 'jane@example.com';
    $user->password = bcrypt('password');

    $user->save();

    return 'Data berhasil ditambahkan dengan save()!';
});

Route::get('/acara18/users', function () {
    $users = User::where('email', 'john@example.com')->firstOrFail();

    return $users;
});

Route::get('/acara18/update', function () {
    $user = User::find(5); 
    $user->name = 'John Updated'; 
    $user->save(); 

    return 'Data berhasil diperbarui dengan save()!';
});

Route::get('/acara18/destroy', function () {
    User::destroy(2);

    return 'Data berhasil dihapus dengan destroy()!';
});