<?php
namespace App\Services;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class ProductCategoryService
{
    public function create( $data, ProductCategory $productCategory = null )
    {
        $category = $productCategory === null ? new ProductCategory : $productCategory;
        $category->author_id = Auth::id();
        $category->name = $data[ 'name' ];
        $category->displays_on_pos = $data[ 'displays_on_pos' ] ?? true;
        $category->save();

        // ProductCategoryAfterCreatedEvent::dispatch( $category );

        return redirect()->back()->with('success', 'La catégorie a été enregistrée avec succès');
    }

    /**
     * Update a specific customer
     * using a provided informations
     *
     * @param App\Models\Provider $category
     * @param array data
     * @return array response
     */
    public function update($category, $data )
    {
        $category = ProductCategory::find($category);

        if ( $category instanceof ProductCategory ) {
            foreach ( $data as $field => $value ) {
                $category->$field = $value;
            }

            $category->author_id = Auth::id();
            $category->update();

        }

        return redirect()->back()->with('success', 'La catégorie a été mise à jour avec succès');
    }

    public function getCategoryParents( $id )
    {
        $current = ProductCategory::find( $id );

        if ( $current instanceof ProductCategory ) {
            if ( ! empty( $current->parent_id ) ) {
                $parent = ProductCategory::where( 'id', $current->parent_id )->first();

                if ( $parent instanceof ProductCategory ) {
                    return collect( $this->getCategoryParents( $parent->id ) )
                        ->flatten()
                        ->prepend( $current->id )
                        ->toArray();
                }
            }

            return [ $current->id ];
        }

    }

    public function getAllCategoryChildrens()
    {
        $categories = ProductCategory::where( 'parent_id', null )->get();

        return $categories->map( fn( $category ) => $this->getCategoryChildrens( $category->id ) )->flatten();
    }
}
