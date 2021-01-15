<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mb-10 p-5">
                    <a href="{{ route('users.create') }}" class="bg-green-400 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        + Create User
                    </a>
                </div>
                <div class="bg-white">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border px-6 py-4">ID</th>    
                                <th class="border px-6 py-4">Name</th>    
                                <th class="border px-6 py-4">Email</th>    
                                <th class="border px-6 py-4">Roles</th>    
                                <th class="border px-6 py-4">Action</th>    
                            </tr>    
                        </thead>   
                        <tbody>
                            @forelse ($user as $item)
                                <tr>
                                <th class="border px-6 py-4">{{ $item->id }}</th>    
                                <th class="border px-6 py-4">{{ $item->name }}</th>    
                                <th class="border px-6 py-4">{{ $item->email }}</th>    
                                <th class="border px-6 py-4">{{ $item->roles }}</th>    
                                <th class="border px-6 py-4">
                                    <a href="{{ route('users.edit' , $item->id ) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded ">
                                        Edit
                                    </a>
                                    {{-- <form action="{{ route('users.destroy' , $item->id) }}" class="inline-block"> 
                                        {!! method_filed('delete') . crsf_filed() !!}
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded "></button>
                                    </form> --}}
                                </th>
                                </tr>
                                
                            @empty
                                <tr>
                                    <td colspan="5" class="border text-center p-5">
                                        Data tidak ditemukan
                                    </td>
                                </tr>
                                
                            @endforelse    
                        </tbody> 
                    </table>    
                </div>    
                <div class="text-center mt-5">
                    {{ $user->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
