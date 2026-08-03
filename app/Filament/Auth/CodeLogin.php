<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Validation\ValidationException;

class CodeLogin extends BaseLogin
{
    public function mount(): void
    {
        // Login satu pintu: /admin/login, /guru/login, /peserta/login semua
        // otomatis lempar ke halaman login gabungan di /login.
        if (Filament::auth()->check()) {
            $this->redirect(Filament::getUrl());
            return;
        }

        $this->redirect('/login');
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                $this->getCodeFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getCodeFormComponent(): Component
    {
        return TextInput::make('code')
            ->label('Kode Akun')
            ->placeholder('Contoh: GOM001')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['autocapitalize' => 'characters']);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'code'     => $data['code'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.code' => 'Kode akun atau password salah.',
        ]);
    }
}
