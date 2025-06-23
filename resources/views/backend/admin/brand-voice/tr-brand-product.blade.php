<tr>
    <td>
        <x-form.input
                name="names[]"
                type="text"
                :showDiv="false"
                value="{{ isset($product) ? $product->name : old('names') }}"
        />
    </td>

    <td>
        <x-form.input
                :showDiv="false"
                name="descriptions[]"
                value="{{ isset($product) ? $product->features : old('descriptions') }}"
                type="text"
        />
    </td>

    <td>
        <x-form.select
                :showDiv="false"
                name="types[]">
            @forelse($types as $type)
                <option value="{{ $type }}" @selected(isset($product) && $product->type == $type) >
                    {{ localize($type) }}
                </option>
            @empty
            @endforelse
        </x-form.select>
    </td>

    <td class="text-center">
        <button type="button" class="btn btn-primary p-0 btn-sm addTr">
            <i data-feather="plus" class="icon-12"></i>
        </button>

        <button type="button" class="btn btn-danger p-0 btn-sm removeTr">
            <i data-feather="trash-2" class="icon-12"></i>
        </button>
    </td>
</tr>