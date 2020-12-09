<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <form action="{{ route('todo.update', $todo->id) }}" method="POST" >
                    @csrf
                    @method('put')
                    <div class="w-full">
                        <label class="blockc">
                            <span class="text-gray-700">Todo</span>
                        <input class="form-input mt-1 block w-full" placeholder="Todo" name="todo" type="text" value="{{$todo->todo}}">
                          </label>
                        <button class="mt-3 py-2 px-4 font-semibold rounded-lg shadow-md text-white bg-blue-500 hover:bg-blue-700" type="submit">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>