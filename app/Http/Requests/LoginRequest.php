<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    private string $throttleKey;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->throttleKey = Str::lower($this->input('email')) . '|' . $this->ip();
    }

    public function authenticate(): void
    {
        if ($this->isRateLimited()) {
            $this->sendLockoutResponse();
        }

        if (!Auth::attempt($this->only('email', 'password'), $this->filled('remember'))) {
            RateLimiter::hit($this->throttleKey);
            throw ValidationException::withMessages([
                'email' => __('Invalid credentials.'),
            ]);
        }

        RateLimiter::clear($this->throttleKey);
    }

    private function isRateLimited(): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey, 5);
    }

    private function sendLockoutResponse(): void
    {
        throw ValidationException::withMessages([
            'email' => __('Too many login attempts. Please try again in :seconds seconds.', [
                'seconds' => RateLimiter::availableIn($this->throttleKey),
            ]),
        ]);
    }
}

