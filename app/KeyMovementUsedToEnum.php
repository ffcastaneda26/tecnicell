<?php

namespace App;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Illuminate\Support\Facades\App;

enum KeyMovementUsedToEnum: string implements HasLabel,HasColor,HasIcon
{

    case I = 'I';
    case S = 'S';

    public function getLabel(): ?string
    {
        if(App::isLocale('en')){
            return match ($this) {
                self::I => 'Inventory',
                self::S => 'Sales',
           };
        }
        return match ($this) {
            self::I => 'Inventario',
            self::S => 'Ventas',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::I => 'warning',
            self::S => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::I => 'heroicon-m-currency-dollar',
            self::S => 'heroicon-m-no-symbol',
        };
    }
}
