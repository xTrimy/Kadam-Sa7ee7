<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Audit Log') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Get user notifications --}}
                @foreach ($logs as $log)
                    @php
                        // get causer object
                        $causer = $log->causer_type::find($log->causer_id);
                        $subject = $log->subject_type::find($log->subject_id);
                        $subject_type = explode("\\",$log->subject_type);
                        $subject_type = end($subject_type);
                    @endphp
                    <div class="py-2 px-4">
                    @if($log->subject_type == 'App\Models\LoginLogger')
                        قام {{ $causer->name??"\"\"" }} بتسجيل الدخول في {{ $log->created_at }}
                    @else
                        @if($log->description == 'created')
                            {{ __(':causer created',["causer"=>$causer->name??'""']) }}
                        @else
                            {{ __(':causer updated',["causer"=>$causer->name??'""']) }}
                        @endif
                        {{ $subject->name??"\"\"" }} من نوع ({{ __($subject_type) }})
                        في {{ $log->created_at }}
                    @endif
                    </div>
                @endforeach
     
                <div class="p-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
