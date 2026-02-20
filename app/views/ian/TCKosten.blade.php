<form method="POST" action="{{ route('deine.route') }}" class="space-y-4">
    @csrf
    <div class="grid grid-cols-7 gap-3 items-start">
        {{-- 1: Text (50 Zeichen) --}}
        <div class="col-span-1">
            <label class="block text-sm font-medium mb-1" for="feld1">Text</label>
            <input
                id="feld1"
                name="feld1"
                type="text"
                maxlength="50"
                value="{{ old('feld1') }}"
                class="w-full rounded border px-2 py-1"
                placeholder="max 50 Zeichen"
            >
        </div>
        <div class="col-span-1">
            <label class="block text-sm font-medium mb-1" for="n{{ $i }}">N{{ $i-1 }}</label>
            <input
                id="n{{ $i }}"
                name="n{{ $i }}"
                type="number"
                value="{{ old('n'.$i) }}"
                class="w-full rounded border px-2 py-1"
                step="1"
            >
        </div>
            <div class="col-span-1">
            <label class="block text-sm font-medium mb-1" for="n{{ $i }}">N{{ $i-1 }}</label>
            <input
                id="n{{ $i }}"
                name="n{{ $i }}"
                type="number"
                value="{{ old('n'.$i) }}"
                class="w-full rounded border px-2 py-1"
                step="1"
            >
        </div>
    <div class="col-span-1">
            <label class="block text-sm font-medium mb-1" for="n{{ $i }}">N{{ $i-1 }}</label>
            <input
                id="n{{ $i }}"
                name="n{{ $i }}"
                type="number"
                value="{{ old('n'.$i) }}"
                class="w-full rounded border px-2 py-1"
                step="1"
            >
        </div>
    <div class="col-span-1">
            <label class="block text-sm font-medium mb-1" for="n{{ $i }}">N{{ $i-1 }}</label>
            <input
                id="n{{ $i }}"
                name="n{{ $i }}"
                type="number"
                value="{{ old('n'.$i) }}"
                class="w-full rounded border px-2 py-1"
                step="1"
            >
        </div>
        {{-- 6: Bemerkung (300 Zeichen) --}}
        <div class="col-span-1">
            <label class="block text-sm font-medium mb-1" for="bemerkung">Bemerkung</label>
            <textarea
                id="bemerkung"
                name="bemerkung"
                maxlength="300"
                rows="2"
                class="w-full rounded border px-2 py-1"
                placeholder="max 300 Zeichen"
            >{{ old('bemerkung') }}</textarea>
        </div>
        {{-- 7: Action (optional) --}}
        <div class="col-span-1 flex items-end">
            <button type="submit" class="w-full rounded border px-3 py-1">
                Speichern
            </button>
        </div>
    </div>
</form>