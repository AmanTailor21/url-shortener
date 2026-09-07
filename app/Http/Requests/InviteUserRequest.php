<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class InviteUserRequest extends FormRequest
{
    public function authorize(): bool { return in_array($this->user()?->role, ['SuperAdmin', 'Admin'], true); }
    public function rules(): array { return ['company_id' => ['required', 'exists:companies,id'], 'name' => ['required', 'string', 'max:150'], 'email' => ['required', 'email', 'max:255'], 'role' => ['required', 'in:Admin,Member,Sales,Manager']]; }
}
