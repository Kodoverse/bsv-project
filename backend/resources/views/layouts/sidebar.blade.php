<div class="p-4">
    <h3 class="mb-4 text-xl font-semibold">Menu</h3>
    <nav class="space-y-2">
        <a href="{{ route('dashboard') }}"
           class="flex items-center p-2 rounded-md {{ request()->routeIs('home') ? 'bg-gray-900 text-white font-semibold' : 'hover:bg-gray-700' }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0l6-6m-6-6l-2-2"></path></svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('articles.index') }}"
           class="flex items-center p-2 rounded-md {{ request()->routeIs('products.*') ? 'bg-gray-900 text-white font-semibold' : 'hover:bg-gray-700' }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7M5 11h.01M19 11h.01"></path></svg>
            <span>Articles</span>
        </a>
        <a href="{{ route('comments.index') }}"
           class="flex items-center p-2 rounded-md {{ request()->routeIs('products.*') ? 'bg-gray-900 text-white font-semibold' : 'hover:bg-gray-700' }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7M5 11h.01M19 11h.01"></path></svg>
            <span>Comments</span>
        </a>
        <a href="{{ route('tags.index') }}"
           class="flex items-center p-2 rounded-md {{ request()->routeIs('products.*') ? 'bg-gray-900 text-white font-semibold' : 'hover:bg-gray-700' }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7M5 11h.01M19 11h.01"></path></svg>
            <span>Tags</span>
        </a>
        <a href="{{ route('profile.edit') }}"
           class="flex items-center p-2 rounded-md {{ request()->routeIs('profile.edit') ? 'bg-gray-900 text-white font-semibold' : 'hover:bg-gray-700' }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Profile</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
    </nav>
</div>