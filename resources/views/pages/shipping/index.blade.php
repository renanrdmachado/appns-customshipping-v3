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
                    <div class="row">
                        <div class="col-md-12">
                            <p>Edite as faixas de CEP para sua loja!</p>
                        </div>
                        <div class="col-md-12 mt-2">
                            <form class="js-shipping-import-xls" method="POST" enctype="multipart/form-data">
                                <strong>Importar CSV</strong><br/>
                                <small>*Ao importar os CEPs via CSV, todos os ceps cadastrados serão substituídos pelo CEPs do CSV.</small><br/>
                                <input type="file" name="my-csv">
                                <input type="submit" value="Enviar" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                    
                </div>

                <div class="p-6 bg-white border-gray-200">

                    @if(!$store)
                        <x-alert-store></x-alert-store>
                    @endif

                    @if($store)
                    <form id="form-zipcodes-range">
                        <table id="zipcodes-range" class="w-full">
                            <tr>
                                <th>Nome</th>
                                <th>Ceps - De</th>
                                <th>Ceps - Até</th>
                                <th>Prazo - Min</th>
                                <th>Prazo - Max</th>
                                <th>Preço</th>
                                <th><i class="fa-solid fa-check"></i></th>
                                <th></th>
                            </tr>

                            @if($shippings)
                                @foreach( $shippings as $shipping )
                                    <tr class="zipcodes-range-item">
                                        <td><input type="text" name="name[]" placeholder="Nome" class="w-full border-gray-100" value="{{ $shipping->name }}"></td>
                                        <td><input type="text" name="from[]" minlength="8" maxlength="8" placeholder="de" class="w-full border-gray-100" value="{{ $shipping->from }}"></td>
                                        <td><input type="text" name="to[]" minlength="8" maxlength="8" placeholder="até" class="w-full border-gray-100" value="{{ $shipping->to }}"></td>
                                        <td><input type="number" name="min_days[]" placeholder="Min" min="0" class="w-full border-gray-100" value="{{ $shipping->min_days }}"></td>
                                        <td><input type="number" name="max_days[]" placeholder="Max" min="0" class="w-full border-gray-100" value="{{ $shipping->max_days }}"></td>
                                        <td><input type="text" name="price[]" placeholder="Preço" class="w-full border-gray-100" value="{{ $shipping->price }}"></td>
                                        <td><input type="checkbox" name="active[]" class="mx-2" @if(isset($shipping->active) && $shipping->active) checked @endif ></td>
                                        <td>
                                            <div class="w-20 p-2">
                                                <a href="javascript:void(0)" class="d-inline ml-2 js-zipcode-table-remove" onclick="MVL.zipcodes.remove( this )"><i class="fa-regular fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            <tr>
                                <td colspan="8">
                                    <div class="zipcodes-table-new-buttons">
                                        <a href="javascript:void(0)" class="js-zipcode-table-new p-2 text-sm text-gray-400 hover:text-gray-900" onclick="MVL.zipcodes.addLine(this)"><i class="fa-solid fa-plus"></i> Adicionar</a>
                                    </div>
                                </td>
                            </tr>

                            <tr class="zipcodes-range-item new hidden">
                                <td><input type="text" name="name[]" placeholder="Nome" class="w-full border-gray-100" disabled></td>
                                <td><input type="text" name="from[]" minlength="8" maxlength="8" placeholder="de" class="w-full border-gray-100" disabled></td>
                                <td><input type="text" name="to[]"  minlength="8" maxlength="8" placeholder="até" class="w-full border-gray-100" disabled></td>
                                <td><input type="number" name="min_days[]" placeholder="Min" min="0" class="w-full border-gray-100" disabled></td>
                                <td><input type="number" name="max_days[]" placeholder="Max" min="0" class="w-full border-gray-100" disabled></td>
                                <td><input type="text" name="price[]" placeholder="Preço" class="w-full border-gray-100" disabled></td>
                                <td><input type="checkbox" name="active[]" class="mx-2 border-gray-100" checked disabled></td>
                                <td>
                                    <div class="w-20 p-2">
                                        <a href="javascript:void(0)" class="d-inline ml-2 js-zipcode-table-remove" onclick="MVL.zipcodes.remove(this)"><i class="fa-regular fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>

                        </table>

                        <div class="mt-4 text-right">
                            <button class="d-inline js-save btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> Salvar</button>
                        </div>
                    </form>
                    @endif

                </div>
            </div>


            
        </div>
    </div>
</x-app-layout>
