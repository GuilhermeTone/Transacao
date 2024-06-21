<?php

namespace App\Services;

use App\Models\Transactions;
use App\Models\Customers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Date;

class TransactionService
{
    protected $emailService;

    public function __construct()
    {
        $this->emailService = new EmailService();
    }
   
    public function make_transaction(array $data)
    {
        $payer = $data['payer'];
        $payee = $data['payee'];
        $value = $data['value'];

        $return = $this->make_validation_transition($payee, $payer, $value);

        if ($return->getStatusCode() == 200) {

            DB::beginTransaction();

            try {
                $customerPayer = Customers::find($payer);
                $customerPayee = Customers::find($payee);

                //Atualiza os saldos
                $customerPayer->balance -= $value;
                $customerPayee->balance += $value;

                //Salva os dados
                $customerPayer->save();
                $customerPayee->save();
                
                //Finaliza transação e cria um log de transação
                DB::commit();
                $transaction = Transactions::create([
                    'email_payer' => $customerPayer->email ?? NULL,
                    'email_payee' => $customerPayee->email ?? NULL,
                    'value' => $value,
                    'status' => 'success',
                    'message' => 'Transferencia realizada com sucesso',
                    'fail_code' =>  NULL,
                    'email_date' => NULL,
                ]);
                //Envia email via serviço e mock
                $this->emailService->send_email($transaction->id);

                return ['message' => 'Transação realizada com sucesso'];
            } catch (Exception $e) {
                $message = 'Houve um erro interno ao realizar a transferencia, entre em contato com o banco';
                $fail_code = 999;
                DB::rollBack();

                Transactions::create([
                    'email_payer' => $customerPayer->email ?? NULL,
                    'email_payee' => $customerPayee->email ?? NULL,
                    'value' => $value,
                    'status' => 'fail',
                    'message' => $message,
                    'fail_code' => $fail_code,
                    'email_date' => NULL,
                ]);

                throw new Exception($message, 500);
            }
        } else {
            return response()->json(['message' => $return->getContent()], $return->getStatusCode());
        }
    }
    private function make_validation_transition($payee, $payer, $value)
    {
        $customerPayer = Customers::where('id', $payer)->first();
        $customerPayee = Customers::where('id', $payee)->first();

        $fail_code = null;
        $message = null;

        try {
            //COMEÇO VALIDAÇÕES
            if (!isset($customerPayer->email) || !isset($customerPayee->email)) {
                $fail_code = 1000;
                $message = 'Usuario não encontrado';
                throw new Exception($message, 404);
            }
            if ($customerPayer->user_type == 'lojista') {
                $fail_code = 1001;
                $message = 'Lojistas não podem realizar transferencia';
                throw new Exception($message, 403);
            }
            if ($value == 0 || $value < 0) {
                $fail_code = 1002;
                $message = 'Valor da Transferencia não pode ser 0 ou menor que 0';
                throw new Exception($message, 400);
            }
            if (!is_numeric($value)) {
                $fail_code = 1003;
                $message = 'Valor precisa ser do tipo numérico exemplo 1000.00, 100000, 100.00';
                throw new Exception($message, 400);
            }
            if ($customerPayer->balance < $value) {
                $fail_code = 1004;
                $message = 'Saldo Insuficiente';
                throw new Exception($message, 400);
                
            }
             //FIM VALIDAÇÕES
            return response()->json($this->authorize_transaction(), 200);
        } catch (Exception $e) {
            Transactions::create([
                'email_payer' => $customerPayer->email ?? NULL,
                'email_payee' => $customerPayee->email ?? NULL,
                'value' => $value,
                'status' => 'fail',
                'message' => $message,
                'fail_code' => $fail_code,
                'email_date' => NULL,
            ]);

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
    private function authorize_transaction(){
        try {
            $json = [
                'message' => 'Transação autorizada'
            ];

            return $json;
        } catch (Exception $e) {
            throw new Exception('Houve um erro Interno ao requisitar autorização', 500);
        }
      
    }
}