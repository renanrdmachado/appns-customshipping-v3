<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assinatura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="row">
                <div class="col-md-3">
                    <x-account-menu></x-account-menu>
                </div>
                <div class="col-md-9">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            
                            @if($status=="START")
                                <div class="badge">
                                    Falta pouco!<br/>
                                    <strong>Assine agora e aproveite todos os benefícios!</strong>
                                </div>
                            
                                <div class="collapse-group">
                                    <div class="collapse-header">
                                        Solicitar assinatura
                                    </div>
                                    <div class="collapse-body">
                                        <form id="subscriptionsNew" action="{{ Route('subscriptions') }}" method="POST">
                                            @csrf
                                            <label class="d-block mb-2">
                                                Nome<br/>
                                                <input type="text" name="name" class="w-full" placeholder="Ex.: José Maria" value="{{ $user->name }}" required>
                                            </label>
                                            <label class="d-block mb-2">
                                                CPF / CNPJ<br/>
                                                <input type="text" name="cpfCnpj" class="w-full" placeholder="Ex.: 577.359.400-50" required>
                                            </label>
                                            <label class="d-block mb-2">
                                                E-mail<br/>
                                                <input type="text" name="email" class="w-full" placeholder="Ex.: jose@minhaloja.com.br" value="{{ $user->email }}" required>
                                            </label>
                                            <label class="d-block mb-2">
                                                Plano<br/>
                                                <select name="cycle" id="" class="w-full">
                                                    <option value="MONTHLY">Mensal</option>
                                                    <option value="YEARLY">Anual</option>
                                                </select>
                                            </label>
                                            <div class="d-block">
                                                <button class="btn btn-primary">ASSINAR</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            @if($status=="PENDING")
                                <div class="badge d-block mb-4">
                                    Pendente!<br/>
                                    <strong>O status de sua assinatura está pendente.</strong>
                                </div>
                                @if( isset($store->subscription_data) )
                                <div class=" mb-4">
                                    <p>Última atualização: <span class="js-subscriptionLastVerification">{{ $store->updated_at ?? "yyyy/mm/dd" }}</span></p>
                                    @php
                                        $subscription_data = json_decode($store->subscription_data);
                                    @endphp
                                    @if( isset($subscription_data->payments) )
                                    <p>Próximo pagamento: <span class="js-subscriptionNextDueDate">{{ $subscription_data->payments->dueDate  }}</span></p>
                                    <p>Link para pagamento: <a href="{{ $subscription_data->payments->invoiceUrl }}" target="_blank">{{ $subscription_data->payments->invoiceUrl }}</a></p>
                                    @endif
                                </div>
                                @endif
                            @endif

                            @if($status=="RECEIVED")
                                <div class="badge d-block mb-4">
                                    <strong>Tudo certo!</strong>
                                </div>
                                @if( isset($store->subscription_data) )
                                <div class=" mb-4">
                                    <p>Última atualização: <span class="js-subscriptionLastVerification">{{ $store->updated_at ?? "yyyy/mm/dd" }}</span></p>
                                    @php
                                        $subscription_data = json_decode($store->subscription_data);
                                    @endphp
                                    @if( isset($subscription_data->payments) )
                                    <p>Próximo pagamento: <span class="js-subscriptionNextDueDate">{{ $subscription_data->payments->dueDate  }}</span></p>
                                    @endif
                                </div>
                                @endif
                            @endif

                            @if( $status != "START" )
                                <button class="js-subscriptionRefresh btn btn-primary">Verificar assinatura!</button>
                            @endif

                    </div>
                </div>
            </div>

            
        </div>
    </div>
</x-app-layout>
