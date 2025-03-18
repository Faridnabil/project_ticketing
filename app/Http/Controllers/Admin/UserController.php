<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="API for managing users"
 * )
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="gender", type="string", enum={"Pria", "Wanita"}, example="Pria"),
 *     @OA\Property(property="nik", type="string"),
 *     @OA\Property(property="photo", type="string"),
 *     @OA\Property(property="surat_tugas", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * @OA\Schema(
 *     schema="UserRequest",
 *     type="object",
 *     required={"name", "email", "nik", "password", "roles"},
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="gender", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="nik", type="string"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="password_confirmation", type="string"),
 *     @OA\Property(property="photo", type="string", format="binary"),
 *     @OA\Property(property="surat_tugas", type="string", format="binary"),
 *     @OA\Property(property="roles", type="array", @OA\Items(type="integer"))
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'gender' => ['nullable', 'string', 'in:Pria,Wanita'],
            'nik' => ['required', 'string', 'unique:users,nik'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
            'surat_tugas' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'roles' => ['required', 'array'], // Validasi untuk roles
            'roles.*' => ['exists:roles,id'], // Validasi setiap role harus ada di tabel roles
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'gender.required' => 'Gender harus diisi.',
            'gender.in' => 'Gender hanya boleh "Pria" atau "Wanita".', // Pesan error untuk gender
            'photo.image' => 'File harus berupa foto.',
            'photo.mimes' => 'Foto harus berupa file dengan tipe: jpg, png, jpeg.',
            'photo.max' => 'Ukuran foto tidak boleh lebih besar dari 2048 kilobyte.',
            'surat_tugas.mimes' => 'File surat tugas harus berupa PDF.',
            'surat_tugas.max' => 'Ukuran file surat tugas tidak boleh lebih besar dari 5120 kilobyte.',
            'roles.required' => 'Roles harus diisi.',
            'roles.array' => 'Roles harus berupa array.',
            'roles.*.exists' => 'Role yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();

        try {
            $file1 = $request->file('photo');
            $file2 = $request->file('surat_tugas');

            $pathPublic1 = null;
            $pathPublic2 = null;

            if ($file1 && $file1->isValid()) {
                $nama_file = time() . "-" . $file1->getClientOriginalName();
                $folder = 'file/photo_profiles';
                $file1->move($folder, $nama_file);
                $pathPublic1 = $folder . "/" . $nama_file;
            }

            if ($file2 && $file2->isValid()) {
                $nama_file = time() . "-" . $file2->getClientOriginalName();
                $folder = 'file/surat_tugas';
                $file2->move($folder, $nama_file);
                $pathPublic2 = $folder . "/" . $nama_file;
            }

            $input = $request->all();
            $input['photo'] = $pathPublic1;
            $input['surat_tugas'] = $pathPublic2;
            $input['password'] = Hash::make($request->password);

            $user = User::create($input);

            // Assign roles ke user
            if ($request->has('roles')) {
                $user->assignRole($request->input('roles'));
            }

            DB::commit();

            return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Data gagal disimpan.'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update a user",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'gender' => ['nullable', 'string', 'in:Pria,Wanita'],
            'nik' => ['required', 'string', 'unique:users,nik,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
            'surat_tugas' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'gender.required' => 'Gender harus diisi.',
            'gender.in' => 'Gender hanya boleh "Pria" atau "Wanita".', // Pesan error untuk gender
            'photo.image' => 'File harus berupa foto.',
            'photo.mimes' => 'Foto harus berupa file dengan tipe: jpg, png, jpeg.',
            'photo.max' => 'Ukuran foto tidak boleh lebih besar dari 2048 kilobyte.',
            'surat_tugas.mimes' => 'File surat tugas harus berupa PDF.',
            'surat_tugas.max' => 'Ukuran file surat tugas tidak boleh lebih besar dari 5120 kilobyte.',
            'roles.required' => 'Roles harus diisi.',
            'roles.array' => 'Roles harus berupa array.',
            'roles.*.exists' => 'Role yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();

        try {
            $file1 = $request->file('photo');
            $file2 = $request->file('surat_tugas');

            $previousPhoto = $user->photo;
            $previousSuratTugas = $user->surat_tugas;
            $pathPublic1 = $previousPhoto;
            $pathPublic2 = $previousSuratTugas;

            if ($file1 && $file1->isValid()) {
                $nama_file = time() . "-" . $file1->getClientOriginalName();
                $folder = 'file/photo_profiles';
                $file1->move($folder, $nama_file);
                $pathPublic1 = $folder . "/" . $nama_file;

                if ($previousPhoto && file_exists($previousPhoto)) {
                    File::delete($previousPhoto);
                }
            }

            if ($file2 && $file2->isValid()) {
                $nama_file = time() . "-" . $file2->getClientOriginalName();
                $folder = 'file/surat_tugas';
                $file2->move($folder, $nama_file);
                $pathPublic2 = $folder . "/" . $nama_file;

                if ($previousSuratTugas && file_exists($previousSuratTugas)) {
                    File::delete($previousSuratTugas);
                }
            }

            $input = $request->all();
            $input['photo'] = $pathPublic1;
            $input['surat_tugas'] = $pathPublic2;

            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                unset($input['password']);
            }

            $user->update($input);

            // Hapus roles lama dan assign roles baru
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($request->input('roles'));

            DB::commit();

            return response()->json(['message' => 'User updated successfully', 'user' => $user]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Data gagal disimpan.'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete a user",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="User deletion failed"
     *     )
     * )
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        try {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'User deletion failed'], 500);
        }
    }
}
