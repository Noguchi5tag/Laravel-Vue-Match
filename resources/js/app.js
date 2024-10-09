import './bootstrap';
import './data';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';

/****************************************************
 * FontAwesome のインポート
 ****************************************************/
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
    faRotateLeft ,
    faHouse,
    faBars,
    faThumbsUp as faThumbsUpSolid,
    faMagnifyingGlass,
    faComment,
    faThumbsUp,
    faBookmark,
    faChevronDown,
} from '@fortawesome/free-solid-svg-icons';
import { 
    faBell,
    faCircleUser,
    faBookmark as faBookmarkRegular,
    faThumbsUp as faThumbsUpRegular,
} from '@fortawesome/free-regular-svg-icons';
/* library にアイコンを追加 */
library.add(
    faRotateLeft, 
    faHouse, 
    faBars, 
    faBell, 
    faCircleUser,
    faBookmark,
    faBookmarkRegular,
    faThumbsUpSolid,
    faThumbsUpRegular,
    faMagnifyingGlass,
    faComment,
    faThumbsUp,
    faChevronDown,
);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} | ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
