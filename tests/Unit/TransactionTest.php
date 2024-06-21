<?php

namespace Tests\Unit;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Services\TransactionService;

use function PHPUnit\Framework\assertEquals;

class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_payer_or_payee_is_invalid(): void
    {

        $transactionService = new TransactionService();

        $data = [
            'payer' => 1345355345534534,
            'payee' => 5345345534534534,
            'value' => 100
        ];
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Usuario não encontrado');
        $transactionService->make_transaction($data);
       

       
        
    }
    public function test_user_type_is_invalid(): void
    {

        $transactionService = new TransactionService();

        $data = [
            'payer' => 1,
            'payee' => 2,
            'value' => 1
        ];
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Lojistas não podem realizar transferencia');
        $transactionService->make_transaction($data);
    }
    public function test_transfer_is_invalid(): void
    {

        $transactionService = new TransactionService();

        $data = [
            'payer' => 2,
            'payee' => 1,
            'value' => 0
        ];
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor da Transferencia não pode ser 0 ou menor que 0');
        $transactionService->make_transaction($data);
    }
    public function test_transfer_is_not_numeric_invalid(): void
    {

        $transactionService = new TransactionService();

        $data = [
            'payer' => 2,
            'payee' => 1,
            'value' => 'asggfgdgfd'
        ];
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor precisa ser do tipo numérico exemplo 1000.00, 100000, 100.00');
        $transactionService->make_transaction($data);
    }
    public function test_transfer_balance_is_invalid(): void
    {

        $transactionService = new TransactionService();

        $data = [
            'payer' => 2,
            'payee' => 1,
            'value' => 42333333333333333324234234234234234234242342342
        ];
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Saldo Insuficiente');
        $transactionService->make_transaction($data);
    }
    public function test_transaction_is_valid(): void
    {

        $transactionService = new TransactionService();

        $data = [
            'payer' => 2,
            'payee' => 1,
            'value' => 20
        ];
        $retorno = $transactionService->make_transaction($data);
        assertEquals('Transação realizada com sucesso', $retorno['message']);
    }
    
    
}
