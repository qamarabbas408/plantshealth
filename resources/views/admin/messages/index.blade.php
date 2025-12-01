<x-public-layout>
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-serif font-bold text-gray-900">Support Inbox</h1>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-sm font-bold text-gray-500 hover:text-gray-900">&larr; Dashboard</a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sender</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($messages as $msg)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-900">{{ $msg->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $msg->email }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $msg->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    {{ $msg->subject }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                    {{ $msg->message }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.messages.delete', $msg->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this message?');">
                                        @csrf @method('DELETE')

                                        <button type="button"
                                            onclick="openDeleteModal(
                                                '{{ route('admin.messages.delete', $msg->id) }}', 
                                                'Delete Message?', 
                                                'Are you sure you want to delete this message?'
                                            )"
                                            class="text-xs font-bold text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-gray-500">No messages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $messages->links() }}</div>

        </div>
    </div>
</x-public-layout>
