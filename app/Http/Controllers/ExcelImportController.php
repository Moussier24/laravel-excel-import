<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransactionsImport;
use GuzzleHttp\Client;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $array = Excel::toArray(new TransactionsImport, $file);

        $headers = $array[0][0];
        $rows = array_slice($array[0], 1);
        $trans_id_col_index = array_search("Trans_id", $headers);
        $token_col_index = array_search("token", $headers);

        /* foreach ($rows as $row) {
            $trans_id = $row[$trans_id_col_index];
            $token = $row[$token_col_index];

            if ($trans_id && $token) {
                // Récupère la transaction
                // Attention mon modèle Trans n'existe pas, il faut le créer et l'importer
                $transaction = Trans::where('trans_id', $trans_id)->first();

                if ($transaction) {
                    $mode_paiement = $transaction->mode_paiement;
                    // Si le champ est vide ou null et que le mode de paiement est ligdicash
                    if ($mode_paiement == "ligdicash" && empty($transaction->token)) {
                        // Met à jour le champ token
                        $transaction->token = $token;
                        $transaction->save();
                    }
                }
            }
        } */
        /* return response()->json([
            'message' => 'Import réussi!',
        ]); */

        $client = new Client();


        $resp = $client->post('https://ddlab.online/test_back/api/reconsTest', [
            'json' => [
                'transactions' => array_map(function ($row) use ($trans_id_col_index, $token_col_index) {
                    return [
                        'id' => $row[$trans_id_col_index],
                        'token' => $row[$token_col_index],
                    ];
                }, $rows)
            ]
        ]);

        return response()->json(
            [
                'response' => json_decode($resp->getBody()->getContents())
            ]
        );
    }
}