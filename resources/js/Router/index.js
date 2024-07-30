import { createRouter, createWebHistory } from "vue-router"

import Top from "../Pages/TopPage.vue"
import Search from "../Pages/SearchPage.vue"
import Dashboard from "../Pages/Dashboard.vue"
import Rules from "../Pages/RulesPage.vue"
import Privacy from "../Pages/PrivacyPage.vue"
import Contact from "../Pages/ContactPage.vue"
import Applied from "../Pages/AppliedPage.vue"
import Bookmark from "../Pages/BookmarkPage.vue"

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "top",
            component: Top
        },
        {
            path: "/search",
            name: "search",
            component: Search
        },
        {
            path: "/dashboard",
            name: "dashboard",
            component: Dashboard
        },
        {
            path: "/privacy",
            name: "privacy",
            component: Privacy
        },
        {
            path: "/rules",
            name: "rules",
            component: Rules
        },
        {
            path: "/contact",
            name: "contact",
            component: Contact
        },
        {
            path: "/dashboard/applied",
            name: "applied",
            components: {
                default: Applied,
                first: Applied,
                second: Bookmark
            }
        },
        {
            path: "/dashboard/bookmark",
            name: "bookmark",
            component: Bookmark
        },
    ]
})