<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ceps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>Edite as faixas de CEP para sua loja!</p>
                </div>

                <div class="p-6 bg-white border-gray-200">


                    <form id="form-zipcodes-range">
                        <table id="zipcodes-range" class="w-full">
                            <tr>
                                <th></th>
                                <th>Nome</th>
                                <th>Ceps - De</th>
                                <th>Ceps - Até</th>
                                <th>Prazo - Min</th>
                                <th>Prazo - Max</th>
                                <th>Preço</th>
                                <th></th>
                            </tr>

                            <tr class="zipcodes-range-item">
                                <td><input type="checkbox" name="active[]" class="mr-2" checked></td>
                                <td><input type="text" name="name[]" placeholder="Nome" class="w-full"></td>
                                <td><input type="text" name="from[]" placeholder="de" class="w-full"></td>
                                <td><input type="text" name="to[]" placeholder="até" class="w-full"></td>
                                <td><input type="number" name="min_days[]" placeholder="Min" min="0" class="w-full"></td>
                                <td><input type="number" name="max_days[]" placeholder="Max" min="0" class="w-full"></td>
                                <td><input type="text" name="price[]" placeholder="Preço" class="w-full"></td>
                                <td>
                                    <div class="w-20 p-2">
                                        <button class="d-inline ml-2 js-remove"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="zipcodes-range-item">
                                <td><input type="checkbox" name="active[]" class="mr-2" checked></td>
                                <td><input type="text" name="name[]" placeholder="Nome" class="w-full"></td>
                                <td><input type="text" name="from[]" placeholder="de" class="w-full"></td>
                                <td><input type="text" name="to[]" placeholder="até" class="w-full"></td>
                                <td><input type="number" name="min_days[]" placeholder="Min" min="0" class="w-full"></td>
                                <td><input type="number" name="max_days[]" placeholder="Max" min="0" class="w-full"></td>
                                <td><input type="text" name="price[]" placeholder="Preço" class="w-full"></td>
                                <td>
                                    <div class="w-20 p-2">
                                        <button class="d-inline ml-2 js-remove"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="zipcodes-range-item">
                                <td><input type="checkbox" name="active[]" class="mr-2" checked></td>
                                <td><input type="text" name="name[]" placeholder="Nome" class="w-full"></td>
                                <td><input type="text" name="from[]" placeholder="de" class="w-full"></td>
                                <td><input type="text" name="to[]" placeholder="até" class="w-full"></td>
                                <td><input type="number" name="min_days[]" placeholder="Min" min="0" class="w-full"></td>
                                <td><input type="number" name="max_days[]" placeholder="Max" min="0" class="w-full"></td>
                                <td><input type="text" name="price[]" placeholder="Preço" class="w-full"></td>
                                <td>
                                    <div class="w-20 p-2">
                                        <button class="d-inline ml-2 js-remove"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>

                        </table>

                        <div class="mt-4 text-right">
                            <button class="d-inline js-save btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> Salvar</button>
                        </div>
                    </form>

                </div>
            </div>


            
        </div>
    </div>
</x-app-layout>
