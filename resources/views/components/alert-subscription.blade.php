<div class="p-4 bg-gray-100 mb-2">
    @if($slot != "") 
        {{ $slot }}
    @else
        <i class="fa-regular fa-circle-xmark text-red-600"></i> Algo de errado com sua assinatura!<br/>
        <a href="{{ route("subscriptions") }}" class="btn btn-primary mt-2 d-inline-block">Verificar assinatura</a>
    @endif

</div>