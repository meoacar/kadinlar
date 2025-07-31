// Backend API endpoint örneği: Kullanıcı kayıt (register) ve giriş (login)
// Laravel 10, JWT Auth kullanımı

// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/profile', [AuthController::class, 'profile']);
