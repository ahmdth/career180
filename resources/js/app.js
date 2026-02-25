import 'plyr/dist/plyr.css';
import Plyr from 'plyr';
import toast from './toast';
import videoPlayer from './video';

Alpine.data('videoPlayer', videoPlayer);
window.Alpine.data('toast', toast);

window.Plyr = Plyr;
