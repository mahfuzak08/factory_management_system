<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function receiveData(Request $request)
    {
        // Validate incoming data if needed
        // $validatedData = $request->validate([
        //     'key1' => 'required',
        //     'key2' => 'required',
        //     // Add more validation rules as needed
        // ]);

        // Process the received data
        // $key1 = $request->input('key1');
        // $key2 = $request->input('key2');
        // Process other data as needed

        // Return a response (optional)
        return response()->json($request->input());
        // return response()->json(['message' => 'Data received successfully', 'data' => $validatedData]);
    }
}
