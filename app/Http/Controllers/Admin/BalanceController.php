<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MoneyValidationFormRequest;
use App\User;
use App\Models\Historic;

class BalanceController extends Controller
{
    private $totalPage = 2;

    public function index()
    {
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;

        return view('admin.balance.index', compact('amount'));
    }

    public function deposit()
    {
        return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->deposit($request->value);

        if ($response['success']) {
            return redirect()
                            ->route('admin.balance')
                            ->with('success', $response['message']);
        }

        return redirect()
                        ->back()
                        ->with('error', $response['message']);
    }

    public function sacar()
    {
        return view('admin.balance.sacar');
    }

    public function saqueStore(MoneyValidationFormRequest $request)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->saque($request->value);

        if ($response['success']) {
            return redirect()
                            ->route('admin.balance')
                            ->with('success', $response['message']);
        }

        return redirect()
                        ->back()
                        ->with('error', $response['message']);
    }

    public function tranferencia()
    {
        return view('admin.balance.tranferencia');
    }

    public function confirmTransfer(Request $request, User $user)
    {
        if (!$sender = $user->getSender($request->sender)) {
            return redirect()
                    ->back()
                    ->with('error', 'Usuario não foi encontrado');
        }

        if ($sender->id === auth()->user()->id) {
            return redirect()
                    ->back()
                    ->with('error', 'Impossivel transferir par você mesmo');
        }

        $balance = auth()->user()->balance;

        return view('admin.balance.transferencia-confirmacao', compact('sender', 'balance'));
    }

    public function tranferenciaStore(Request $request, User $user)
    {
        if (!$sender = $user->find($request->sender_id)) {
            return redirect()
                            ->route('admin.balance')
                            ->with('success', 'Recebedor não encontrado');
        }

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->transfer($request->value, $sender);

        if ($response['success']) {
            return redirect()
                            ->route('admin.balance')
                            ->with('success', $response['message']);
        }

        return redirect()
                        ->back()
                        ->with('error', $response['message']);
    }

    public function historic(Historic $his)
    {
        $historic = auth()
            ->user()
            ->historics()
            ->with(['userSender'])
            ->paginate($this->totalPage);

        $types = $his->type();

        return view('admin.balance.historics', compact('historic', 'types'));
    }

    public function serachHistoric(Request $request, Historic $his)
    {
        $dataForm = $request->except('_token');

        $historic = $his->search($dataForm, $this->totalPage);

        $types = $his->type();

        return view('admin.balance.historics', compact('historic', 'types', 'dataForm'));
    }
}
