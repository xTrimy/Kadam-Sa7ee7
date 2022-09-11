<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    {{-- Get number of unread notifications --}}
                    @php
                        $unreadNotifications = Auth::user()->unreadNotifications->count();
                    @endphp
                    <div class="flex items-center">
                        @if($unreadNotifications > 0)
                        <div class="w-8 h-8 flex justify-center items-center mx-4 rounded-full bg-red-500 text-white relative">
                            <div class="absolute  w-full h-full bg-red-500 rounded-full motion-safe:animate-ping "></div>
                            <div class="w-full h-full flex justify-center items-center absolute">{{ $unreadNotifications }}</div>
                        </div>
                        @endif
                        <p class="flex-1">{{ __("Latest Notifications") }}</p>
                    </div>
                </div>
                {{-- Get user notifications --}}
                @foreach ($notifications as $notification)
                <a href="{{ route('dashboard.notifications.redirect',$notification->id) }}">
                    <div class="p-8 flex items-center bg-gray-200 mb-2 cursor-pointer hover:bg-gray-300">
                        @if($notification->unread())<div class="w-4 h-4 mx-4 bg-red-500 rounded-full"></div>@endif
                        <div class="flex-1">
                            <p>
                                {{ $notification->data['message'] }}
                            </p>
                            @if(isset($notification->data['sub_message']))
                                <p class="text-sm text-gray-600">
                                    {{ $notification->data['sub_message'] }}
                                </p>
                            @endif
                            <p class="text-sm text-gray-600 flex items-center mt-4">
                                   <i class="las la-clock rtl:ml-1 ltr:mr-1"></i> {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </a>
                @endforeach
                <div class="p-4">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
