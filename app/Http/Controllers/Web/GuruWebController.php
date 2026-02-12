<?php

namespace App\Http\Controllers\Web;

use App\Dto\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class GuruWebController extends Controller
{
    public function __construct(
        protected UserService $user_service
    ) {}

    public function index()
    {

        $active = (object)[
            'activePage' => 'guru',
            'activePageMaster' => 'user-management'
        ];

        $gurus = $this->user_service->getAllGuru();

        return view('pages.guru.index', ['active' => $active, 'gurus' => $gurus]);
    }

    public function generateToken()
    {
        return $this->user_service->generateToken();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $dto = UserDto::fromRequest($request);
        $this->user_service->create($dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Guru berhasil ditambahkan'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
