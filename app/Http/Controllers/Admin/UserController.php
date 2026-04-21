<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityOrRegency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::all();

        return view('dashboard.admin.user-management.user.index', [
            'users' => $users,
        ]);
    }


    public function create(Request $request)
    {
        $roles = Role::pluck('name', 'name')
            ->all();

        return view('dashboard.admin.user-management.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'nik' => ['required', 'string', 'unique:users,nik'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
            'surat_tugas' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'photo.image' => 'File harus berupa foto.',
            'photo.mimes' => 'Foto harus berupa file dengan tipe: jpg, png, jpeg.',
            'photo.max' => 'Ukuran foto tidak boleh lebih besar dari 2048 kilobyte.',
            'surat_tugas.mimes' => 'File surat tugas harus berupa PDF.',
            'surat_tugas.max' => 'Ukuran file surat tugas tidak boleh lebih besar dari 5120 kilobyte.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
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

            if ($request->has('roles')) {
                $user->assignRole($request->input('roles'));
            }

            DB::commit();

            return redirect()->route('admin.user.index')->with('success', 'User created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(['error' => 'Data gagal disimpan.'])->withInput();
        }
    }



    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('dashboard.admin.user-management.user.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'nik' => ['required', 'string', 'unique:users,nik,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
            'surat_tugas' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'photo.image' => 'File harus berupa foto.',
            'photo.mimes' => 'Foto harus berupa file dengan tipe: jpg, png, jpeg.',
            'photo.max' => 'Ukuran foto tidak boleh lebih besar dari 2048 kilobyte.',
            'surat_tugas.mimes' => 'File surat tugas harus berupa PDF.',
            'surat_tugas.max' => 'Ukuran file surat tugas tidak boleh lebih besar dari 5120 kilobyte.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
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

            if ($request->has('reset_device') && $request->reset_device == '1') {
                $input['assigned_device'] = null;
            }

            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                unset($input['password']);
            }

            $user->update($input);

            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($request->input('roles'));

            DB::commit();

            return redirect()->route('admin.user.index')->with('success', 'User updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(['error' => 'Data gagal disimpan.'])->withInput();
        }
    }




    public function destroy(User $user)
    {
        try {
            if (!$user) {
                // Jika principle tidak ditemukan, kembalikan pesan kesalahan
                return back()->with(['error' => 'user not found.']);
            }

            $user->delete(); // Hapus principle
            return redirect()->route('admin/user')->with('success', 'user deleted successfully');
        } catch (\Throwable $th) {
            // Log activity
            return back()->with('success', 'user deleted failed');
        }
    }
}
