// upload-url: a route that stores one file (the request field is "file") and answers with its id. A 422 with
// errors.file shows that message on the file's row. Authorize it like any other write.
Route::post('/uploads', StoreUploadController::class)->middleware('auth')->name('uploads.store');

final class StoreUploadController
{
    // StoreUploadRequest: ['file' => ['required', File::default()->max('10mb')]], and authorize() for who may upload.
    public function __invoke(StoreUploadRequest $request): JsonResponse
    {
        $upload = $request->user()->uploads()->create([
            'path' => $request->file('file')->store('uploads'),
            'name' => $request->file('file')->getClientOriginalName(),
            'size' => $request->file('file')->getSize(),
        ]);

        return response()->json(['id' => $upload->id]);
    }
}

// The form then submits documents[] with those ids: check each belongs to the user before attaching it,
// and delete uploads nobody claimed after a day (a scheduled job), since a picked file may never be submitted.
