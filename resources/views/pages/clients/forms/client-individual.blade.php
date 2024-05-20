<input type="hidden" name="client_type" value="{{ $clientType }}">
<div class="grid md:grid-cols-2 gap-4">
    <label class="block">
        <span class="text-gray-700 text-md dark:text-gray-400"> Documento de Identificação </span>
        <div class="text-gray-500 focus-within:text-green-600">
            <input
                class="clearableInput block mt-3 w-full pr-20 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Insira o CPF" id="documentNumberCPF" name="documentNumber"
                required
                minlength="14"
                value="{{ old('documentNumber', $client->documentNumber) }}" />
        </div>
    </label>
    <label class="block">
        <span class="text-gray-700 text-md dark:text-gray-400">Razão social</span>
        <input
            class="clearableInput block w-full mt-3 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
            placeholder="Razão Social do cliente" id="companyName" name="companyName"
            required
            minlength="3"
            value="{{ old('companyName', $client->companyName) }}" />
    </label>
</div>

<div class="grid md:grid-cols-2 gap-4 mt-6">
    <label class="block">
        <span class="text-gray-700 text-md dark:text-gray-400">Nome Fantasia</span>
        <input
            class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
            placeholder="Nome da empresa/marca" id="fantasyName" name="fantasyName"
            required
            minlength="3"
            value="{{ old('fantasyName', $client->fantasyName) }}" />
    </label>
    <label class="block">
        <span class="text-gray-700 text-md dark:text-gray-400">Nome de
            identificação</span>
        <input
            class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
            placeholder="Nome de identificação" id="identificationName"
            required
            minlength="3"
            name="identificationName"
            value="{{ old('identificationName', $client->identificationName) }}" />
    </label>
</div>

<div>
    <label class="block text-2xl mt-6">
        <span class="text-gray-700 text-xl dark:text-gray-400">Endereço Comercial</span>
        <div class="grid md:grid-cols-7 sm:grid-cols-2 gap-4">
            <div
                class="col-span-2 relative mt-4 text-gray-500 focus-within:text-green-600">
                <input
                    class="clearableInput zipcode block w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                    placeholder="CEP" id="zipcodeForSearch" name="zipcode"
                    required
                    minlength="10"
                    value="{{ old('zipcode', $client->zipcode) }}">
                <button
                    class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-r-md active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                    id="btnCep">
                    Consultar
                </button>
            </div>
            <input
                class="clearableInput col-span-4 mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Rua/Avenida" id="street" name="street"
                required
                minlength="3"
                value="{{ old('street', $client->street) }}" />
            <input
                class="clearableInput mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Numero" id="number" name="number"
                required
                value="{{ old('number', $client->number) }}" />
        </div>
        <div class="grid md:grid-cols-6 sm:grid-cols-2 gap-4">
            <input
                class="clearableInput col-span-3 mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Bairro" id="neighborhood" name="neighborhood"
                required
                value="{{ old('neighborhood', $client->neighborhood) }}" />
            <input
                class="clearableInput col-span-2 mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Cidade" id="city" name="city"
                required
                value="{{ old('city', $client->city) }}" />

            <input
                class="clearableInput mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="UF" id="state" name="state"
                required
                minlength="2"
                maxlength="2"
                value="{{ old('state', $client->state) }}" />

            <input
                class="clearableInput col-span-6 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Ponto de Referência" id="referencePoint"
                name="referencePoint"
                minlength="3"
                value="{{ old('referencePoint', $client->referencePoint) }}" />
        </div>
    </label>
</div>
<label class="block text-2xl mt-5 mb-6">
    <span class="text-gray-700 text-xl dark:text-gray-400">Observações</span>
    <textarea
        class="clearableInput block w-full mt-4 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
        rows="3" placeholder="Escreva aqui" id="notes"
        minlength="3"
        name="notes">{{ old('notes', $client->notes) }}</textarea>
</label>

<div>
    <button type="submit"
        class="mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
        Salvar
    </button>

    <button type="button"
        class="clearFormBtn cursor-pointer ml-3 mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-800 border border-transparent rounded-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
        Limpar campos
    </button>

    <button type="button"
        class="backToClientsBtn ml-3 mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-800 border border-transparent rounded-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
        Cancelar
    </button>
</div>