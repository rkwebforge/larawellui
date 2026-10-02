// The browser's checks are for convenience; validate the same limits in your Form Request.
use Illuminate\Validation\Rules\File;

public function rules(): array
{
    return [
        'contract' => ['required', File::types(['pdf'])->max('5mb')],
        // multiple: the array, then each file in it.
        'attachments' => ['array', 'max:5'],
        'attachments.*' => [File::types(['pdf', 'png', 'jpg', 'jpeg', 'webp'])->max('10mb')],
        'avatar' => ['nullable', File::image()->max('2mb')],
        'remove_avatar' => ['boolean'],
    ];
}
