<?php

namespace App\Filament\Resources\QrCodes\Pages;

use App\Filament\Resources\QrCodes\QrCodeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateQrCode extends CreateRecord
{
    protected static string $resource = QrCodeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $data['user_id'] = $user ? $user->id : 1;
        $data['slug'] = \Illuminate\Support\Str::random(8);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Handle file upload for content relationship
        if (isset($this->data['content']['profile_photo_path'])) {
            $file = $this->data['content']['profile_photo_path'];

            if (is_array($file) && isset($file[0])) {
                $filePath = $file[0];

                // Move the file from temporary location to final location
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
                    $newPath = 'profile-photos/' . basename($filePath);
                    \Illuminate\Support\Facades\Storage::disk('public')->move($filePath, $newPath);

                    // Update the content record with the correct path
                    $this->record->content()->update([
                        'profile_photo_path' => $newPath
                    ]);
                }
            }
        }
    }
}
