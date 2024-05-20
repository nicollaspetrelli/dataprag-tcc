<input type="hidden" name="productId" value="{{ $product->id }}">
<div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4">
    <div class="grid md:grid-rows-5 gap-4">
        <label class="block">
            <span class="text-gray-700 text-md dark:text-gray-400"> Nome </span>
            <input
                class="clearableInput block mt-3 w-full pr-20 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Nome do Produto" id="productName" name="productName" required
                value="{{ old('productName', $product->name) }}" />
        </label>

        <label class="block">
            <span class="text-gray-700 text-md dark:text-gray-400">Fabricante</span>
            <input
                class="clearableInput block w-full mt-3 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Fabricante do produto" id="manufacturer" required name="manufacturer"
                value="{{ old('manufacturer', $product->manufacturer) }}" />
        </label>

        <label class="block">
            <span class="text-gray-700 text-md dark:text-gray-400">Numero de Registro</span>
            <input
                class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                required minlength="10" placeholder="Numero de registro do Ministerio da Saude" id="registryNumber"
                name="registryNumber" value="{{ old('registryNumber', $product->registryNumber) }}" />
        </label>

        <div class="block">
            <label class="w-full">
                <span class="text-gray-700 text-md dark:text-gray-400">Quantidade</span>
                <input
                    class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                    required placeholder="Quantidade" id="quantity" type="number" name="quantity"
                    value="{{ old('quantity', $product->quantity) }}" />
            </label>
        </div>

        <div class="block">
            <label class="w-full">
                <span class="text-gray-700 text-md dark:text-gray-400">Preço (custo)</span>
                <input
                    class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                    required placeholder="Custo de uma unidade" id="price" name="price"
                    value="{{ old('price', $product->price) }}" />
            </label>
        </div>
    </div>

    <div class="grid md:grid-rows-5 gap-4">
        <div class="flex gap-4">
            <label class="w-full">
                <span class="text-gray-700 text-md dark:text-gray-400">Defensivos</span>
                <input
                    class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                    placeholder="Defensivos" id="defensives" name="defensives" required minlength="3"
                    value="{{ old('defensives', $product->getDescription('defensives')) }}" />
            </label>
            <label class="w-full">
                <span class="text-gray-700 text-md dark:text-gray-400">Grupo Químico</span>
                <input
                    class="clearableInput block w-full mt-3 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                    placeholder="Grupo Químico" id="chemicalGroup" required minlength="3" name="chemicalGroup"
                    value="{{ old('chemicalGroup', $product->getDescription('chemicalGroup')) }}" />
            </label>
        </div>

        <label class="block">
            <span class="text-gray-700 text-md dark:text-gray-400">Princípio Ativo</span>
            <input
                class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Princípio Ativo" id="activeIngredient" name="activeIngredient"
                value="{{ old('activeIngredient', $product->getDescription('activeIngredient')) }}" />
        </label>

        <label class="block">
            <span class="text-gray-700 text-md dark:text-gray-400">Classe Toxicológica</span>
            <input
                class="clearableInput block mt-3 w-full text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-green form-input"
                placeholder="Classe Toxicológica" id="toxicologicalClass"
                name="toxicologicalClass" value="{{ old('toxicologicalClass', $product->getDescription('toxicologicalClass')) }}" />
        </label>

        @if ($isCreate)
            <label class="block">
                <span class="text-gray-700 text-md dark:text-gray-400 mb-3"> Selecione a categoria do produto </span>
                <select
                    required
                    id="category"
                    name="document_id[]"
                    class="pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-green dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-600 focus:placeholder-gray-500 focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-input"
                    type="text">
                </select>
            </label>
        @else
            <label class="block">
                <span class="text-gray-700 text-md dark:text-gray-400 mb-3"> Categoria do produto </span>
                <select
                    required
                    disabled
                    id="category"
                    name="document_id[]"
                    class="pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-green dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-600 focus:placeholder-gray-500 focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-input"
                    type="text">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" selected>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>
        @endif
    </div>
</div>

<div class="mt-6">
    <button type="submit"
        class="mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
        Salvar
    </button>

    <a href="{{ route('products.index') }}"
        class="ml-3 mt-6 mb-3 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-800 border border-transparent rounded-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
        Cancelar
    </a>
</div>
