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
            $client = new Client();
            $response = $client->request('GET', 'https://run.mocky.io/v3/3708ee60-f48f-40a7-893d-b96292d7ae0b');
            $body = $response->getBody();
            $json = json_decode($body, true);
            Transactions::where('id', $idTransaction)->update(['email_date' =>  date::now()]);

            return $json;
        } catch (\Throwable $th) {
            throw new Exception('Houve um erro Interno ao enviar Email', 500);
        }
       
    }
}