export default () => ({
    show: false,
    message: '',
    type: 'default',
    timeout: null,

    showToast(message, type = 'default', duration = 3000) {
        this.message = message;
        this.type = type;
        this.show = true;

        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => this.show = false, duration);
    },

    hide() {
        this.show = false;
    }
});
