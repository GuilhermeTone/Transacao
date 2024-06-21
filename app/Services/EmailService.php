<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;
use App\Models\Transactions;
use Illuminate\Support\Facades\Date;


class EmailService
{
    public function send_email(int $idTransaction)
    {
        try {
            $json = [
                'message' => 'Email Enviado com sucesso',
            ];

            return $json;
        } catch (\Throwable $th) {
            throw new Exception('Houve um erro Interno ao enviar Email', 500);
        }
       
    }
}