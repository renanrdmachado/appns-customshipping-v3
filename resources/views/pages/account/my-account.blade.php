<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minha Conta') }}
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
                            <div>
                                <a href="#" class="js-cancel-account text-red-600 underline text-sm">Cancelar conta</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</x-app-layout>
