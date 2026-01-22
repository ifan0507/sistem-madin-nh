<?php

namespace App\Http\Controllers\pegon;

use App\Http\Controllers\Controller;
use App\services\PegonService;
use Illuminate\Http\Request;

class PegonController extends Controller
{
    protected $pegonService;

    public function __construct(PegonService $pegonService)
    {
        $this->pegonService = $pegonService;
    }

    public function transliterate(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500'
        ]);

        $latinText = $request->text;
        $pegonText = $this->pegonService->generate($latinText);

        return response()->json([
            'status' => 'success',
            'data' => [
                'original' => $latinText,
                'pegon' => $pegonText
            ]
        ]);
    }

    // public function transliterate(Request $request)
    // {
    //     // dd(config('pegon_rules.vowels_awal'));
    //     $request->validate(['text' => 'required|string']);

    //     // Jika ada parameter debug di request
    //     if ($request->has('debug')) {
    //         return response()->json([
    //             'status' => 'debug_mode',
    //             'analysis' => $this->pegonService->debugGenerate($request->text)
    //         ]);
    //     }

    //     $pegonText = $this->pegonService->generate($request->text);
    //     return response()->json(['status' => 'success', 'pegon' => $pegonText]);
    // }
}
