<?php
namespace App\Services;

use App\Models\Provider;
use Illuminate\Support\Facades\Auth;

class ProviderService
{
    public function create( $data )
    {
        $provider = new Provider;

        foreach ( $data as $field => $value ) {
            $provider->$field = $value;
        }

        $provider->author_id = Auth::id();
        $provider->save();

        return redirect()->back()->with('success', 'Le fournisseur a été enregistré avec succès');
    }

    /**
     * Update a specific customer
     * using a provided informations
     *
     * @param App\Models\Provider $provider
     * @param array data
     * @return array response
     */
    public function update($provider, $data )
    {
        $provider = Provider::find($provider);

        if ( $provider instanceof Provider ) {
            foreach ( $data as $field => $value ) {
                $provider->$field = $value;
            }

            $provider->author_id = Auth::id();
            $provider->update();

        }

        return redirect()->back()->with('success', 'Le fournisseur a été mis à jour avec succès');
    }
}
