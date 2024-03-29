<nav x-data="{ open: false }" class="bg-primary-dark border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-300" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:-my-px  ltr:sm:ml-10 rtl:sm:mr-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard.patients')" :active="request()->routeIs('dashboard.patients')">
                        {{ __('Patients') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard.hospitals')" :active="request()->routeIs('dashboard.hospitals')">
                        {{ __('Hospitals') }}
                    </x-nav-link>
                    @if(auth()->user()->hasPermissionTo('Add supplies'))
                    <x-nav-link :href="route('dashboard.supplies')" :active="request()->routeIs('dashboard.supplies')">
                        {{ __('Supplies') }}
                    </x-nav-link>
                    @endif
                    <x-nav-link :href="route('dashboard.users')" :active="request()->routeIs('dashboard.users')">
                        {{ __('Users') }}
                    </x-nav-link>
                    @if(auth()->user()->hasPermissionTo('Access to console page'))
                    <button class="group relative inline-flex items-center px-4 pt-1 border-b-4 border-transparent text-sm font-medium leading-5 text-gray-200 hover:text-gray-100 hover:border-white focus:outline-none focus:text-gray-300 focus:border-gray-300 transition duration-150 ease-in-out">
                            {{ __('Settings') }} <i class="las la-caret-down mx-2"></i>
                    <div class="hidden group-focus-within:block absolute top-full left-1/2 transform -translate-x-1/2 py-4 w-fit text-black bg-white">
                        <a class="block px-8 py-2 whitespace-nowrap hover:bg-gray-300">
                            {{ __('Website Settings') }}
                        </a>
                        <a href="{{ route('dashboard.settings.field_research') }}" class="block px-8 py-2 whitespace-nowrap hover:bg-gray-300">
                            {{ __('Field Research Settings') }}
                        </a>
                    </div>
                    </button>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-200 hover:text-white hover:border-gray-300 focus:outline-none focus:text-gray-300 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div class="overflow-hidden relative w-8 h-8 ltr:mr-2 rtl:ml-2 bg-gray-100 rounded-full dark:bg-gray-600">
                                <img src="https://doodleipsum.com/100/avatar" class="object-contain object-center w-full h-full" alt="">
                            </div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.patients')" :active="request()->routeIs('dashboard.patients')">
                {{ __('Patients') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.hospitals')" :active="request()->routeIs('dashboard.hospitals')">
                {{ __('Hospitals') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.supplies')" :active="request()->routeIs('dashboard.supplies')">
                {{ __('Supplies') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.users')" :active="request()->routeIs('dashboard.users')">
                {{ __('Users') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
