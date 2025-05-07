<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        @if($appLogo)
                            <img src="{{ asset('storage/' . $appLogo) }}" alt="{{ config('app.name') }}" class="block h-9 w-auto">
                        @else
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        @endif
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate.hover>
                        <i class="fas fa-chart-line mr-2"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('cars.index')" :active="request()->routeIs('cars.*')" wire:navigate.hover>
                        <i class="fas fa-car mr-2"></i>
                        {{ __('Cars') }}
                    </x-nav-link>

                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs('documents.*') ? 'border-b-2 border-indigo-400' : '' }}">
                                    <i class="fas fa-file-alt mr-2"></i>
                                    <div>{{ __('Documents') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('documents.car.index')" wire:navigate.hover>
                                    <i class="fas fa-id-card mr-2"></i>
                                    {{ __('Car Documents') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('documents.company.index')" wire:navigate.hover>
                                    <i class="fas fa-building mr-2"></i>
                                    {{ __('Company Documents') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <x-nav-link :href="route('incomes.index')" :active="request()->routeIs('incomes.*')" wire:navigate.hover>
                        <i class="fas fa-arrow-circle-down mr-2 text-green-600"></i>
                        {{ __('Incomes') }}
                    </x-nav-link>

                    <x-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')" wire:navigate.hover>
                        <i class="fas fa-arrow-circle-up mr-2 text-red-600"></i>
                        {{ __('Expenses') }}
                    </x-nav-link>

                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" wire:navigate.hover>
                        <i class="fas fa-chart-bar mr-2 text-purple-600"></i>
                        {{ __('Reports') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <i class="fas fa-user-circle mr-1"></i>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" wire:navigate.hover>
                            <i class="fas fa-cog mr-2"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('settings.index')" wire:navigate.hover>
                            <i class="fas fa-cog mr-2"></i>
                            {{ __('Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate.hover>
                <i class="fas fa-chart-line mr-2"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('cars.index')" :active="request()->routeIs('cars.*')" wire:navigate.hover>
                <i class="fas fa-car mr-2"></i>
                {{ __('Cars') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('documents.car.index')" :active="request()->routeIs('documents.car.*')" wire:navigate.hover>
                <i class="fas fa-id-card mr-2"></i>
                {{ __('Car Documents') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('documents.company.index')" :active="request()->routeIs('documents.company.*')" wire:navigate.hover>
                <i class="fas fa-building mr-2"></i>
                {{ __('Company Documents') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('incomes.index')" :active="request()->routeIs('incomes.*')" wire:navigate.hover>
                <i class="fas fa-arrow-circle-down mr-2 text-green-600"></i>
                {{ __('Incomes') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')" wire:navigate.hover>
                <i class="fas fa-arrow-circle-up mr-2 text-red-600"></i>
                {{ __('Expenses') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" wire:navigate.hover>
                <i class="fas fa-chart-bar mr-2 text-purple-600"></i>
                {{ __('Reports') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" wire:navigate.hover>
                    <i class="fas fa-cog mr-2"></i>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('settings.index')" wire:navigate.hover>
                    <i class="fas fa-cog mr-2"></i>
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>