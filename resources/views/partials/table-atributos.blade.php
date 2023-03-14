<style>
    details {
        border: 1px solid #d4d4d4;
        width: 350px;
        padding: .75em .75em 0;
        /*  margin-top: 5px; */
        box-shadow: 0 0 20px #d4d4d4;
    }

    summary {
        font-weight: bold;
        margin: -.75em -.75em 0;
        padding: .75em;

        background-color: #5f75a4;
        color: #fff;
    }

    details[open] {
        width: 350px;
        padding: .75em;
        border-bottom: 1px solid #d4d4d4;
    }

    details[open] summary {
        width: 350px;
        border-bottom: 1px solid #d4d4d4;
        margin-bottom: 10px;
    }

    .border-bajo {

        border-bottom-style: solid;
        border-bottom-width: thin;
        border-bottom-color: #d4d4d4;
    }



</style>


<div class="">


    @if ($atributos != null && $atributos->count() != 0)
        <details >
            <summary class="bg-dark">{{ __('Otras características') }}</summary>
            @foreach ($atributos as $key => $atributo)
                <div class="border-bajo pb-1  text-muted d-flex align-items-center">
                    <div class="font-semibold ">{{ $atributo->name }}: </div>
                    <div class="text-small ml-4"> {{ json_decode($atributo->value)->{'VALUE'} }}</div>
                </div>
                
            @endforeach



        </details>

    @endif



</div>
