<?php

namespace App\Http\Controllers;
use App\Models\Configuration;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view('admin', [
            'admin' =>Configuration::where('name', '=', 'maintenance-mode')
            ->first(),
        ]);
    }

    public function update(Request $request) {
        $configuration = Configuration::where('name', '=', 'maintenance-mode')
            ->first();
        if ($configuration) {
            $configuration->value = $request->has('maintenance-mode');
        }
        else {
            $configuration = new Configuration();
            $configuration->name = 'maintenance-mode';
            $configuration->value = $request->has('maintenance-mode');
        }

        $configuration->save();
        
        return redirect()
        ->route('admin.index', [
            'admin' =>Configuration::where('name', '=', 'maintenance-mode')
            ->first(),
        ])
        ->with('success', "Successfully updated maintenance mode.");
    }
}
