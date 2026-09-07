<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CreateShortUrlRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['long_url' => ['required', 'url', 'max:2000']]; }
}
