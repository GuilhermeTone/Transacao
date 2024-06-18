<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transactions;
use App\Services\EmailService;
use Exception;
use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $transactionService;


    public function __construct()
    {
        $this->transactionService = new TransactionService();
    }
    public function make_transaction(TransactionRequest $request)
    {

        try {
            $retorno = $this->transactionService->make_transaction($request->all());

            return response()->json($retorno);
            
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }
}
