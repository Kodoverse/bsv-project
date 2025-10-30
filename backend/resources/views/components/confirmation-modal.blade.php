<div x-show="open" class="fixed inset-0 z-40 flex items-center justify-center bg-black/50" x-transition
    @click.self="open = false" @keydown.escape.window="open = false">
    <div class="w-full max-w-sm p-6 bg-white shadow-xl dark:bg-gray-800 rounded-2xl" x-transition>
        
        <header>
            <h2 class="flex justify-center mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">
                {{ $header }}
            </h2>
        </header>

        <main>
            <!-- Toggle stato -->
            <div class="flex items-center mb-6">
                <span class="text-gray-700 dark:text-gray-300">
                    {{ $body }}
                </span>
            </div>
        </main>

        <footer>
            <!-- Pulsanti -->
            
            <div class="flex justify-center gap-3">
                {{ $footer }}
            </div>
        </footer>
    
    </div>
</div>
