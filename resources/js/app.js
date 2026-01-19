import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import './theme.js';

Alpine.plugin(collapse);
window.Alpine = Alpine;

Alpine.start();
