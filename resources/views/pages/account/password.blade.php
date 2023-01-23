<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            <strong>Agora, vamos definir sua senha!</strong>
        </div>

        @if( $errors=="true" ) 

            <div class="mb-4">
                <div class="font-medium text-red-600">
                    Erro ao definir senha!
                </div>
        
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    <li>Verifique se a senha está correta e tente novamente.</li>
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pass.update') }}">
            @csrf

            <!-- Password -->
            <div class="mb-4">
                <x-label for="password" :value="__('Senha')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

            </div>
            <div class="mb-4">

                <x-label for="password" :value="__('Confirmar senha')" />
                <x-input id="password_confirm" class="block mt-1 w-full"
                                type="password"
                                name="password_confirm"
                                required />
            </div>

            <div class="flex justify-end mt-4">
                <x-button>
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>

    </x-auth-card>
</x-guest-layout>
