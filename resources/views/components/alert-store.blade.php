<div class="p-4 bg-gray-100 mb-2">

    @if($slot) 
        {{ $slot }}
    @else
        <i class="fa-regular fa-circle-xmark text-red-600"></i> Você deve ativar o APP em sua loja Nuvemshop para poder seguir!<br/>
        <a href="https://www.nuvemshop.com.br/apps/{{ env("NS_APPID") }}/authorize" class="btn btn-primary mt-2 d-inline-block">Ativar APP</a>
    @endif

</div>