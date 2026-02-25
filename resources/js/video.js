export default (progress = 0) => ({
    player: null,
    progressInterval: null,
    initPlayer() {
        this.player = new Plyr(this.$refs.video);
        // Set video progress if available
        if (progress > 0) {
            this.player.once('loadedmetadata', () => {
                this.player.currentTime = progress;
            });
        }

        // Start interval on play
        this.player.on('play', () => {
            if (this.progressInterval) clearInterval(this.progressInterval);
            this.progressInterval = setInterval(() => {
                const root = this.$root.closest('[wire\\:id]');
                if (root) {
                    const wireId = root.getAttribute('wire:id');
                    if (wireId && window.Livewire && window.Livewire.find) {
                        window.Livewire.find(wireId).call('trackProgress', this.player.currentTime);
                    }
                }
            }, 5000);
        });

        // Stop interval on pause or ended
        const stopInterval = () => {
            if (this.progressInterval) {
                clearInterval(this.progressInterval);
                this.progressInterval = null;
            }
        };
        this.player.on('pause', stopInterval);
        this.player.on('ended', () => {
            stopInterval();
            const root = this.$root.closest('[wire\\:id]');
            if (root) {
                const wireId = root.getAttribute('wire:id');
                if (wireId && window.Livewire && window.Livewire.find) {
                    window.Livewire.find(wireId).call('markAsCompleted');
                    window.Livewire.find(wireId).call('goToNextLesson');
                }
            }
        });
    },
});
