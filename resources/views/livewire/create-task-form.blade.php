<div class="flex items-center justify-center">
    <form wire:submit.prevent="save" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        @if ($success_message)
            <div class="rounded-md bg-green-50 p-4 mt-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm leading-5 font-medium text-green-800">
                            {{ $success_message }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div>
            <label class="block font-medium font-bold text-slate-700" for="name">Nombre:</label>
            <input wire:model.defer="name" 
                type="text" 
                id="name"
                name="name" 
                placeholder="Nombre Tarea"
                class="text-sm font-medium @error('name')border border-red @enderror"
                value="{{ old('name')}}"
            />

            @error('name')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
            <br>
        </div>
        
        <div>
            <label class="block font-medium font-bold text-slate-700" for="description">Cuadro de Texto:</label>
            <textarea wire:model="description" 
                    id="description" 
                    name="description" 
                    rows="4" cols="50"
                    class="text-sm font-medium @error('name')border border-red @enderror"
                    value="{{ old('description') }}"></textarea>
            @error('description')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
            <br>
        </div>

        <div>
            <label class="block font-medium font-bold text-slate-700" for="limit">Max. Repeticiones:</label>
            <input wire:model="limit" type="number" id="limit" name="limit" min=1 class="text-sm font-medium @error('name')border border-red @enderror" required>
            @error('limit')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
            <br>
        </div>

        <div>
            <label class="block font-medium font-bold text-slate-700" for="initialDate">Fecha de Inicio:</label>
            <input wire:model="initialDate" type="date" id="initialDate" name="initialDate">
            @error('initialDate')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
            <br>
        </div>
        
        <div>
            <label class="block font-medium font-bold text-slate-700" for="finalDate">Fecha de Fin:</label>
            <input wire:model="finalDate" type="date" id="finalDate" name="finalDate">
            @error('finalDate')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
            <br>
        </div>

        <div>
            <label class="block font-medium font-bold text-slate-700" for="frequencyOptions">Periodo:</label>
            <select wire:model="selectedFreOpt" id="frequencyOptions" class="text-sm font-medium @error('name')border border-red @enderror">
                <option value="">Seleccionar una opción</option>
                @foreach($frequencyOptions as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>
            @error('selectedFreOpt')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
            <br>
        </div>

        <button type="submit" 
        class="block w-full bg-blue-400 hover:bg-purple-700 text-white px-5 py-4 text-md font-semibold rounded">Create Task</button>
    </form>
</div>
