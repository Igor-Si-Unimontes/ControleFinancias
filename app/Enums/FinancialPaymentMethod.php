<?php

namespace App\Enums;

enum FinancialPaymentMethod: string
{
    case CREDIT_CARD = 'credit_card';
    case DEBIT_CARD = 'debit_card';
    case MONEY = 'money';
    case PIX = 'pix';

    public function label(): string
    {
        return match ($this) {
            self::CREDIT_CARD => 'Cartão de Crédito',
            self::DEBIT_CARD => 'Cartão de Débito',
            self::MONEY => 'Dinheiro',
            self::PIX => 'Pix',
        };
    }
    public function value(): array
    {
        return array_column(self::cases(), 'value');
    }
}
