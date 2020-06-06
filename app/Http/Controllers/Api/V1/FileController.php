<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $files = File::all();
        if (Auth::user()) {
            $files = $files->makeVisible(['id']);
        }
        return response()->json($files);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'name' => [
                'required',
                Rule::unique('files')
            ],
            'file' => 'required|file'
        ]);

        $file = $request->file('file');
        $filePath = 'uploads/' . preg_replace('%[^\w\d]+%i', '_', $file->getMimeType());
        $fileExtension = $file->getClientOriginalExtension();
        $fileName =  $request->post('name');

        $stored = $file->storeAs($filePath, $fileName . '.' . $fileExtension );
        if (isset($stored)) {
            $model = File::create([
                'name' => $fileName,
                'path' => $filePath,
                'extension' => $fileExtension,
            ]);
            $model->categories()->sync($request->post('categories'));

            return response()->json('successful', 201);
        }
        return response()->json('failed to save file', 501);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json(File::findOrFail($id));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(int $id, Request $request)
    {
        /** @var File $file */
        $file = File::findOrFail($id);
        $this->validate($request, [
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'name' => [
                'required',
                Rule::unique('files')->ignore($id)
            ]
        ]);

        $oldPath = $this->getFilePath($file);

        if ($file->update(['name' => $request->post('name')])) {
            $file->categories()->sync($request->post('categories'));
            $newName = $this->getFilePath($file);
            if ($oldPath != $newName) {
                Storage::move($oldPath, $newName);
            }
        }

        return response()->json($file, 201);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(int $id)
    {
        $file = File::findOrFail($id);
        $fullPath = Storage::path($this->getFilePath($file));
        if (file_exists($fullPath)) {
            $file->download_count++;
            $file->save();
            return response()->download($fullPath);
        }
        return response()->json("File doesn't exist", 410);
    }

    public function toRate(int $id, Request $request)
    {
        $user = Auth::user();
        $file = File::findOrFail($id);
        $rating = Rating::firstOrNew(['user' => $user->id, 'file' => $file->id]);
        if (isset($rating->id)) {
            return response()->json('cannot be reevaluated', 403);
        }

        $this->validate($request, [
            'rating' => 'required|integer|between:1,10'
        ]);
        $rating->rating = $request->post('rating');
        $rating->save();

        return response()->json('successful', 201);
    }

    /**
     * @param File $file
     * @return string
     */
    private function getFilePath(File $file)
    {
        return $file->path . '/' . $file->name . '.' . $file->extension;
    }
}
