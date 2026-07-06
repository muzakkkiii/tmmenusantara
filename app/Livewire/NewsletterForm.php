<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Livewire\Component;

class NewsletterForm extends Component
{
    public string $email = '';
    public string $nama = '';
    public string $website = '';

    public bool $done = false;
    public string $okMessage = '';

    protected function rules(): array
    {
        return [
            'email' => 'required|email|max:160',
            'nama' => 'nullable|string|max:120',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ];
    }

    public function submit(): void
    {
        if (filled($this->website)) {
            $this->done = true;
            $this->okMessage = 'Terima kasih! Email Anda berhasil didaftarkan ke newsletter kami.';
            return;
        }

        $data = $this->validate();
        Subscriber::firstOrCreate(
            ['email' => strtolower($data['email'])],
            ['nama' => $data['nama'] ?? null, 'active' => true]
        );

        $this->done = true;
        $this->okMessage = 'Terima kasih! Email Anda berhasil didaftarkan ke newsletter kami.';
    }

    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
