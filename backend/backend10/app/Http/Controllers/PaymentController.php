<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', Auth::id())->orderByDesc('id')->get();
        return response()->json($payments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'string|max:8',
            'provider' => 'string',
            'description' => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        $payment = Payment::create($data);
        return response()->json($payment, 201);
    }

    public function show($id)
    {
        $payment = Payment::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($payment);
    }
}
