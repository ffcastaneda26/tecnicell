<?php

namespace App;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Illuminate\Support\Facades\App;
use Filament\Support\Contracts\HasLabel;
enum InvMovementStatusEnum: string implements HasLabel,HasColor,HasIcon
{
    case Pending = 'Pendiente';
    case Applied = 'Aplicado';
    case Cancelled = 'Cancelado';
    case Authorized = 'Autorizado';

    public function getLabel(): ?string
    {
        if(App::isLocale('en')){
            return match ($this) {
                self::Pending => 'Pending',
                self::Applied => 'Applied',
                self::Cancelled => 'Cancelled',
                self::Authorized => 'Authorized',
           };
        }
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Applied => 'Aplicado',
            self::Cancelled => 'Cancelado',
            self::Authorized => 'Autorizado'
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Applied => 'success',
            self::Cancelled => 'danger',
            self::Authorized => 'info'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Pending => 'heroicon-m-exclamation-triangle',
            self::Applied => 'heroicon-m-check-circle',
            self::Cancelled => 'heroicon-m-x-circle',
            self::Authorized => 'heroicon-m-clipboard-document-check',
        };
    }
}
