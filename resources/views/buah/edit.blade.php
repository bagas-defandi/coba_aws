<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Edit Buah \"{$buah->nama}\"") }}
        </h2>
    </x-slot>

    <div x-data="{ withVariation: '{{ old('with_variation') ?? isset($buah->harga) ? 'tidak' : 'ya' }}', }" class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <img style="height: 200px" class="mx-auto" src="{{ asset($buah->gambar) }}" alt="{{ $buah->nama }}">
        <form method="POST" action="{{ route('buahs.update', $buah) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="mt-4">
                <x-input-label for="nama" :value="__('Nama')" />
                @php  $nama = old('nama') ?? $buah->nama; @endphp
                <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="$nama"
                    autocomplete="nama" />
                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
            </div>


            <!-- Harga & Berat -->
            <div class="mt-4" x-show="withVariation == 'tidak'">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="harga" :value="__('Harga')" />
                        @php  $harga = old('harga') ?? $buah->harga; @endphp
                        <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga"
                            :value="$harga" autocomplete="harga" />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="berat" :value="__('Jumlah Berat')" />
                        @php  $berat = old('berat') ?? $buah->berat; @endphp
                        <x-text-input id="berat" class="block mt-1 w-full" type="text" name="berat"
                            :value="$berat" autocomplete="berat" />
                        <x-input-error :messages="$errors->get('berat')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="satuan_berat" :value="__('Berat')" />
                        <select id="satuan_berat" name="satuan_berat"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="kg" @selected((old('satuan_berat') ?? $buah->satuan_berat) == 'kg')>Kilogram</option>
                            <option value="gr" @selected((old('satuan_berat') ?? $buah->satuan_berat) == 'gr')>Gram</option>
                        </select>
                        <x-input-error :messages="$errors->get('satuan_berat')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Stok -->
            <div class="mt-4" x-show="withVariation == 'tidak'">
                <x-input-label for="stok" :value="__('Stok')" />
                @php  $stok = old('stok') ?? $buah->stok; @endphp
                <x-text-input id="stok" class="block mt-1 w-full" type="text" name="stok" :value="$stok"
                    autocomplete="stok" />
                <x-input-error :messages="$errors->get('stok')" class="mt-2" />
            </div>

            <!-- Gambar -->
            <div class="mt-4">
                <x-input-label for="gambar" :value="__('Gambar')" />
                <input
                    class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 py-4 px-3 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="gambar_info_help" id="gambar" type="file" name="gambar">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="gambar_info_help">
                    Format File SVG, PNG, JPG atau GIF (MAKS. 5MB).</p>
                <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
            </div>

            <div class="flex items-center mt-4">
                <x-primary-button class="">
                    {{ __('Edit') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
