<div {{ $attributes }} x-data="{
        dark: true,
        init() {
            const saved = localStorage.getItem('theme')

            if (saved === 'dark') {
                this.dark = true
            } else if (saved === 'light') {
                this.dark = false
            } else {
                this.dark = window.matchMedia('(prefers-color-scheme: dark)').matches
            }

            document.documentElement.classList.toggle('dark', this.dark)

            this.$watch('dark', value => {
                document.documentElement.classList.toggle('dark', value)
                localStorage.setItem('theme', value ? 'dark' : 'light')
            })
        }
    }">
    <flux:button @click="dark = !dark" variant="subtle" class="relative w-10 h-10 rounded-full p-2">
        <!-- Moon -->
        <span class="absolute transition-all duration-500" :class="dark
                ? 'rotate-0 scale-100 opacity-100'
                : 'rotate-90 scale-0 opacity-0'">
            <flux:icon.moon class="w-5 h-5 text-gray-400" />
        </span>

        <!-- Sun -->
        <span class="absolute transition-all duration-500" :class="dark
                ? '-rotate-90 scale-0 opacity-0'
                : 'rotate-0 scale-100 opacity-100'">
            <flux:icon.sun class="w-5 h-5 text-yellow-500" />
        </span>
    </flux:button>
</div>
