<?php
namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClientService
{
    public function create( $data )
    {
        $client = new Client;

        // foreach ( $data as $field => $value ) {
        //     $client->$field = $value;
        // }

        $client->name = $data['name'];
        $client->email = $data['email'];
        $client->first_name = $data['first_name'];
        $client->phone = $data['phone'];
        $client->gender = $data['gender'];

        $client->author_id = Auth::id();
        $client->save();

        return redirect()->back()->with('success', 'Le client a été enregistré avec succès');
    }

    /**
     * Update a specific customer
     * using a provided informations
     *
     * @param App\Models\Provider $client
     * @param array data
     * @return array response
     */
    public function update($client, $data )
    {
        $client = Client::find($client);

        if ( $client instanceof Client ) {
            foreach ( $data as $field => $value ) {
                $client->$field = $value;
            }

            $client->author_id = Auth::id();
            $client->update();

        }

        return redirect()->back()->with('success', 'Le client a été mis à jour avec succès');
    }
}
