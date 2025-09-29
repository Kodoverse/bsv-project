<div class="h-full p-4 ">
    <nav class="flex flex-col justify-between h-full">
        <div>
            <h3 class="mb-4 text-xl font-semibold">Menu</h3>
            <a href="{{ route('dashboard') }}"
               class="flex items-center p-2 mb-3 rounded-md {{ request()->routeIs('dashboard') ? ' bg-gray-900 font-semibold' : 'hover:bg-gray-900' }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0l6-6m-6-6l-2-2"></path></svg>
                <span>Dashboard</span>
            </a>

            <button aria-controls="dropdownArticles" data-collapse-toggle="dropdownArticles" class="inline-flex items-center w-full p-2 mb-3 rounded-md focus:bg-gray-900 hover:bg-gray-900" type="button">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7M5 11h.01M19 11h.01"></path></svg>
                <span>Articles</span>
            </button>
            
            <!-- Dropdown menu -->
            <div id="dropdownArticles"class="hidden w-56 mb-3 space-y-2 bg-gray-900 divide-y divide-gray-100 rounded-lg shadow-md">
                <ul class="py-2 font-semibold text-white text-md" aria-labelledby="dropdownBottomButton">
                    <li>
                        <x-dropdown-link :href="route('articles.create')">
                            {{ __('Add Articles') }}
                        </x-dropdown-link>
                    </li>
                    <li>
                        <x-dropdown-link :href="route('articles.index')">
                            {{ __('View Articles') }}
                        </x-dropdown-link>
                    </li>
                    
                </ul>
            </div>

            <button aria-controls="dropdownComments" data-collapse-toggle="dropdownComments" class="inline-flex items-center w-full p-2 mb-3 rounded-md focus:bg-gray-900 hover:bg-gray-900" type="button">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7M5 11h.01M19 11h.01"></path></svg>
                <span>Comments</span>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownComments" class="hidden w-56 mb-3 space-y-2 bg-gray-900 divide-y divide-gray-100 rounded-lg shadow-md">
                <ul class="py-2 font-semibold text-white text-md" aria-labelledby="dropdownBottomButton">
                    <li>
                        <x-dropdown-link :href="route('comments.index')">
                            {{ __('All Comments') }}
                        </x-dropdown-link>
                    </li>
                    <li>
                        <x-dropdown-link :href="route('flagged_comments.index')">
                            {{ __('Flagged Comments') }}
                        </x-dropdown-link>
                    </li>
                    
                </ul>
            </div>
            
            <button aria-controls="dropdownTag" data-collapse-toggle="dropdownTags" class="inline-flex items-center w-full p-2 mb-3 rounded-md focus:bg-gray-900 hover:bg-gray-900" type="button">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7M5 11h.01M19 11h.01"></path></svg>
                <span>Tags</span>
            </button>
            
            <!-- Dropdown menu -->
            <div id="dropdownTags"class="hidden w-56 mb-3 space-y-2 bg-gray-900 divide-y divide-gray-100 rounded-lg shadow-md">
                <ul class="py-2 font-semibold text-white text-md" aria-labelledby="dropdownBottomButton">
                    <li>
                        <x-dropdown-link :href="route('tags.create')">
                            {{ __('Add Tags') }}
                        </x-dropdown-link>
                    </li>
                    <li>
                        <x-dropdown-link :href="route('tags.index')">
                            {{ __('View Tags') }}
                        </x-dropdown-link>
                    </li>
                    
                </ul>
            </div>
        </div>

        <div>
            
            <button id="dropdownTopButton" data-dropdown-toggle="dropdownTop" data-dropdown-placement="top" class="inline-flex items-center w-full p-2 mb-3 rounded-md focus:bg-gray-900 hover:bg-gray-900" type="button">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7M5 11h.01M19 11h.01"></path></svg>
                {{ Auth::user()->name }}
            </button>
            
            <!-- Dropdown menu -->
            <div id="dropdownTop" class="z-10 hidden w-56 bg-gray-900 divide-y divide-gray-100 rounded-lg shadow-md">
                <ul class="py-2 font-semibold text-white text-md" aria-labelledby="dropdownTopButton">
                    <li>
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    </li>
                    
                </ul>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
    
                <a class="block w-full p-2 rounded-md hover:bg-red-500 hover:font-semibold" :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>
        </div>

    </nav>
</div>