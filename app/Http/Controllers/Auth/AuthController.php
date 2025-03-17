<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Project Ticketing API",
 *         version="1.0.0",
 *         description="API untuk mengelola berbagai resource"
 *     ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="bearerAuth",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="JWT",
 *         )
 *     )
 * )
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication operations"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register pengguna baru",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"nik", "name", "email", "password"},
     *                 @OA\Property(property="nik", type="string", example="1234567890"),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *                 @OA\Property(property="password", type="string", format="password", example="password123"),
     *                 @OA\Property(property="gender", type="string", example="male", enum={"male", "female"}),
     *                 @OA\Property(property="photo", type="string", format="binary", description="File gambar (jpeg, png, jpg, gif)"),
     *                 @OA\Property(property="surat_tugas", type="string", format="binary", description="File PDF"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registrasi berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ij..."),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *     ),
     * )
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'nik' => 'required|string|unique:users', // NIK harus unik
            'name' => 'required|string',
            'email' => 'required|email|unique:users', // Email harus unik
            'password' => 'required|string|min:8',
            'gender' => 'nullable|string|in:male,female', // Opsional, hanya boleh 'male' atau 'female'
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Opsional, file gambar
            'surat_tugas' => 'nullable|file|mimes:pdf|max:2048', // Opsional, file PDF
        ]);

        // Simpan file photo jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Simpan file surat_tugas jika ada
        $suratTugasPath = null;
        if ($request->hasFile('surat_tugas')) {
            $suratTugasPath = $request->file('surat_tugas')->store('surat_tugas', 'public');
        }

        // Membuat user baru
        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'photo' => $photoPath,
            'surat_tugas' => $suratTugasPath,
        ]);

        // Membuat token untuk user baru
        $token = $user->createToken('auth-token')->accessToken;

        // Mengembalikan response dengan token
        return response()->json(['token' => $token], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login pengguna",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="qwerty12"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ij..."),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->accessToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout pengguna",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out"),
     *         ),
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out']);
    }
}
