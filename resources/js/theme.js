export default {
    mode: localStorage.getItem('theme-mode') || 'system', // 'light' | 'dark' | 'system'
    icon: {
        light: 'sun',
        dark: 'moon',
        system: 'computer-screen'
    }[localStorage.getItem('theme-mode') || 'system'],

    init() {
        this.apply();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (this.mode === 'system') this.apply();
        });
    },

    toggle() {
        if (this.mode === 'light') this.set('dark');
        else if (this.mode === 'dark') this.set('system');
        else this.set('light');
    },

    set(mode) {
        this.mode = mode;
        localStorage.setItem('theme-mode', mode);
        this.apply();
    },

    isDark() {
        if (this.mode === 'system') {
            return window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        return this.mode === 'dark';
    },

    apply() {
        const isDark = this.isDark();
        document.documentElement.classList.toggle('dark', isDark);
    }
};

