<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <a href="{{ route('todo.create') }}"
                    class="py-2 px-4 font-semibold rounded-lg shadow-md text-white bg-blue-500 hover:bg-blue-700">
                    Create Todo
                </a>
                <table class="table-auto w-full mt-5">
                    <tr>
                        <th class="border px-4 py-2" width="10%">ID</th>
                        <th class="border px-4 py-2" width="70%">Todo</th>
                        <th class="border px-4 py-2" width="30%">Action</th>
                    </tr>
                    @forelse ($todos as $todo)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $todo->id }}</td>
                        <td class="border px-4 py-2 text-center">{{ $todo->todo }}</td>
                        <td class="border px-4 py-2 text-center">
                        <a href="{{ route('todo.edit', $todo->id) }}">Edit</a>
                        <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('delete')
                            <button type="submit">
                                Delete
                            </button>
                        </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="border py-2 px-4 text-center">
                            No Data
                        </td>
                    </tr>
                        
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</x-app-layout>