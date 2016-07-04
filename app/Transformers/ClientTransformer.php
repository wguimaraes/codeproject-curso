<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Client;
use League\Fractal\TransformerAbstract;

/**
 * Description of ClientTransformer
 *
 * @author William
 */
class ClientTransformer extends TransformerAbstract {
    
    public function transform(Client $client){
        return[
            'client_id' => $client->id,
            'client_name' => $client->name,
            'responsible' => $client->responsible,
            'email' => $client->email,
            'phone' => $client->phone,
            'address' => $client->address,
            'obs' => $client->obs,
            'create_at' => $client->create_at,
            'update_at' => $client->update_at,
        ];
    }
    
}
