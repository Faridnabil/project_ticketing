<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Profile",
 *     description="Operations related to user profiles"
 * )
 */
class ProfileController extends Controller
{
    /**
     * @OA\Put(
     *     path="/api/profile",
     *     summary="Update authenticated user's profile",
     *     tags={"Profile"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Profile updated successfully")
     * )
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return response()->json(['message' => 'Profile updated successfully']);
    }

    /**
     * @OA\Post(
     *     path="/api/profile/photo",
     *     summary="Update user's profile photo",
     *     tags={"Profile"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"photo"},
     *                 @OA\Property(property="photo", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Photo updated successfully"),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maks 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Menghapus foto lama jika ada
        if ($user->photo) {
            File::delete(public_path($user->photo));
        }

        // Upload foto baru
        $file = $request->file('photo');
        $nama_file = time() . "-" . $file->getClientOriginalName();
        $folder = 'uploads/profile_photos';
        $file->move(public_path($folder), $nama_file);
        $path = $folder . "/" . $nama_file;

        // Update path foto di database
        $user->update(['photo' => $path]);

        return response()->json([
            'message' => 'Photo updated successfully',
            'photo_url' => asset($path)
        ]);
    }
}
