@component('mail::message')

    # {{ __( 'Stock Adjustment' ) }}

    {{ sprintf(
            __( 'The product stock has been updated for __%s__. In order to see, please click on the following link' ),
            Auth::user()->email
        )
    }}

@component('mail::button', ['url' => route( 'report.flux-history', [
    'user'  =>  Auth::id(),
    'token' =>  'useractivation'
]) ])
{{ __( 'Proceed' ) }}
@endcomponent

@endcomponent
