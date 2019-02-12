<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit(float $value): array
    {
        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += number_format($value, 2, '.', '');
        $deposit = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'I',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Ymd'),
        ]);

        if ($deposit && $historic) {
            DB::commit();

            return ['success' => true, 'message' => 'Sucesso ao recarregar'];
        } else {
            DB::rollback();

            return ['success' => false, 'message' => 'Se fodeu'];
        }
    }

    public function saque(float $value): array
    {
        if ($this->amount < $value) {
            return [
                'success' => false,
                'message' => 'Saldo Insuficiente',
            ];
        }

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', '');
        $saque = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'O',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Ymd'),
        ]);

        if ($saque && $historic) {
            DB::commit();

            return ['success' => true, 'message' => 'Sucesso ao realizar o saque'];
        } else {
            DB::rollback();

            return ['success' => false, 'message' => 'Deu Ruim...'];
        }
    }

    public function transfer(float $value, User $sender): array
    {
        if ($this->amount < $value) {
            return [
                'success' => false,
                'message' => 'Saldo Insuficiente',
            ];
        }

        DB::beginTransaction();

        $total_before = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', '');
        $transfer = $this->save();

        $historic = $sender->historics()->create([
            'type' => 'T',
            'amount' => $value,
            'total_before' => $total_before,
            'total_after' => $this->amount,
            'date' => date('Ymd'),
            'user_id_transaction' => $sender->id,
        ]);

        $senderBalance = $sender->balance()->firstOrCreate([]);
        $totalBeforeSender = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format($value, 2, '.', '');
        $transferSender = $senderBalance->save();

        $historicSender = $sender->historics()->create([
            'type' => 'I',
            'amount' => $value,
            'total_before' => $totalBeforeSender,
            'total_after' => $senderBalance->amount,
            'date' => date('Ymd'),
            'user_id_transaction' => auth()->user()->id,
        ]);

        if ($transfer && $historic && $transferSender && $historicSender) {
            DB::commit();

            return ['success' => true, 'message' => 'Sucesso ao realizar transferencia'];
        } else {
            DB::rollback();

            return ['success' => false, 'message' => 'Deu Ruim...'];
        }
    }
}
