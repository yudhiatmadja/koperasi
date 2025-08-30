
<style>
    @keyframes moonFloat {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-3px) rotate(-5deg); }
    }

    @keyframes sunRotate {
        0% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(90deg) scale(1.05); }
        50% { transform: rotate(180deg) scale(1); }
        75% { transform: rotate(270deg) scale(1.05); }
        100% { transform: rotate(360deg) scale(1); }
    }

    @keyframes sunGlow {
        0%, 100% { filter: drop-shadow(0 0 3px rgba(251, 191, 36, 0.6)); }
        50% { filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.8)); }
    }

    @keyframes moonGlow {
        0%, 100% { filter: drop-shadow(0 0 3px rgba(147, 197, 253, 0.5)); }
        50% { filter: drop-shadow(0 0 6px rgba(147, 197, 253, 0.7)); }
    }

    .moon-icon {
        animation: moonFloat 3s ease-in-out infinite, moonGlow 2s ease-in-out infinite;
    }

    .sun-icon {
        animation: sunRotate 4s linear infinite, sunGlow 2s ease-in-out infinite;
        transform-origin: center;
    }

    .theme-button:hover .moon-icon {
        animation-duration: 1.5s, 1s;
    }

    .theme-button:hover .sun-icon {
        animation-duration: 2s, 1s;
    }
</style>

<button
    x-data="{
        theme: localStorage.getItem('color-theme') || 'light',
        isToggling: false,
        toggleTheme() {
            this.isToggling = true;
            setTimeout(() => {
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                localStorage.setItem('color-theme', this.theme);
                if (this.theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                this.isToggling = false;
            }, 150);
        }
    }"
    @click="toggleTheme"
    class="theme-button p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-300 hover:scale-110 active:scale-95"
    :class="{ 'animate-pulse': isToggling }"
>
    <!-- Ikon Bulan (Muncul di Light Mode) -->
    <svg
        x-show="theme === 'light'"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 rotate-180 scale-50"
        x-transition:enter-end="opacity-100 rotate-0 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 rotate-0 scale-100"
        x-transition:leave-end="opacity-0 rotate-180 scale-50"
        class="w-6 h-6 moon-icon"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
    </svg>

    <!-- Ikon Matahari yang Lebih Bagus (Muncul di Dark Mode) -->
    <svg
        x-show="theme === 'dark'"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 rotate-180 scale-50"
        x-transition:enter-end="opacity-100 rotate-0 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 rotate-0 scale-100"
        x-transition:leave-end="opacity-0 rotate-180 scale-50"
        class="w-6 h-6 sun-icon"
        fill="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
    >
        <!-- Lingkaran tengah matahari -->
        <circle cx="12" cy="12" r="4" fill="currentColor"/>

        <!-- Sinar-sinar matahari -->
        <path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"/>
    </svg>
</button>
