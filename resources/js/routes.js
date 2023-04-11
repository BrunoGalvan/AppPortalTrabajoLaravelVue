import Dashboard from './Pages/Dashboard.vue';
import ListWorksplace from './Pages/Worksplace/ListWorksplace.vue';
import ListWorksplacePost from './Pages/Worksplace/ListWorksplacesPost.vue';

export const routes = [
    {
        name: 'dashboard',
        path: '/',
        component: Dashboard
    },
    {
        name: 'worksplaces',
        path: '/worksplaces',
        component: ListWorksplace
    },
    {
        name: 'worksplaces_post',
        path: '/worksplaces/post',
        component: ListWorksplacePost
    }
];